<?php

namespace App\Exports;

use App\Models\Classes;
use App\Models\Course;
use App\Models\StudentDTO;
use Illuminate\Database\Eloquent\Collection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class AttendanceExport implements FromCollection, WithHeadings, ShouldAutoSize, WithStyles
{
    use Exportable;

    public function __construct(int $courseId, array $studentDTOs)
    {
        $this->course_id = $courseId;
        $this->studentDTOs = $studentDTOs;
    }

    public function collection()
    {
        $data = new Collection();

        // Lấy thông tin khóa học
        $curCourse = Course::find($this->course_id);

        // Duyệt qua ds sinh viên để tính % buổi nghỉ
        foreach ($this->studentDTOs as $student) {

            // Tạo object mới và thêm các thông tin cơ bản
            $newStudent = new StudentDTO();
            $newStudent->code = $student->code;
            $newStudent->full_name = $student->full_name;
            $newStudent->birthdate = $student->birthdate;
            // Số buổi nghỉ
            $newStudent->absentQuan = $student->absentQuan;
            // Số buổi nghỉ có phép
            $newStudent->permissionQuan = $student->permissionQuan;
            // Lấy tên lớp
            $newStudent->class_name = Classes::find($student->class_id)->name;

            // Tính % nghỉ và làm tròn
            $newStudent->absentPercentage = $student->absentQuan / $curCourse->finished_lessons * 100;
            $newStudent->absentPercentage = number_format((float)$newStudent->absentPercentage, 2);

            // Nghỉ quá 50% học lại, quá 30% thi lại
            if ($newStudent->absentPercentage > 50) {
                $newStudent->qualify = "Học lại";
            } else if ($newStudent->absentPercentage > 30) {
                $newStudent->qualify = "Thi lại";
            } else {
                $newStudent->qualify = "Đủ điều kiện";
            }

            // Thêm model vào kết quả
            $data->push($newStudent);
        }
        return $data;
    }

    // Cột heading
    public function headings(): array
    {
        return ['Mã sinh viên', "Họ và tên", "Ngày sinh", "Số buổi nghỉ", "Số buổi nghỉ có phép",
            "Lớp", "Chuyên cần (%)", "Kết luận"];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text.
            1 => [
                'font' => [
                    'bold' => true,
                    'size' => 12
                ],
                'height' => 50,
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => [
                        'rgb' => 'b2daf7'
                    ]
                ]
            ]
        ];
    }
}
