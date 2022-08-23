<strong>Copyright &copy; 2021-2022 <a href="https://attendance.bkc">BKC Attendance</a>.</strong>
All rights reserved.

<script>
    $('#logout').click(function () {
        alert('hello');
    });
</script>
<!-- jQuery -->
<script src="{{ asset('js/jquery/jquery.min.js') }}"></script>
<!-- Boostrap 4 -->
<script src="{{ asset('js/bootstrap/bootstrap.bundle.min.js') }}"></script>
<!-- DataTables  & Plugins -->
<script src="{{ asset('js/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('js/datatables-buttons/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('js/datatables-buttons/buttons.print.min.js') }}"></script>
<script src="{{ asset('js/datatables-buttons/buttons.colVis.min.js') }}"></script>
<script src="{{ asset('js/datatables-bs4/dataTables.bootstrap4.min.js') }}"></script>
<!-- overlayScrollbars -->
<script src="{{ asset('js/overlayScrollbars/jquery.overlayScrollbars.min.js') }}"></script>
<!-- Select2 -->
<script src="{{ asset('js/select2.full.min.js') }}"></script>
<!-- InputMask -->
<script src="{{ asset('js/moment.min.js') }}"></script>
<script src="{{ asset('js/jquery.inputmask.min.js') }}"></script>
<!--daterangepicker-->
<script src="{{ asset('js/daterangepicker.js') }}"></script>
<!--Tempusdominus Bootstrap 4-->
<script src="{{ asset('js/tempusdominus-bootstrap-4.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('/js/adminlte.js') }}"></script>
<!-- SweetAlert2 -->
<script src="{{ asset('js/sweetalert2.min.js') }}"></script>

<!-- Page specific script -->
<script>
    $(function () {
        $("#example1").DataTable({
            "paging": false,
            "lengthChange": false,
            "searching": true,
            "ordering": true,
            "info": false,
            "autoWidth": false,
            "responsive": true,
            'aoColumnDefs': [{
                'bSortable': false,
                'aTargets': [-1] /* 1st one, start by the right */
            }],
            "oLanguage" : {
                "sSearch" : "Tìm kiếm",
                "sInfo" : "Hiển thị _START_ đến _END_ của _TOTAL_ kết quả",
                "sInfoEmpty": "Hiển thị 0 kết quả",
                "sInfoFiltered": "(Lọc từ _MAX_ kết quả)",
                "sEmptyTable" : "Không có dữ liệu",
                "sZeroRecords" : "Không tìm thấy kết quả",
                "sPrevious": "Trước",
                "next" : "Sau",
                "paginate": {
                    "sFirst": "Trang đầu",
                    "sLast": "Trang cuối",
                    "sNext": "Sau",
                    "sPrevious": "Trước"
                },
            }
        });
        $('#example2').DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
        });

        $('#course_table').DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
            "oLanguage" : {
                "sSearch" : "Tìm kiếm",
                "sInfo" : "Hiển thị _START_ đến _END_ của _TOTAL_ kết quả",
                "sInfoEmpty": "Hiển thị 0 kết quả",
                "sInfoFiltered": "(Lọc từ _MAX_ kết quả)",
                "sEmptyTable" : "Không có dữ liệu",
                "sZeroRecords" : "Không tìm thấy kết quả",
                "paginate": {
                    "sFirst": "Trang đầu",
                    "sLast": "Trang cuối",
                    "sNext": "Sau",
                    "sPrevious": "Trước"
                },
            }
        });

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var type = '{{ session('type') }}';
        var message = '{{ session('message') }}';

        if (message && type) {
            Swal.fire({
                toast: true,
                timer: 3000,
                position: 'top-end',
                iconColor: 'white',
                customClass: {
                    popup: 'colored-toast'
                },
                showConfirmButton: false,
                icon: type,
                title: message,
            });
        }

        $('#datatable').DataTable({
            "paging": false,
            "lengthChange": false,
            "searching": false,
            "ordering": true,
            "info": true,
            "autoWidth": true,
            "responsive": true,
            "columnDefs": [{
                "targets": -1,
                "orderable": false,
                "searchable": false,
            }]
        });
    });
</script>


