{{--TRANG CHẤM CÔNG--}}
@extends('lecturer.layout.main')

@section('title', 'BKACAD - Chấm công')

@section('links')
    {{--Thư viện lịch FullCalendar--}}
    <link rel='stylesheet' href="{{ asset('js/fullcalendar/lib/main.css') }}"/>
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

    /*.fc-daygrid-event{*/
    /*margin: 20px;*/
    /*}*/
    /*.fc-event-main{*/
    /*margin: 5px;*/
    /*font-size: 16px;*/
    /*}*/

@endsection

@section('content')
    <h2>Thời khóa biểu</h2>

    <div id='calendar'></div>
@endsection

@section('script')
    <script src="{{asset('js/fullcalendar/lib/main.js')}}"></script>
    <script src="{{asset('fullcalendar/lib/locales/vi.js') }}"></script>
    <script src="{{(asset('js/moment.min.js'))}}"></script>


    <script>
        document.addEventListener('DOMContentLoaded', function () {
            let calendarEl = document.getElementById('calendar');

            let calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridWeek',
                // Ẩn dòng "Cả ngày"
                allDaySlot: false,
                // Thời gian bắt đầu và kết thúc
                slotMinTime: '08:00:00',
                slotMaxTime: '21:00:00',

                // Chiều cao hàng
                expandRows: true,

                // Format giờ trong timeGridWeek
                slotLabelFormat: {
                    hour: 'numeric',
                    minute: '2-digit',
                    omitZeroMinute: false,
                    meridiem: 'short'
                },

                // Display
                themeSystem: 'bootstrap5',
                eventBorderColor: '#ffffff',
                eventColor: '#006182',

                // Toolbar
                headerToolbar: {
                    left: 'today',
                    center: '',
                    right: 'dayGridWeek,dayGridDay,timeGridWeek'
                },

                // Dịch sang tiếng Việt
                locale: 'vi',
                buttonText: {
                    today: 'Hôm nay',
                    day: 'Xem ngày',
                    week: 'Xem tuần',
                    month: 'Xem tháng'
                },

                // Chỉ hiện thị thứ không hiển thị ngày
                dayHeaderFormat: {weekday: 'short'},

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
                    {
                        title: "test",
                        daysOfWeek: [5],
                    },
                        @isset($courses)
                        @foreach($courses as $course)
                    {
                        title:
                        @php
                            /*
                             * Title khóa học có dạng:
                             *  Tên môn học
                             *  Ca học: Giờ phút bắt đầu - Giờ phút kết thúc
                             */
                            // Lấy tên lớp học
                            // và convert ca học từ số sang chữ
                            $title = "$course->name \n";
                            $title .= "$course->start"." - "."$course->end";

                            echo (json_encode($title));
                        @endphp,
                        daysOfWeek: {{$course->scheduled_day}},
                        startTime: '{{$course->start}}',
                        endTime: '{{$course->end}}',
                        display: 'block'
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
@endsection
