@extends('admin.layout.main')
@section('title', 'Lớp học')
@section('content')
    <h2 class="fw-bold mb-5 text-center">THỐNG KÊ CHUNG</h2>
    @isset($lecturerQuan)
        <div class="row justify-content-center">
            <div class="col-lg-3 col-6">
                <!-- small card -->
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3>{{$courseQuan}}</h3>

                        <p>Lớp môn học chưa kết thúc</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-chalkboard"></i>
                    </div>
                    <a href="{{ asset('admin/course') }}" class="small-box-footer">
                        Chi tiết <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <!-- small card -->
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3>{{$lecturerQuan}}</h3>

                        <p>Giảng viên</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-glasses"></i>
                    </div>
                    <a href="#" class="small-box-footer">
                        Chi tiết <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <!-- small card -->
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3>{{$studentQuan}}</h3>

                        <p>Sinh viên đang theo học</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-user-graduate" aria-hidden="true"></i>
                    </div>
                    <a href="{{ asset('admin/student') }}" class="small-box-footer">
                        Chi tiết <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <!-- small card -->
                <div class="small-box bg-danger">
                    <div class="inner">
                        <h3>{{$classQuan}}</h3>

                        <p>Lớp học</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-users" aria-hidden="true"></i>
                    </div>
                    <a href="{{ asset('admin/class') }}" class="small-box-footer">
                        Chi tiết <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
        </div>

        {{--Sinh viên nghỉ học nhiều--}}
        <div class="row">
            <div class="col-md-12">
                <div class="card card-danger collapsed-card">
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
                                    <td>{{$loop->index+1}}</td>
                                    <td>{{$each->full_name}}</td>
                                    <td>{{$each->code}}</td>
                                    <td>{{$each->birthdate}}</td>
                                    <td>{{$each->class_name}}</td>
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
    @endisset
@endsection
