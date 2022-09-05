{{--Sinh viên nghỉ học nhiều--}}
<div class="row">
    <div class="col-md-12">
        <div class="card card-danger">
            <div class="card-header">
                <h3 class="card-title">Sinh viên nghỉ học nhiều 30 ngày gần đây</h3>

                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-plus"></i>
                    </button>
                </div>
                <!-- /.card-tools -->
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table id="datatable" class="table align-middle table-bordered">
                    <thead>
                    <tr class="bg-white">
                        <th class="border-0 text-center">#</th>
                        <th class="border-0 text-center">Tên sinh viên</th>
                        <th class="border-0 text-center">Mã sinh viên</th>
                        <th class="border-0 text-center">Ngày sinh</th>
                        <th class="border-0 text-center">Lớp</th>
                        <th class="border-0 text-center">Số buổi nghỉ 30 ngày gần đây</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($attendanceNoReason as $each)
                        <tr>
                            <td class="text-center">{{$loop->index+1}}</td>
                            <td>{{$each->full_name}}</td>
                            <td>{{$each->code}}</td>
                            <td>{{$each->birthdate}}</td>
                            <td>{{$each->class->name}}</td>
                            <td>{{$each->count}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
</div>
