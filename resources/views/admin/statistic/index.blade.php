@extends('admin.layout.main')
@section('title', 'Lớp học')
@section('content')
    <h2 class="fw-bold mb-5 text-center">THỐNG KÊ CHUNG</h2>

    {{--Thông tin chung--}}
    @include('admin.statistic.general_info')
    {{--Chart thống kê chuyên cần--}}
    @include('admin.statistic.course_qualified_chart')

    {{--Danh sách sinh viên nghỉ nhiều--}}
    @include('admin.statistic.student_absent_table')

    {{--Danh sách giảng viên--}}
    @include('admin.statistic.lecturer_list')
@endsection

@section('script')
    <script src="{{asset('/js/chart.js/Chart.min.js')}}"></script>
    <script>
        $(function () {
            var donutChartCanvas = $('#donutChart').get(0).getContext('2d')
            var donutData = {
                labels: [
                    'Đủ điều kiện',
                    'Thi lại',
                    'Học lại',
                ],
                datasets: [
                    @php
                        if(isset($courseDataSet)){
                            echo json_encode($courseDataSet);
                        }
                    @endphp
                ]
            }
            var donutOptions = {
                maintainAspectRatio: false,
                responsive: true,
            }
            //Create pie or douhnut chart
            // You can switch between pie and douhnut using the method below.
            new Chart(donutChartCanvas, {
                type: 'doughnut',
                data: donutData,
                options: donutOptions
            })
        });
    </script>
@endsection
