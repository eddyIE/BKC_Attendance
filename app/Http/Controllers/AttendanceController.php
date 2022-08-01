<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Course;
use App\Models\Lesson;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    // ============================  XỬ LÝ ĐIỂM DANH ==========================
    public function createAttendance(Request $request)
    {
        // TODO: Check buổi học đã tồn tại thì gọi Update
        $lessonId = $this->lessonIsExist($request->{'current-course-id'});

        // Nếu buổi học đã tồn tại
        if ($lessonId != null) {
            self::updateLesson($request, $lessonId);
            // Update giờ đã dạy của course dựa theo thời lượng bản ghi trước
            self::courseFinishedTimeAndLessonHandler($request, $lessonId);

            // Xóa các bản ghi điểm danh cũ
            Attendance::where('lesson_id', $lessonId)->delete();
        }
        // Chưa tồn tại buổi học thì tạo mới
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

        return redirect('/course');
    }

    // Cập nhật buổi học
    private function updateLesson(Request $request, $lessionId)
    {
        $updatedLesson = Lesson::find($lessionId);
        $updatedLesson->start = self::getLessonStart($request);
        $updatedLesson->end = self::getLessonEnd($request);
        $updatedLesson->note = $request->note;
        $updatedLesson->lecturer_id = Auth::user()->id;
        $updatedLesson->modified_by = Auth::user()->id;

        $updatedLesson->save();
    }

    // Tạo mới buổi học
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
     * Method dùng để xử lí cập nhật số giờ,
     * số buổi đã dạy của một khóa học
     */
    private function courseFinishedTimeAndLessonHandler($request, $lessonId = null)
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
        if ($lessonId != null) {
            // Xử lí khác biệt về thời lượng so với bản ghi đã có trước:
            // Tính thời lượng giờ bản ghi cũ
            $prevLesson = Lesson::find($lessonId);
            $prevLessonDuration = strtotime($prevLesson->end) - strtotime($prevLesson->start);
            $prevLessonDuration = floor(
                    round(abs($prevLessonDuration) / 3600, 2) * 4) / 4;
            // Thời lượng mới - thời lượng cũ ra khác biệt để update
            $newDuration = $lessonDuration - $prevLessonDuration;

            // Cập nhật và số giờ đã dạy mà ko làm tăng số buổi đã học
            $course = Course::find($courseId);
            $course->finished_hours += $newDuration;
            $course->save();
        } // Nếu buổi học chưa tồn tại
        else {
            //Cập nhật số buổi và số giờ đã dạy
            $course = Course::find($courseId);
            $course->finished_hours += $lessonDuration;
            $course->finished_lessons += 1;
            $course->save();
        }
    }

    private function getShift()
    {
        // Các thời gian ca học bắt đầu và kết thúc
        // Vẫn được điểm nhanh sau khi kết thúc ca 30p
        define("MORNING_SHIFT_START", "08:00");
        define("MORNING_SHIFT_END", "12:30");
        define("AFTERNOON_SHIFT_START", "13:00");
        define("AFTERNOON_SHIFT_END", "17:30");
        define("EVENING_SHIFT_START", "18:00");
        define("EVENING_SHIFT_END", "21:30");

        $curTime = Carbon::now("Asia/Ho_Chi_Minh");

        if ($curTime > Carbon::parse(MORNING_SHIFT_START) &&
            $curTime < Carbon::parse(MORNING_SHIFT_END)) {
            $shift = 0;
        } else if ($curTime > Carbon::parse(AFTERNOON_SHIFT_START) &&
            $curTime < Carbon::parse(AFTERNOON_SHIFT_END)) {
            $shift = 1;
        } else if ($curTime > Carbon::parse(EVENING_SHIFT_START) &&
            $curTime < Carbon::parse(EVENING_SHIFT_END)) {
            $shift = 2;
        } else {
            $shift = 4;
        }
        return $shift;
    }

    public function lessonIsExist($courseId)
    {
        // Check buổi học có tồn tại chưa (yếu tố: ca học, ngày học)
        $shift = self::getShift();
        $curDate = Carbon::now("Asia/Ho_Chi_Minh")->toDateString();

        $curLesson = Lesson::where('course_id', $courseId)
            ->where('created_at', 'like', '%' . $curDate . '%')
            ->where('shift', $shift)
            ->first();

        if ($curLesson != null) {
            return $curLesson->id;
        }
        return null;
    }

    private function getLessonStart(Request $request)
    {
        return $request->start['hour'] . ":" . $request->start['minutes'];
    }

    private function getLessonEnd(Request $request)
    {
        return $request->end['hour'] . ":" . $request->end['minutes'];
    }

}
