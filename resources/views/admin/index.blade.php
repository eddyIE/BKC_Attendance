@extends('admin.layout.main')
@section('title', 'Index')

@section('css')
    a, .fc-daygrid-day-number{
        color:black;
    }
    .fc-direction-ltr .fc-daygrid-event .fc-event-time{
        min-width: 15px;
    }
    .fc-event-title {
        padding: 0 1px;
        white-space: normal;
    }
    .fc-toolbar {
        text-transform: capitalize;
    }
@endsection

@section('content')
    <div id="calendar"></div>
@endsection

@section('script')
    <script>
        $(document).ready(function () {
            function getRandColor(brightness){

                // Six levels of brightness from 0 to 5, 0 being the darkest
                var rgb = [Math.random() * 256, Math.random() * 256, Math.random() * 256];
                var mix = [brightness*51, brightness*51, brightness*51]; //51 => 255/5
                var mixedrgb = [rgb[0] + mix[0], rgb[1] + mix[1], rgb[2] + mix[2]].map(function(x){ return Math.round(x/2.0)})
                return "rgb(" + mixedrgb.join(",") + ")";
            }

            function getNearestDate(dateToCheckFor, datesToBeChecked ){
                let nearestDate;

                datesToBeChecked.forEach(date => {
                    let diff = moment(date).diff(moment(dateToCheckFor), 'days');
                    if (diff > 0) {
                        if (nearestDate) {
                            if (moment(date).diff(moment(nearestDate), 'days') < 0) {
                                nearestDate = date;
                            }
                        } else {
                            nearestDate = date;
                        }
                    }
                });
                return nearestDate;
            }

            var events = [];
            var date;
            var dow = [];
            var startDate;
            var endDate;
            @foreach($courses as $course)
                date = '{{ date_format($course->created_at,'Y-m-d') }}';
                @foreach($course->dow as $index => $dow)
                    if (moment(date).day() > {{ $dow }}) {
                        dow.push(moment(date).add(1, 'week').day({{ $dow }}).format('YYYY-MM-DD'));
                    } else {
                        dow.push(moment(date).add(0, 'week').day({{ $dow }}).format('YYYY-MM-DD'));
                    }
                @endforeach

                startDate = getNearestDate(date, dow);
                endDate = moment(date).add({{ $course->total_week }}, 'week').day({{ last($course->dow) }}).format('YYYY-MM-DD');

                events.push({
                    title: '{{ $course->name }} ({{ $course->full_name }})',
                    daysOfWeek: {{ $course->scheduled_day }},
                    startTime: '{{ $course->start }}',
                    endTime: '{{ $course->end }}',
                    startRecur: startDate,
                    endRecur: endDate,
                    display: 'block',
                    color: getRandColor(3),
                })
            @endforeach

            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                themeSystem: 'standard',
                headerToolbar: {
                    left: 'prev,next,today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,listDay'
                },
                slotEventOverlap: false,
                contentHeight: 'auto',
                locale: 'vi',
                buttonText: {
                    today: 'Hôm nay',
                    day: 'Hôm nay',
                    week: 'Tuần này',
                    month: 'Tháng này'
                },
                aspectRatio: 1.7,
                events: events,
            });
            calendar.render();

            $('#subject').select2();
        });
    </script>
@endsection
