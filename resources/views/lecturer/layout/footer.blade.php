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
    });
</script>


