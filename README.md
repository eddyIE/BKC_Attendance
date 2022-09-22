<p align="center">
    <img src="https://user-images.githubusercontent.com/61381778/191733461-79c62354-c6dc-489e-8d80-a82033fcb215.png" alt="drawing" width="500"/>
</p>

## TỔNG QUAN VỀ PROJECT

Đây là đồ án tốt nghiệp Phần mềm điểm danh học viện được tạo ra với mục đích là đồ án tốt nghiệp Học viện công nghệ BKACAD và Trường Cao đẳng nghề Bách Khoa Hà Nội vào tháng 9 năm 2022. Tài liệu và phần mềm được tạo nên bời sinh viên Trần Đại Nghĩa và Nguyễn Trần Nhật Vũ.

## PHẦN 1: MÔ TẢ BÀI TOÁN VÀ GIẢI PHÁP

### 1.1. Lý do chọn đề tài

Tác vụ điểm danh có lẽ là một trong những tác vụ cơ bản nhất của mỗi trường học. Nó giúp cho nhà trường quản lí được tính chuyên cần của học sinh, sinh viên từ đó nâng cao tính kỉ cương của nhà trường. Song, nếu như điểm danh bằng tài liệu (giấy, sổ, bảng biểu,…) thì sẽ xuất hiện rất nhiều hạn chế như khó đồng bộ, dễ thất thoát tài liệu, khó đảm bảo độ chính xác với trường có quá nhiều học sinh, sinh viên.

Từ nhu cầu trên, ảnh hưởng cùng sự phát triển của ngành Công nghệ thông tin hiện nay. Chúng em lựa chọn đề tài tạo nên một phần mềm điểm danh cho các học viện, trung tâm đào tạo. Đối tượng chúng em hướng tới là các cơ sở đào tạo nhỏ, có khoảng 300-500 học sinh, sinh viên mỗi khóa học. Các trung tâm đào tạo này sẽ được tạo ra một giải pháp phần mềm điểm danh giúp họ thay thế các tác vụ điểm danh bằng giấy.

### 1.2. Mô tả giải pháp điểm danh học viện

Giải pháp được tạo ra có thể trình bày như sau: khi bắt đầu mỗi môn học, phòng Đào tạo có trách nhiệm lập ra một lớp học bao gồm các thông tin về môn học được giảng dạy, giảng viên đứng lớp, danh sách sinh viên, số giờ dự kiến. Sau đó giáo viên sẽ có thể theo dõi dõi tình hình môn học của lớp học mình được phân công giảng dạy từ phòng Đào tạo.

Hàng ngày, giáo viên đến lớp thì sẽ dùng hệ thống để lấy danh sách điểm danh của lớp học đó ra để tiến hành điểm danh sinh viên. Nếu sinh viên không có mặt tại lớp thì giáo viên sẽ đánh dấu sinh viên “Vắng”, còn nếu sinh viên đi muộn thì chọn “Muộn”. Trong trường hợp sinh viên vắng mặt nhưng có xin phép thì giảng viên có thể click chọn “Có phép” và ghi thêm lý do nghỉ.

Giáo vụ có thể xem thống kê về chuyên cần của các sinh viên. Điểm chuyên cần của sinh viên được tính như sau: 
- Nếu sinh viên nghỉ không phép thì tính là một buổi nghỉ
- Nếu sinh viên đi muộn thì tính là 0,3 buổi nghỉ và 3 buổi muộn sẽ làm tròn thành 1 buổi nghỉ
- Nếu sinh viên nghỉ có phép thì sẽ tính 1 buổi nghỉ có phép.

Kết thúc môn học, nếu sinh viên nghỉ quá 30% số buổi sẽ phải thi lại, sinh viên nào nghỉ quá 50% số buổi sẽ phải học lại.


### 1.3. Các công nghệ sẽ áp dụng cho đồ án

- HTML5/CSS3
- JavaScript
- PHP 8
- Framework Laravel 8
- Framework Bootstrap 5
- JQuery và một số thư viện
- Cơ sở dữ liệu PostgreSQL

<p align="center">
<img src="https://user-images.githubusercontent.com/61381778/191728175-1302f468-c1af-4c18-8fa9-ccf0d01a6d97.png" alt="drawing" width="500"/>
</p>

