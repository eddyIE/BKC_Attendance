<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Course;
use App\Models\Lesson;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AttendanceController extends Controller
{
    // Các thời gian ca học bắt đầu và kết thúc
    // Vẫn được điểm nhanh sau khi kết thúc ca 30p
    private const MORNING_SHIFT_START = "08:00";
    private const MORNING_SHIFT_END = "12:00";
    private const MORNING_SHIFT_SOFT_END = "12:30";

    private const AFTERNOON_SHIFT_START = "13:00";
    private const AFTERNOON_SHIFT_END = "17:00";
    private const AFTERNOON_SHIFT_SOFT_END = "17:30";

    private const EVENING_SHIFT_START = "18:00";
    private const EVENING_SHIFT_END = "21:00";
    private const EVENING_SHIFT_SOFT_END = "21:30";

    // ============================  XỬ LÝ ĐIỂM DANH ==========================
    /*
     * Xử lí request điểm danh
     */
    public function createAttendance(Request $request)
    {
        // Check có phải request update điểm danh buổi học trong lịch sử ko?
        // Có thì gọi method updateAttendance rồi return luôn
        if (isset($request->all()['prev-lesson-id'])) {

            self::updateAttendance($request);

            $request->request->add(['course-id' => $request->{'current-course-id'}]);
            Session::flash('type', 'success');
            Session::flash('message', 'Thay đổi điểm danh thành công');
            return (new LecturerController)->getCourseData($request);
        }

        // Check xem buổi học đã tồn tại chưa
        $lesson = null;
        if (auth()->user()->role == 1) {
            // Request từ giáo vụ có quyền chọn ngày điểm danh (lesson-date)
            $lesson = $this->getExistLesson($request->{'current-course-id'},
                $request->{'lesson-date'});
        } else if (auth()->user()->role == 0) {
            $lesson = $this->getExistLesson($request->{'current-course-id'});
        }

        // Nếu buổi học đã tồn tại
        if ($lesson != null) {
            $lessonId = $lesson->id;
            // Update giờ đã dạy của course
            self::updateCourseFinishedTimeAndLesson($request, $lesson);
            // Update thời lượng buổi học, note, người chỉnh sửa, v.v.
            self::updateLesson($request, $lesson);
            // Xóa các bản ghi điểm danh cũ, sẽ tạo lại sau
            Attendance::where('lesson_id', $lesson->id)->delete();
        } // Chưa tồn tại buổi học thì tạo mới
        else {
            $lessonId = self::createLesson($request);

            if (!$lessonId) {
                // Nếu buổi học mới không valid thì quay về màn hình điểm danh
                // (e.g: Giảng viên đang dạy lớp khác, shift với time không khớp)
                $request->request->add(
                    ['course-id' => $request->{'current-course-id'}]);
                return (new LecturerController)->getCourseData($request);
            }

            // Tăng số buổi, giờ đã dạy của course
            self::updateCourseFinishedTimeAndLesson($request);
        }

        // Tạo (tạo lại) các bản ghi điểm danh
        $data = array();
        $students = $request->{'students'};
        foreach ($students as $student) {
            if (!is_null($student["status"])) {
                $attendance = new Attendance();
                $attendance->student_id = $student['student_id'];
                $attendance->attendant_status = $student['status'];
                $attendance->note = $student['absent_reason'];
                $attendance->lesson_id = $lessonId;
                $attendance->created_by = Auth::user()->id;
                $attendance->created_at = Carbon::now();
                $data[] = $attendance->attributesToArray();
            }
        }
        //Insert bulk cho nhanh
        Attendance::insert($data);

        // Thêm request param và chuyển hướng lại màn điểm danh
        $request->request->add(['course-id' => $request->{'current-course-id'}]);
        Session::flash('type', 'success');
        Session::flash('message', 'Điểm danh thành công');
        return (new LecturerController)->getCourseData($request);
    }

    /*
     * Cập nhật buổi học
     */
    private function updateLesson(Request $request, &$updatedLesson)
    {
        $updatedLesson->start = $request->start;
        $updatedLesson->end = $request->end;
        $updatedLesson->note = $request->note;
        $updatedLesson->lecturer_id = Auth::user()->id;
        $updatedLesson->modified_by = Auth::user()->id;
        $updatedLesson->updated_at = Carbon::now();

        $updatedLesson->save();
    }

    /*
     * Tạo mới buổi học
     */
    private function createLesson(Request $request)
    {
        // Validate giảng viên có đang dạy lớp nào khác không
        if (!self::validateLecturerOneCoursePerShift($request->{'current-course-id'})) {
            Session::flash('type', 'error');
            Session::flash('message', 'Giảng viên đang dạy một lớp khác');
            return false;
        }
        // Validate giờ và ca học có khớp không
        if (!self::validateShiftAndTime($request)) {
            Session::flash('type', 'error');
            Session::flash('message', 'Ca học và giờ học không trùng');
            return false;
        }

        // Tạo buổi học mới
        $newLesson = new Lesson();
        $newLesson->start = $request->start;
        $newLesson->end = $request->end;
        $newLesson->note = $request->note;
        $newLesson->lecturer_id = Auth::user()->id;
        $newLesson->course_id = $request->{'current-course-id'};
        $newLesson->created_by = Auth::user()->id;
        $newLesson->shift = $request->{'shift'};
        // Nếu là giáo vụ điểm danh hộ thì cho chọn ngày
        if (auth()->user()->role == 1) {
            $newLesson->created_at = $request->{'lesson-date'};
        }

        $newLesson->save();

        return $newLesson->id;
    }

    /*
     * Xử lí cập nhật số giờ, số buổi đã dạy của một khóa học
     */
    private function updateCourseFinishedTimeAndLesson($request, $prevLesson = null)
    {
        // Xử lí lấy các thông tin cơ bản
        $start = $request->start;
        $end = $request->end;
        $courseId = $request->{'current-course-id'};

        // Tính thời lượng buổi học
        // và làm tròn đến góc phần tư gần nhất (.0, .25, .5, .75)
        $lessonDuration = strtotime($start) - strtotime($end);
        $lessonDuration = floor(
                round(abs($lessonDuration) / 3600, 2) * 4) / 4;

        // Nếu buổi học đã tồn tại thì update thời lượng
        if ($prevLesson != null) {
            // Xử lí khác biệt về thời lượng so với bản ghi đã có trước:
            // Tính thời lượng giờ bản ghi cũ
            $prevLessonDuration = strtotime($prevLesson->end) - strtotime($prevLesson->start);
            $prevLessonDuration = floor(
                    round(abs($prevLessonDuration) / 3600, 2) * 4) / 4;
            // Thời lượng mới - thời lượng cũ ra khác biệt để update
            $newDuration = $lessonDuration - $prevLessonDuration;
            // Cập nhật và số giờ đã dạy mà ko làm tăng số buổi đã học
            $course = Course::find($courseId);
            $course->finished_hours += $newDuration;
        } // Nếu buổi học chưa tồn tại
        else {
            //Cập nhật số buổi và số giờ đã dạy
            $course = Course::find($courseId);
            $course->finished_hours += $lessonDuration;
            $course->finished_lessons += 1;
        }

        $course->save();
    }

    /*
    * Xem giờ thực tế để suy ra ca học hiện tại
    * Return: Ca sáng - 0, Ca chiều - 1, Ca tối - 2, Không phải giờ học - 4
    */
    public function getCurrentShift(): int
    {
        $curTime = Carbon::now("Asia/Ho_Chi_Minh");

        if ($curTime >= Carbon::parse(self::MORNING_SHIFT_START) &&
            $curTime < Carbon::parse(self::MORNING_SHIFT_SOFT_END)) {
            $shift = 0;
        } else if ($curTime >= Carbon::parse(self::AFTERNOON_SHIFT_START) &&
            $curTime < Carbon::parse(self::AFTERNOON_SHIFT_SOFT_END)) {
            $shift = 1;
        } else if ($curTime >= Carbon::parse(self::EVENING_SHIFT_START) &&
            $curTime < Carbon::parse(self::EVENING_SHIFT_SOFT_END)) {
            $shift = 2;
        } else {
            $shift = 4;
        }
        return $shift;
    }

    /*
     * Check nếu có buổi học trùng đã tồn tại (dựa theo ca học và ngày học)
     * Nếu có: return buổi học đó
     * Nếu không: return null
     */
    public function getExistLesson($courseId, $lessonDate = null)
    {
        $curShift = self::getCurrentShift();
        // Không có ngày thì set là ngày hiện tại
        if ($lessonDate == null) {
            $lessonDate = Carbon::now("Asia/Ho_Chi_Minh")->toDateString();
        }

        $existLesson = Lesson::where('course_id', $courseId)
            ->where('created_at', 'like', '%' . $lessonDate . '%')
            ->where('shift', $curShift)
            ->first();

        if ($existLesson != null) {
            return $existLesson;
        } else {
            return null;
        }
    }

    /*
     * Update điểm danh cho một buổi học trong lịch sử
     */
    private function updateAttendance(Request $request)
    {
        // Lấy lesson id buổi học trước cần update
        $lessonId = $request->all()['prev-lesson-id'];

        // Lấy các bản ghi điểm danh cũ
        $oldAttendance = Attendance::where('lesson_id', $lessonId)->get();

        // Biến flag có tại vì trước đây các sinh viên đi học sẽ không được thêm bản ghi Attendance vào DB
        // Giờ sẽ check nếu inh viên không tồn tại bản ghi trước đó thì sẽ tạo mới thay vì chỉ update
        $flag = false;
        // Tạo lại các bản ghi điểm danh
        $data = array();
        $students = $request->{'students'};
        foreach ($students as $student) {
            if (!is_null($student["status"])) {
                $flag = false;
                foreach ($oldAttendance as $attendance) {
                    if ($attendance->student_id == $student['student_id']) {
                        $attendance->attendant_status = $student['status'];
                        $attendance->note = $student['absent_reason'];
                        $attendance->lesson_id = $lessonId;
                        $attendance->modified_by = Auth::user()->id;
                        $attendance->updated_at = Carbon::now();
                        $data[] = $attendance->attributesToArray();
                        $flag = true;
                        $attendance->save();
                    }
                }
                // Bản ghi trước đó không tồn tại
                if(!$flag){
                    $newAttendance = new Attendance();
                    $newAttendance->student_id = $student['student_id'];
                    $newAttendance->attendant_status = $student['status'];
                    $newAttendance->note = $student['absent_reason'];
                    $newAttendance->lesson_id = $lessonId;
                    $newAttendance->created_by = count($oldAttendance) > 0 ? $oldAttendance[0]->created_by : Auth::user()->id;
                    $newAttendance->created_at = count($oldAttendance) > 0 ?$oldAttendance[0]->created_at : Carbon::now();
                    $newAttendance->modified_by = Auth::user()->id;
                    $newAttendance->updated_at = Carbon::now();
                    $data[] = $newAttendance->attributesToArray();
                    $newAttendance->save();
                }
            }
        }
//        Attendance::updateOrCreate($data);
    }

    /*
    * Validate ca học và giờ bắt đầu, kết thúc
    * VD: Ca sáng thì chỉ bắt đầu từ 8h, kết thúc trước 12h01
    */
    private function validateShiftAndTime(Request $request): bool
    {
        // Lấy các thông tin từ request
        $shift = $request->{'shift'};
        $start = $request->start;
        $end = $request->end;

        // Ca sáng - 0; Ca chiều - 1; Ca tối - 2
        if ($shift == 0) {
            if (Carbon::parse($start) >= Carbon::parse(self::MORNING_SHIFT_START) &&
                Carbon::parse($end) <= Carbon::parse(self::MORNING_SHIFT_END)) {
                return true;
            }
        } else if ($shift == 1) {
            if (Carbon::parse($start) >= Carbon::parse(self::AFTERNOON_SHIFT_START) &&
                Carbon::parse($end) <= Carbon::parse(self::AFTERNOON_SHIFT_END)) {
                return true;
            }
        } else if ($shift == 2) {
            if (Carbon::parse($start) >= Carbon::parse(self::EVENING_SHIFT_START) &&
                Carbon::parse($end) <= Carbon::parse(self::EVENING_SHIFT_END)) {
                return true;
            }
        }
        return false;
    }

    /*
     * Check một giảng viên chỉ được dạy một ca một lớp
     */
    private function validateLecturerOneCoursePerShift($courseId): bool
    {
        // Giáo vụ thì ko check
        if (auth()->user()->role == 1) {
            return true;
        }

        $curShift = self::getCurrentShift();
        $curDate = Carbon::now("Asia/Ho_Chi_Minh")->toDateString();

        $lessons = Lesson::where('created_by', Auth::user()->id)
            ->where('shift', $curShift)
            ->where('created_at', 'like', '%' . $curDate . '%')
            ->get();

        if (count($lessons) == 0) {
            return true;
        }
        return false;
    }
}
