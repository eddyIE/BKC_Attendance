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
        // Check xem buổi học đã tồn tại chưa
        $lesson = $this->getExistLesson($request->{'current-course-id'});

        // Nếu buổi học đã tồn tại
        if ($lesson != null) {
            $lessonId = $lesson->id;
            self::updateLesson($request, $lesson);
            // Update giờ đã dạy của course dựa theo thời lượng bản ghi trước
            self::courseFinishedTimeAndLessonHandler($request, $lesson);

            // Xóa các bản ghi điểm danh cũ
            Attendance::where('lesson_id', $lesson->id)->delete();
        } // Chưa tồn tại thì tạo mới
        else {
            $lessonId = self::createLesson($request);
            // Tăng số buổi, giờ đã dạy của course
            self::courseFinishedTimeAndLessonHandler($request);
        }

        // Tạo (tạo lại) các bản ghi điểm danh
        $data = $request->{'students'};
        foreach ($data as $student) {
            if (!is_null($student["status"])) {
                $attendance = new Attendance();
                $attendance->student_id = $student['student_id'];
                $attendance->attendant_status = $student['status'];
                $attendance->note = $student['absent_reason'];
                $attendance->lesson_id = $lessonId;
                $attendance->created_by = Auth::user()->id;
                $attendance->save();
            }
        }

        // Thêm request param
        $request->request->add(['course-id' => $request->{'current-course-id'}]);
        Session::flash('alert', 'Lưu điểm danh thành công');
        return (new LecturerController)->courseDetail($request);
    }

    /*
     * Cập nhật buổi học
     */
    private function updateLesson(Request $request, &$updatedLesson)
    {
        $updatedLesson->start = self::getLessonStart($request);
        $updatedLesson->end = self::getLessonEnd($request);
        $updatedLesson->note = $request->note;
        $updatedLesson->lecturer_id = Auth::user()->id;
        $updatedLesson->modified_by = Auth::user()->id;

        $updatedLesson->save();
    }

    /*
     * Tạo mới buổi học
     */
    private function createLesson(Request $request)
    {
        $newLesson = new Lesson();
        $newLesson->start = self::getLessonStart($request);
        $newLesson->end = self::getLessonEnd($request);
        $newLesson->note = $request->note;
        $newLesson->lecturer_id = Auth::user()->id;
        $newLesson->course_id = $request->{'current-course-id'};
        $newLesson->created_by = Auth::user()->id;
        $newLesson->shift = $request->{'shift'};

        $newLesson->save();

        return $newLesson->id;
    }

    /*
     * Xử lí cập nhật số giờ, số buổi đã dạy của một khóa học
     */
    private function courseFinishedTimeAndLessonHandler($request, $prevLesson = null)
    {
        // Xử lí lấy các thông tin cơ bản
        $start = self::getLessonStart($request);
        $end = self::getLessonEnd($request);
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
    private function getShift(): int
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
     * Check nếu có tồn tại buổi học trùng ca học + ngày điểm danh
     * Nếu có: return buổi học đó
     * Nếu không: return null
     */
    public function getExistLesson($courseId)
    {
        // Check buổi học có tồn tại chưa (yếu tố: ca học, ngày học)
        $shift = self::getShift();
        $curDate = Carbon::now("Asia/Ho_Chi_Minh")->toDateString();

        $existLesson = Lesson::where('course_id', $courseId)
            ->where('created_at', 'like', '%' . $curDate . '%')
            ->where('shift', $shift)
            ->first();

        if ($existLesson != null) {
            return $existLesson;
        }
        return null;
    }

    /*
     * Đọc request ghép chuỗi giờ phút bắt đầu buổi học
     */
    private function getLessonStart(Request $request): string
    {
        return $request->start['hour'] . ":" . $request->start['minutes'];
    }

    /*
     * Đọc request ghép chuỗi giờ phút kết thúc buổi học
     */
    private function getLessonEnd(Request $request): string
    {
        return $request->end['hour'] . ":" . $request->end['minutes'];
    }

    /*
     * Validate ca học và giờ bắt đầu, kết thúc
     * VD: Ca sáng thì chỉ bắt đầu từ 8h, kết thúc trước 12h01
     */
    private function shiftAndTimeValidate(Request $request): bool
    {
        // Lấy các thông tin từ request
        $shift = $request->{'shift'};
        $start = self::getLessonStart($request);
        $end = self::getLessonEnd($request);

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
}
