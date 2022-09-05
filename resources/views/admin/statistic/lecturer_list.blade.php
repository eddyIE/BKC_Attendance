<div class="row" id="lecturerList">
    <div class="col-md-12">
        <div class="card card-success">
            <div class="card-header">
                <h3 class="card-title">Danh sách giảng viên</h3>

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
                        <th class="border-0 text-center">Tên giảng viên</th>
                        <th class="border-0 text-center">Số điện thoại</th>
                        <th class="border-0 text-center">Thời gian tạo tài khoản</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($lecturers as $each)
                        <tr>
                            <td class="text-center">{{$loop->index+1}}</td>
                            <td>{{$each->full_name}}</td>
                            <td>{{$each->phone}}</td>
                            <td>{{$each->created_at}}</td>
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
