@extends('admin.layout.main')
@section('title', 'Administrator side')

@section('css')
    a, .fc-daygrid-day-number{
        color:black;
    }
@endsection

@section('content')
    <div id="calendar"></div>
@endsection

@section('script')
    <script>
        $(document).ready(function () {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                themeSystem: 'standard',
                headerToolbar: {
                    left: 'prev,next,today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,listDay'
                },
                locale: 'vi',
                buttonText: {
                    today: 'Hôm nay',
                    day: 'Hôm nay',
                    week: 'Tuần này',
                    month: 'Tháng này'
                },
                aspectRatio: 1.7,
                @foreach($courses as $course)
                events: [
                    {
                        title: '{{ $course->name }}',
                        daysOfWeek: {{ $course->scheduled_day }},
                        startTime: '{{ $course->start }}',
                        endTime: '{{ $course->end }}',
                        startRecur: '{{ date_format($course->created_at,'Y-m-d') }}',
                        endRecur: '{{}}',
                        display: 'block',
                        color: "#" + ((1<<24)*Math.random() | 0).toString(16),
                    }
                ],
                events: [
                    {
                        title: 'Demo',
                        daysOfWeek: [0,1,2],
                        startTime: '08:00',
                        endTime: '12:00',
                        startRecur: '2022-08-01',
                        endRecur: '2022-08-31',
                        display: 'block',
                        color: "#" + ((1<<24)*Math.random() | 0).toString(16),
                    }
                ],
                @endforeach
            });
            calendar.render();

            $('#subject').select2();
        });
    </script>
@endsection
