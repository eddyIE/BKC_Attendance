@extends('admin.layout.main')

@section('title', 'BKACAD - Điểm danh')

@section('content')
    {{-- Thanh chọn lớp điểm danh--}}
    @include('admin.attendance.course_chooser')

    {{--Thông tin chung của khóa học vừa chọn--}}
    @include('lecturer.attendance.course_info')

    <form action="{{asset('admin/attendance')}}" method="POST" onsubmit="return validateForm()" name="attendanceForm">
        @csrf
        {{-- Thông tin khóa học đang được chọn --}}
        @isset($curCourse)
            <input type="hidden" name='current-course-id' value='{{$curCourse->id}}'>
        @endisset

        {{--Danh sách sinh viên--}}
        @include('lecturer.attendance.student_list')

        {{--Lịch sử các buổi học--}}
        @include('lecturer.attendance.attendance_history.course_history')

        {{--Phần chọn thời gian--}}
        @include('admin.attendance.course_time_picker')

        {{--Phần ghi chú và các nút--}}
        @include('lecturer.attendance.course_submit_btn')
    </form>
@endsection

@section('script')
    <script>
        // Validate thời gian
        function validateForm() {
            // Lấy thời gian hiện tại
            const now = new Date();

            // Lấy ngày tháng nếu là buổi hoc cũ
            const a = {!! json_encode($curLessonDate ?? null) !!};
            if (a !== null) {
                return true;
            }

            // Lấy data
            // const attendanceList = document.forms["attendanceForm"];
            let startInput = document.querySelector('input[name="start"]').value;
            let endInput = document.querySelector('input[name="end"]').value;

            // Tạo object Date mới, cắt chuỗi để lấy HH và mm của 2 ô input
            start = new Date(new Date().setHours(startInput.substring(0, 2), startInput.substring(3, 5)));
            end = new Date(new Date().setHours(endInput.substring(0, 2), endInput.substring(3, 5)));

            let morningShift = document.querySelector('#morning-shift');
            let afternoonShift = document.querySelector('#afternoon-shift');
            let eveningShift = document.querySelector('#evening-shift');

            // VALIDATE
            try {
                // - Giờ bắt đầu không sớm hơn giờ kết thúc
                // - Giờ bắt đầu không sớm hơn hiện tại
                // - Giờ kết thúc không muộn hơn hiện tại quá 30p
                if (start >= end) {
                    alert("Giờ bắt đầu phải sớm hơn giờ kết thúc.");
                    return false;
                }

                if (morningShift.checked) {
                    if (start < new Date(new Date().setHours(8, 0, 0))) {
                        alert("Ca sáng bắt đầu từ 8h");
                        return false;
                    }
                    if (end > new Date(new Date().setHours(12, 0, 59))) {
                        alert("Ca sáng kết thúc từ 12h");
                        return false;
                    }
                } else if (afternoonShift.checked) {
                    if (start < new Date(new Date().setHours(13, 0, 0))) {
                        alert("Ca chiều bắt đầu từ 13h");
                        return false;
                    }
                    if (end > new Date(new Date().setHours(17, 0, 59))) {
                        alert("Ca chiều kết thúc từ 17h");
                        return false;
                    }
                } else if (eveningShift.checked) {
                    if (start < new Date(new Date().setHours(18, 0, 0))) {
                        alert("Ca tối bắt đầu từ 18h");
                        return false;
                    }
                    if (end > new Date(new Date().setHours(21, 0, 59))) {
                        alert("Ca tối kết thúc từ 21h");
                        return false;
                    }
                }
            } catch (err) {
                console.log(err.message);
            }
        }

        function currentDate() {
            let currentDate = new Date()
            let maxDate = currentDate.toISOString().split('T')[0];
            document.getElementsByName("lesson-date")[0].setAttribute('max', maxDate);
        }

        // Show lịch sử
        function showPrevLesson() {
            let x = document.getElementById("prev-lesson");
            if (x.style.display === "none") {
                x.style.display = "block";
            } else {
                x.style.display = "none";
            }
        }

    </script>
    <script type="text/javascript">
        // Tìm kiếm khóa học theo tên trên thanh tìm kiếm

        //
        const selected = document.querySelector(".selected");
        const courseContainer = document.querySelector(".course-container");
        const searchBox = document.querySelector(".search-box input");

        // Lấy tên khóa học hiện tại hiện lên phần chọn lớp
        const a = {!! json_encode($curCourse->{'name'} ?? null) !!};
        if (a !== null) {
            selected.innerHTML = a;
        }

        // Ấn vào thanh chọn thì hiển thị các lớp và thanh tìm kiếm
        selected.addEventListener("click", () => {
            courseContainer.classList.toggle("active");

            searchBox.value = "";
            filterList("");

            // Auto để trỏ chuột vào ô tìm kiếm
            if (courseContainer.classList.contains("active")) {
                searchBox.focus();
            }
        });

        const courses = document.querySelectorAll(".course");
        courses.forEach(o => {
            o.addEventListener("click", () => {
                selected.innerHTML = o.querySelector("label").innerHTML;
                courseContainer.classList.remove("active");
            });
        });

        searchBox.addEventListener("keyup", function (e) {
            filterList(e.target.value);
        });

        const filterList = searchTerm => {
            // Viết thường, xóa khoảng trắng hoặc kí tự đặc biệt
            searchTerm = searchTerm.toLowerCase();
            searchTerm = searchTerm.replace('-', '');
            searchTerm = searchTerm.replace('_', '');
            searchTerm = searchTerm.replace('/', '');
            searchTerm = searchTerm.replace('  ', '');
            searchTerm = searchTerm.replace(' ', '');

            courses.forEach(option => {
                // Xóa khoảng trắng hoặc kí tự đặc biệt
                let label = option.firstElementChild.nextElementSibling.innerText.toLowerCase();
                label = label.replace('-', '');
                label = label.replace('_', '');
                label = label.replace('/', '');
                label = label.replace('  ', '');
                label = label.replace(' ', '');
                if (label.indexOf(searchTerm) !== -1) {
                    option.style.display = "block";
                } else {
                    option.style.display = "none";
                }
            });
        };
    </script>
    <script>
        export default {
            data() {
                return {
                    value: ''
                }
            }
        }
    </script>
    <script>
        $(window).on("load", function () {
            $('#start').datetimepicker({
                format: 'HH:mm',
                pickDate: false,
                pickSeconds: false,
                pick12HourFormat: false,
                useCurrent: false
            });

            $('#end').datetimepicker({
                format: 'HH:mm',
                pickDate: false,
                pickSeconds: false,
                pick12HourFormat: false,
                useCurrent: false
            });

            {{-- Ấn vào nút ca nào thì hiển thị giờ tương ứng
                VD: ấn "Ca chiều" thì giờ auto nhảy thành 13:00 và 17:00
            --}}
            const morningShift = document.querySelector('#morning-shift');
            const afternoonShift = document.querySelector('#afternoon-shift');
            const eveningShift = document.querySelector('#evening-shift');

            const start = document.querySelector('input[name="start"]');
            const end = document.querySelector('input[name="end"]');

            morningShift.addEventListener('click', () => {
                start.value = "08:00";
                end.value = "12:00";
            });

            afternoonShift.addEventListener('click', () => {
                start.value = "13:00";
                end.value = "17:00";
            });

            eveningShift.addEventListener('click', () => {
                start.value = "18:00";
                end.value = "21:00";
            });
        });
    </script>
    <script>
        $(function () {
            $("#example1").DataTable({
                "paging": false,
                "lengthChange": false,
                "searching": true,
                "ordering": true,
                "info": false,
                "autoWidth": false,
                "responsive": true,
                'aoColumnDefs': [{
                    'bSortable': false,
                    'aTargets': [-1] /* 1st one, start by the right */
                }],
                "oLanguage": {
                    "sSearch": "Tìm kiếm",
                    "sInfo": "Hiển thị _START_ đến _END_ của _TOTAL_ kết quả",
                    "sInfoEmpty": "Hiển thị 0 kết quả",
                    "sInfoFiltered": "(Lọc từ _MAX_ kết quả)",
                    "sEmptyTable": "Không có dữ liệu",
                    "sZeroRecords": "Không tìm thấy kết quả",
                    "sPrevious": "Trước",
                    "next": "Sau",
                    "paginate": {
                        "sFirst": "Trang đầu",
                        "sLast": "Trang cuối",
                        "sNext": "Sau",
                        "sPrevious": "Trước"
                    },
                }
            });
        });
    </script>
@endsection
