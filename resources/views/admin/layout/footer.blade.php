<strong>Copyright &copy; 2021-2022 <a href="https://attendance.bkc">BKC Attendance</a>.</strong>
All rights reserved.

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
<!-- SweetAlert2 -->
<script src="{{ asset('js/sweetalert2.min.js') }}"></script>
<!-- dropzonejs -->
<script src="{{ asset('js/dropzone.min.js') }}"></script>
<!-- Select2 -->
<script src="{{ asset('js/select2.full.min.js') }}"></script>
<!-- InputMask -->
<script src="{{ asset('js/moment.min.js') }}"></script>
<script src="{{ asset('js/jquery.inputmask.min.js') }}"></script>
<!--daterangepicker-->
<script src="{{ asset('js/daterangepicker.js') }}"></script>
<!-- bootstrap color picker -->
<script src="{{ asset('js/bootstrap-colorpicker.min.js') }}"></script>
<!--Tempusdominus Bootstrap 4-->
<script src="{{ asset('js/tempusdominus-bootstrap-4.min.js') }}"></script>
<!-- Fullcalendar -->
<script src="{{ asset('js/fullcalendar/lib/main.js') }}"></script>
<script src="{{ asset('js/fullcalendar/lib/locales/vi.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('/js/adminlte.min.js') }}"></script>

<script>
    $(document).ready(function () {
        var type = '{{ session('type') }}';
        var message = '{{ session('message') }}';

        if (message && type){
            Swal.fire({
                toast: true,
                timer: 3000,
                timerProgressBar: true,
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
