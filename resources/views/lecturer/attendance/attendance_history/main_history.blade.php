@extends('lecturer.layout.main')

@section('title', 'Lịch sử điểm danh')

@section('links')
    {{--Thư viện lịch FullCalendar--}}
    <link rel='stylesheet' href="{{ asset('js/fullcalendar/lib/main.css') }}"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
@endsection

@section('css')

    #calendar {
    width: 100%;
    margin: 0 auto;
    }

    /* Full calendar hiện tên Tháng Năm in hoa chữ đầu*/
    .fc-toolbar { text-transform: capitalize; }

    /* Hiện border đậm màu hơn */
    .fc-scrollgrid{
    border-collapse: collapse!important;
    }
    .fc-scrollgrid td, .fc-scrollgrid th  {
    border: 1px solid black!important;
    }

    .fc-event-main{
    padding: 5px;
    }
@endsection

@section('content')

    {{--Lịch sử các buổi học--}}
    @include('lecturer.attendance.attendance_history.course_history')

    @isset($prevLesson)
        {{--Thông tin chung của khóa học vừa chọn--}}
        @include('lecturer.attendance.course_info')
        <form action="{{asset('/attendance')}}" method="POST" onsubmit="return validateForm()" name="attendanceForm">
            @csrf
            {{-- Thông tin khóa học đang được chọn --}}
            @isset($curCourse)
                <input type="hidden" name='current-course-id' value='{{$curCourse->id}}'>
            @endisset

            {{--Danh sách sinh viên--}}
            @include('lecturer.attendance.student_list')

            {{--Phần chọn thời gian--}}
            @include('lecturer.attendance.attendance_history.history_time_picker')

            {{--Phần ghi chú và các nút--}}
            @include('lecturer.attendance.attendance_history.history_submit_btn')
        </form>
        @include('lecturer.attendance.attendance_history.history_back_btn')
    @endisset
@endsection

@section('script')

    <script src="{{asset('js/fullcalendar/lib/main.js')}}"></script>
    <script src="{{asset('fullcalendar/lib/locales/vi.js') }}"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            let calendarEl = document.getElementById('calendar');

            let calendar = new FullCalendar.Calendar(calendarEl, {
                // Display
                themeSystem: 'bootstrap5',
                eventBorderColor: '#ffffff',
                eventColor: '#006182',
                height: 650,


                // Toolbar
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,dayGridWeek,dayGridDay'
                },

                buttonIcons:
                    {
                        prev: 'bi bi-arrow-left',
                        next: 'bi bi-arrow-right',
                    },

                // Dịch sang tiếng Việt
                locale: 'vi',
                buttonText: {
                    today: 'Hôm nay',
                    day: 'Xem ngày',
                    week: 'Xem tuần',
                    month: 'Xem tháng',
                },

                // Thứ 2 là ngày đầu tuần ~
                firstDay: 1,
                // Không hiện mờ mấy ngày của tháng khác
                showNonCurrentDates: false,
                navLinks: true, // can click day/week names to navigate views
                // Ko cho edit
                editable: false,
                dayMaxEvents: true, // allow "more" link when too many events

                // Truyền vào các buổi chấm công
                events: [
                        @isset($lessons)
                        @foreach($lessons as $lesson)
                    {
                        title:
                        @php
                            /*
                             * Title buổi điểm danh có dạng:
                             *  Ca học: Giờ phút bắt đầu - Giờ phút kết thúc
                             */
                            // Convert ca học từ số sang chữ
                            $title = "";
                            if($lesson->shift == 0){
                                $title .= "Ca Sáng";
                            }else if($lesson->shift == 1){
                                $title .= "Ca Chiều";
                            }else if($lesson->shift == 2){
                                $title .= "Ca Tối";
                            }

                            // Cắt bỏ phần giây :00 ở giờ bắt đầu / kết thúc
                            $lessonStart = date('H:i', strtotime($lesson->start));
                            $lessonEnd = date('H:i', strtotime($lesson->end));
                            // Gắn thêm giờ bắt đầu và kết thúc
                            $title .= ": $lessonStart - $lessonEnd";

                            echo (json_encode($title));
                        @endphp,
                        start: @php echo json_encode($lesson->created_at->format('Y-m-d')) @endphp,
                        url: @php echo json_encode(asset('lesson/'.$lesson->id)) @endphp
                    },
                    @endforeach
                    @endisset
                ],
                // Làm thuộc tính title có thể xuống dòng
                eventContent: function (arg) {
                    return {
                        html: arg.event.title.replace(/\n/g, '<br>')
                    }
                },
            });
            calendar.render();
        });
    </script>

    <script>
        function validateForm() {
            // Nếu đang xem buổi học trong quá khứ
            let prevLessonTime = document.getElementById('prev-lesson-time');
            if (typeof (prevLessonTime) != 'undefined' && prevLessonTime != null) {
                return true;
            }

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

        function showPrevLesson() {
            let x = document.getElementById("prev-lesson");
            if (x.style.display === "none") {
                x.style.display = "block";
                $("#calendar").fullCalendar('render');
                $('#calendar').fullCalendar('refetchEvents');
            } else {
                x.style.display = "none";
            }
        }

        function courseSearch() {
            // Declare variables
            var input, filter, ul, courses, a, i, txtValue;
            input = document.getElementById('courseSearchInput');
            filter = input.value.toUpperCase();
            ul = document.getElementById("class_selector");
            courses = ul.getElementsByName('select_course');

            // Loop through all list items, and hide those who don't match the search query
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
        const a = {!! json_encode($curCourse->{'name'} ?? null) !!};
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
    <script>
        $(function () {
            $('#start').datetimepicker({
                format: 'HH:mm',
                pickDate: false,
                pickSeconds: false,
                pick12HourFormat: false,
            });

            $('#end').datetimepicker({
                format: 'HH:mm',
                pickDate: false,
                pickSeconds: false,
                pick12HourFormat: false,
            });
        });
    </script>
@endsection
