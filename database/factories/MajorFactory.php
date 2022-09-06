<?php

namespace Database\Factories;

use App\Models\Major;
use Illuminate\Database\Eloquent\Factories\Factory;

class MajorFactory extends Factory
{
    protected $model = Major::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $name = [
            'CS' => 'Khoa học máy tính',
            'IT' => 'Công nghệ thông tin',
            'DC&CN' =>'Mạng máy tính và truyền thông dữ liệu',
            'CE' => 'Kỹ thuật máy tính',
            'NT' => 'Kỹ thuật mạng',
            'SE' => 'Công nghệ phần mềm',
            'MIS' => 'Hệ thống thông tin quản lý',
            'AI' => 'Trí tuệ nhân tạo',
            'GD' => 'Thiết kế đồ họa',
        ];
        $rand_name = $this->faker->randomElement($name);
        $rand_codename = array_search($rand_name,$name);
        return [
            'name' => $rand_name,
            'codeName' => $rand_codename,
        ];
    }
}
