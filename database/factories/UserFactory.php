<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    protected $model = User::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $name = [
            "Trương Duy Anh",
            "Hồ Thanh Bình",
            "Ngô Mạnh Cường",
            "Nguyễn Thị Kỳ Duyên",
            "Đỗ Thuỳ Dương",
            "Nguyễn Quốc Đạt",
            "Nguyễn Thu Hà",
            "Khưu Quốc Anh Hào",
            "Nguyễn Thị Kim Hoàng",
            "Phan Quốc Huy",
            "Nguyễn Quốc Khang",
            "Đậu Đức Khuyên",
            "Vũ Hoàng Kiên",
            "Nguyễn Thị Phương Linh",
            "Nguyễn Tấn Lộc",
            "Phan Quang Minh",
            "Đặng Hoàng Mai",
            "Bùi Thị Ngọc",
            "Nguyễn Thị Thảo Nguyên",
            "Trần Thị Bích Nhi",
            "Nguyễn Huỳnh Như",
            "Ngô Thị Thiên Như",
            "Nguyễn Hoàng Phi",
            "Huỳnh Ngọc Vũ Phương",
            "Phùng Thái Sang",
            "Đặng Anh Tài",
            "Nguyễn Quốc Thái",
            "Bùi Văn Thái",
            "Nguyễn Thị Thu Thảo",
            "Lê Anh Thư",
            "Vương Minh Thư",
            "Bùi Thị Mộng Thường",
            "Phạm Hữu Toàn",
            "Nguyễn Vũ Huyền Trang",
            "Huỳnh Ngọc Mai Trinh",
            "Nguyễn Văn Thành Trung",
            "Nguyễn Lê Minh Tú",
            "Nguyễn Thị Ngọc Vàng",
            "Nguyễn Trương Tường Vy",
            "Lê Thạch Yến Vy", "Nguyễn Hùng Anh",
            "Nguyễn Việt Quốc Anh",
            "Lê Tiết Anh",
            "Nguyễn Thị Hồng Ân",
            "Phan Văn Cường",
            "Hà Thị Ngọc Diệp",
            "Trần Cẩm Duyên",
            "Phạm Thị Thuỳ Dương",
            "Nguyễn Thị Mai Đào",
            "Nguyễn Ngọc Hương Giang",
            "Lê Ngọc Giàu",
            "Nguyễn Phương Gia Hân",
            "Lê Nguyễn Phúc Hậu",
            "Nguyễn Thị Thu Hường",
            "Văn Tuấn Kiệt",
            "Vũ Tuấn Kiệt",
            "Trần Thị Ngọc Linh",
            "Nguyễn Thanh Long",
            "Lê Nhật Minh",
            "Thân Hoài Nam",
            "Nguyễn Thị Hồng Ngân",
            "Nguyễn Ngọc Phương Nghi",
            "Lê Thị Hồng Ngọc",
            "Dương Hoàng Bảo Nhi",
            "Hà Thị Yến Nhi",
            "Võ Thị Hồng Nhung",
            "Nguyễn Ngọc Tố Như",
            "Nguyễn Thanh Phong",
            "Nghuyễn Thị Như Quỳnh",
            "Phạm Thanh Sơn",
            "Văn Thành Tài",
            "Phạm Quốc Thái",
            "Lê Thị Tho",
            "Nguyễn Anh Thư",
            "Nguyễn Thị Minh Thư",
            "Võ Thị Minh Thư",
            "Nguyễn Hoàng Trung Tín",
            "Võ Trần Hiếu Trung",
            "Lý Hùng Trung",
            "Hoàng Thị Hồng Tươi",
            "Nguyễn Trọng Hoài Văn",
            "Nguyễn Ngọc Khánh Vy",
            "Nguyễn Nhật Vy",
            "Mai Như Ý",
            "Trần Diễm Anh",
            "Nguyễn Hoàng Mỹ Anh",
            "Nguyễn Tiến Bắc",
            "Võ Thị Kim Chi",
            "Hồ Khánh Duy",
            "Nguyễn Ngọc Hà",
            "Đoàn Trí Hải",
            "Nguyễn Thị Mỹ Hạnh",
            "Trịnh Ngọc Hạnh",
            "Phạm Gia Hân",
            "Bùi Minh Hoàng",
            "Ngô Minh Hùng",
            "Nguyễn Thị Ngọc Huyền",
            "Hà Ngọc Hương",
            "Ngô Thị Thúy Kiều",
            "Trần Thị Ngọc Linh",
            "Phạm Thanh Loan",
            "Lê Nguyễn Mẫn",
            "Lê Diễm My",
            "Nguyễn Kim Ngân",
            "Trần Tiến Nhân",
            "Vương Thị Tú Nhi",
            "Nguyễn Thị Yến Nhi",
            "Trần Thanh Phong",
            "Phùng Duy Quang",
            "Nguyễn Trí Quý",
            "Nguyễn Thị Tuyết Quyên",
            "Ngô Thị Như Quỳnh",
            "Đặng Nguyễn Trúc Quỳnh",
            "Nguyễn Minh Sang",
            "Nguyễn Phương Tâm",
            "Nguyễn Trọng Tấn",
            "Phan Thanh Thảo",
            "Đỗ Thị Thu Thảo",
            "Nguyễn Thị Kim Thu",
            "Nguyễn Minh Thy",
            "Ben Thị Hà Tiên",
            "Lưu Thị Huyền Trang",
            "Đào Thị Thùy Trang",
            "Nguyễn Thị Phương Trâm",
            "Lê Huỳnh Bảo Trân",
            "Cao Thị Việt Trinh",
            "Từ Dương Trường",
            "Thái Thanh Tùng",
            "Võ Quốc Vinh",
        ];
        return [
            'username' => $this->faker->userName,
            'password' => 'e10adc3949ba59abbe56e057f20f883e',
            'full_name' => $this->faker->randomElement($name),
            'phone' => $this->faker->phoneNumber,
            'gender' => $this->faker->boolean,
        ];
    }
}