## PHẦN 2: PHÂN TÍCH THIẾT KẾ HỆ THÔNG

Đồ án được tạo ra với 2 vai trò người sử dụng chính, giảng viên và giáo vụ.

### 2.1. Chức năng giáo vụ
<p align="center">
<img src="https://user-images.githubusercontent.com/61381778/191727363-1feb40ce-9a18-44af-95e7-3dc2a644e2de.png" alt="drawing" width="800"/>
</p>

### 2.2. Chức năng giảng viên
<p align="center">
<img src="https://user-images.githubusercontent.com/61381778/191727463-50cfef46-293f-4ed9-9a2d-09fa4c0f8aef.png" alt="drawing" width="800"/>
</p>
    
### 2.3. Quan hệ giữa các bảng trong DB
<p align="center">
<img src="https://user-images.githubusercontent.com/61381778/191729208-de4c68b8-c426-4415-b19d-f7a6dc5a6ff0.png" alt="drawing" width="800"/>
</p>
    
## PHẦN 3: TRIỂN KHAI CHƯƠNG TRÌNH

### 3.1. Đăng nhập hệ thống
<p align="center">
<img src="https://user-images.githubusercontent.com/61381778/191729619-e008c797-2310-43df-bcf7-f2e95e80aaf4.png" alt="drawing" width="800"/>
</p>

### 3.2. Giao diện điểm danh của giảng viên
<p align="center">
<img src="https://user-images.githubusercontent.com/61381778/191731187-68778a0b-007a-4114-a933-b8951c9c964f.png" alt="drawing" width="800"/>
</p>

### 3.3. Giao diện trang chủ giáo vụ với các lịch phân công toàn trường
<p align="center">
<img src="https://user-images.githubusercontent.com/61381778/191731537-17b9f7b6-d680-48ff-93ec-709009d30030.png" alt="drawing" width="800"/>
</p>

### 3.4. Giao diện thống kê của giáo vụ
<p align="center">
<img src="https://user-images.githubusercontent.com/61381778/191731736-205e4fe5-8f45-41c0-bded-f9624bf2381b.png" alt="drawing" width="800"/>
</p>


## PHẦN 4: ĐÁNH GIÁ

Như vậy, sau một thời gian tìm hiểu, nghiên cứu em đã hoàn thành đồ án “Hệ thống điểm danh BKC Attendance”. Đồ án đã đưa ra một cách tổng quan về chương trình quản lý điểm danh sinh viên. Với yêu cầu của bài toán thực tế về vấn đề theo dõi điểm danh thì chương trình của em đã giải quyết được những vấn đề sau:
- Tạo ra được CSDL có khả năng lưu trữ chính xác và khoa học các thông tin liên quan đến vấn đề điểm danh cho giáo viên, và xuất báo cáo tình hình điểm danh tại học viện.
- Xây dựng được các giao diện cập nhật dữ liệu dễ dàng, thuận tiện.
- Xây dựng được giao diện điểm danh hàng ngày cho từng lớp môn học.
- Xây dựng được giao diện thống kê trung tâm dào tạo.
- Xây dựng được giao diện xem lịch sử các buổi đã dạy
- Xây dựng được các chức năng quản trị hệ thống bao gồm: đăng nhập, quản trị dữ liệu hệ thống.

Tuy nhiên, chương trình vẫn còn một số hạn chế như:
- Giao diện điểm danh hàng ngày chưa thực sự sinh mã lần điểm danh tự động và sinh dữ liệu thông tin sinh viên tự động cho mỗi lần điểm danh.
- Giao diện chưa đẹp do cả 2 thành viên đều không chuyên sâu về Front-end

Hướng phát triển tiếp theo của chương trình trong tương lai:
- Cải thiện giao diện người dùng.
- Nghiên cứu, bổ sung thêm các chức năng hỗ trợ điểm danh và thống kê.

Do kiến thức còn hạn chế nên đồ án tốt nghiệp của em chắc chắn không tránh khỏi những thiếu sót. Em rất mong có được những ý kiến đánh giá, đóng góp của các thầy cô và các bạn để đồ án thêm hoàn thiện. Em xin gửi lời cảm ơn chân thành đến thầy giáo Nguyễn Ngọc Tân người đã trực tiếp hướng dẫn và giúp đỡ em hoàn thành đồ án tốt nghiệp này.
