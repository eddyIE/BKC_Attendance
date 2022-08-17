<strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong>
All rights reserved.
<div class="float-right d-none d-sm-inline-block">
    <b>Version</b> 3.1.0
</div>

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
<!-- Page specific script -->
<script>
    $(function () {
        $('#timepicker').datetimepicker({
            format: 'HH:mm',
            pickDate: false,
            pickSeconds: false,
            pick12HourFormat: false,
        });

        $("#example1").DataTable({
            "paging": false,
            "lengthChange": false,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
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
    });
</script>
