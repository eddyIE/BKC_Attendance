@extends('lecturer.layout.main')

@section('title', 'BKACAD - Chấm công')

@section('css')

    #calendar {
    width: 100%;
    margin: 0 auto;
    }
@endsection

@section('content')
    <h2>Lịch chấm công tháng này</h2>
    <div id='calendar'></div>
@endsection

@section('script')
    <script src="{{asset('js/fullcalendar/lib/main.js')}}"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            let calendarEl = document.getElementById('calendar');
            let calendar = new FullCalendar.Calendar(calendarEl, {
                headerToolbar: {
                    left: 'today',
                    center: 'title',
                    right: 'dayGridMonth,dayGridWeek,dayGridDay'
                },
                navLinks: true, // can click day/week names to navigate views
                editable: false,
                dayMaxEvents: true, // allow "more" link when too many events
                events: [
                        @isset($lessons)
                        @foreach($lessons as $lesson)
                    {
                        title:
                        @php
                            // Convert tên ca học
                            $title = '';
                            if($lesson->shift == 0){
                                $title = "Ca Sáng";
                            }else if($lesson->shift == 1){
                                $title = "Ca Chiều";
                            }else if($lesson->shift == 2){
                                $title = "Ca Tối";
                            }

                            // Gắn thêm giờ bắt đầu và kết thúc
                            $lessonStart = date('H:i', strtotime($lesson->start));
                            $lessonEnd = date('H:i', strtotime($lesson->end));
                            $title .= ": $lessonStart - $lessonEnd";
                        echo (json_encode($title));
                        @endphp,
                        start: @php echo json_encode($lesson->created_at->format('Y-m-d')) @endphp
                    },
                        @endforeach
                        @endisset
                ]
            });
            calendar.render();
        });
    </script>
@endsection
