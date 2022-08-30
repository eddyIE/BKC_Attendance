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

    .fc-event-main{
    padding: 5px;
    }

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

            let count = 0;
            let calendar = new FullCalendar.Calendar(calendarEl, {
                slotLabelFormat: function (date) {
                    const shifts = ["Sáng (8h-12h)",
                        "Chiều (13h-17h)", "Tối (18h-21h)"];
                    return "Ca " + shifts[count++];
                },
                // Week layout
                initialView: 'timeGridWeek',

                slotDuration: '04:00:00',
                slotMinTime: '08:00:00',
                slotMaxTime: '19:00:00',

                allDaySlot: false,

                // slotLabelFormat: {
                //     hour: 'numeric',
                //     minute: '2-digit',
                //     omitZeroMinute: false,
                //     meridiem: 'short'
                // },
                dayHeaderFormat: {weekday: 'short'},

                // Theme & color
                themeSystem: 'bootstrap5',
                eventBorderColor: '#ffffff',
                eventColor: '#006182',
                height: 300,

                // Toolbar
                headerToolbar: {
                    left: 'today',
                    center: '',
                    right: 'dayGridMonth,dayGridWeek,dayGridDay'
                },

                // Dịch sang tiếng Việt
                locale: 'vi',
                buttonText: {
                    today: 'Hôm nay',
                    day: 'Xem ngày',
                    week: 'Xem tuần',
                    month: 'Xem tháng'
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
                    {
                        title: "tets",
                        daysOfWeek: [5]
                    },
                        {{--                        @dd($lessons)--}}
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
                            $title = "$course->name";

                            echo (json_encode($title));
                        @endphp,
                        daysOfWeek: @php
                                echo json_encode($course->scheduled_day)
                            @endphp,
                            start: "08:00"
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
