@extends('lecturer.layout.main')

@section('title', 'BKACAD - Điểm danh')

@section('links')
    {{-- Thư viện daterangepicker--}}
    <link rel="stylesheet" href="{{ asset('css/daterangepicker.css') }}">
@endsection

@section('content')
    {{-- Thanh chọn lớp điểm danh--}}
    @include('lecturer.attendance.course_chooser')

    {{--Thông tin chung của khóa học vừa chọn--}}
    @include('lecturer.attendance.course_info')

    <form action="{{asset('/attendance')}}" method="POST" onsubmit="return validateForm()" name="attendanceForm">
        @csrf
        {{-- Thông tin khóa học đang được chọn --}}
        @isset($curCourse)
            <input type="hidden" name='current-course-id' value='{{$curCourse->id}}'>
        @endisset

        {{--Danh sách sinh viên--}}
        @include('lecturer.attendance.course_student_list')

        {{--Lịch sử các buổi học--}}
        @include('lecturer.attendance.course_history')

        {{--Phần chọn thời gian--}}
        @include('lecturer.attendance.course_time_picker')

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
            const curHour = (now.getHours() < 10) ? ("0" + now.getHours()) : now.getHours();
            const curMinutes = (now.getMinutes() < 10) ? ("0" + now.getMinutes()) : now.getMinutes();
            const curTime = `${curHour}:${curMinutes}`;

            // Lấy ngày tháng nếu là buổi hoc cũ
            const a = {!! json_encode($curLessonDate ?? null) !!};
            if (a !== null) {
                return true;
            }

            // Lấy data
            const attendanceList = document.forms["attendanceForm"];
            let start = `${attendanceList["start[hour]"].value}:${attendanceList["start[minutes]"].value}`;
            let end = `${attendanceList["end[hour]"].value}:${attendanceList["end[minutes]"].value}`;

            // VALIDATE
            try {
                // Tách data để tính toán
                let curArr = curTime.split(":");
                let endArr = end.split(":");
                let startArr = start.split(":");

                // - Giờ bắt đầu không sớm hơn giờ kết thúc
                // - Giờ bắt đầu không sớm hơn hiện tại
                // - Giờ kết thúc không muộn hơn hiện tại quá 30p
                if (start >= end) {
                    alert("Giờ bắt đầu phải sớm hơn giờ kết thúc.");
                    return false;
                } else if (start > curTime) {
                    alert("Buổi học chưa đến giờ điểm danh.");
                    return false;
                }
                if ((curArr[0] - endArr[0] === 0 && curArr[1] - endArr[1] > 30) || (curArr[0] - endArr[0] > 0)) {
                    alert("Buổi học đã kết thúc quá 30 phút");
                    return false;
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

        function courseSearch() {
            var input, filter, ul, courses, a, i, txtValue;
            input = document.getElementById('courseSearchInput');
            filter = input.value.toUpperCase();
            ul = document.getElementById("class_selector");
            courses = ul.getElementsByName('select_course');

            // Lăp qua list, ẩn các kết quả không trùng
            for (i = 0; i < courses.length; i++) {
                txtValue = courses.textContent || courses.innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    courses[i].style.display = "";
                } else {
                    courses[i].style.display = "none";
                }
            }
        }
    </script>
    <script type="text/javascript">
        const selected = document.querySelector(".selected");
        const courseContainer = document.querySelector(".course-container");
        const searchBox = document.querySelector(".search-box input");

        // Lấy tên khóa học hiện tại hiện lên phần chọn lớp
        const a = {!! json_encode($currentCourse->{'name'} ?? null) !!};
        if (a !== null) {
            selected.innerHTML = a;
        }

        const courses = document.querySelectorAll(".course");

        selected.addEventListener("click", () => {
            courseContainer.classList.toggle("active");

            searchBox.value = "";
            filterList("");

            if (courseContainer.classList.contains("active")) {
                searchBox.focus();
            }
        });

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
                if (label.indexOf(searchTerm) != -1) {
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

    <!-- jQuery -->
    <script src="{{ asset('js/jquery/jquery.min.js') }}"></script>

    <!-- InputMask -->
    <script src="{{ asset('js/moment.min.js') }}"></script>
    <script src="{{ asset('js/jquery.inputmask.min.js') }}"></script>

    <!-- bootstrap color picker -->
    <script src="{{ asset('js/bootstrap-colorpicker.min.js') }}"></script>
    <script>
        $('#lesson-time').daterangepicker({
            timePicker: true,
            timePicker24Hour: true,
            timePickerIncrement: 1,
            locale: {
                format: 'HH:mm'
            }
        }).on('show.daterangepicker', function (ev, picker) {
            picker.container.find(".calendar-table").hide();
        });
    </script>

@endsection
