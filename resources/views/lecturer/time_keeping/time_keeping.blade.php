{{--TRANG CHẤM CÔNG--}}
@extends('lecturer.layout.main')

@section('title', 'BKACAD - Chấm công')

@section('css')

    #calendar {
    width: 100%;
    margin: 0 auto;
    }

    /* Full calendar hiện tên Tháng Năm in hoa chữ đầu*/
    .fc-toolbar { text-transform: capitalize; }

@endsection

@section('content')
    <h2>Lịch chấm công tháng này</h2>
    @isset($totalWorkTime)
        <h3>Thời lượng đã dạy tháng này: {{$totalWorkTime}}</h3>
    @endisset
    <div id='calendar'></div>
@endsection

@section('script')
    <script src="{{asset('js/fullcalendar/lib/main.js')}}"></script>
    <script src="{{asset('fullcalendar/lib/locales/vi.js') }}"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            let calendarEl = document.getElementById('calendar');

            let calendar = new FullCalendar.Calendar(calendarEl, {
                themeSystem: 'bootstrap5',
                headerToolbar: {
                    left: 'today',
                    center: 'title',
                    right: 'dayGridMonth,dayGridWeek,dayGridDay'
                },
                buttonText: {
                    today: 'Hôm nay',
                    day: 'Xem ngày',
                    week:'Xem tuần',
                    month:'Xem tháng'
                },
                locale: 'vi',
                // Thứ 2 là ngày đầu tuần ~
                firstDay: 1,
                navLinks: true, // can click day/week names to navigate views
                editable: false,
                dayMaxEvents: true, // allow "more" link when too many events
                events: [
                        @isset($lessons)
                        @foreach($lessons as $lesson)
                    {
                        title:
                        @php
                            /*
                             * Title buổi dạy có dạng:
                             *  Tên môn học
                             *  Ca học: Giờ phút bắt đầu - Giờ phút kết thúc
                             */
                            // Lấy tên lớp học
                            // và convert ca học từ số sang chữ
                            $title = "$lesson->course_name \n";
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
                        start: @php echo json_encode($lesson->created_at->format('Y-m-d')) @endphp
                    },
                    @endforeach
                    @endisset
                ],
                eventColor: '#378006',
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
