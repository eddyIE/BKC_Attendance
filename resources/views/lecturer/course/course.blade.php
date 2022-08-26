@extends('lecturer.layout.main')

@section('title', 'BKACAD - Quản lí phân công')


@section('content')

    <h1 class="text-primary ">Danh sách các phân công</h1>

    {{--Bảng hiện thị các phân công--}}
    @include('lecturer.course.course_list')
@endsection

@section('script')
    <script>
        $(function () {
            $('#course_table').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
                'aoColumnDefs': [{
                    'bSortable': false,
                    'aTargets': "no-sort"
                }],
                "oLanguage": {
                    "sSearch": "Tìm kiếm",
                    "sInfo": "Hiển thị _START_ đến _END_ của _TOTAL_ kết quả",
                    "sInfoEmpty": "Hiển thị 0 kết quả",
                    "sInfoFiltered": "(Lọc từ _MAX_ kết quả)",
                    "sEmptyTable": "Không có dữ liệu",
                    "sZeroRecords": "Không tìm thấy kết quả",
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
