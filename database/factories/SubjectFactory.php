<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class SubjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $name = [
            'Tin học cơ bản',
            'Lập trình nâng cao',
            'Cấu trúc dữ liệu & giải thuật',
            'Lập trình hướng đối tượng',
            'Kiến trúc máy tính',
            'Nguyên lí hệ điều hành',
            'Cơ sở dữ liệu',
            'Mạng máy tính',
            'Thiết kế giao diện người dùng',
            'Nguyên lý ngôn ngữ lập trình',
            'Kiểm thử & đảm bảo chất lượng phần mềm',
            'Phát triển phần mềm',
            'Lập trình nhúng',
            'Phân tích & thiết kế hệ thống',
            'Quản lý dự án phần mềm',
            'Cơ sở dữ liệu nâng cao',
        ];
        return [
            'name' => $this->faker->randomElements($name),
            'recommend_hours' => $this->faker->randomElements([30,45,60,75])
        ];
    }
}
