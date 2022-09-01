@extends('admin.layout.main')
@section('title', 'Lớp học')
@section('content')
    @isset($lecturerQuan)
        <div class="row">
            <div class="col-lg-3 col-6">
                <!-- small card -->
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3>{{$courseQuan}}</h3>

                        <p>Lớp môn học</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-school"></i>
                    </div>
                    <a href="#" class="small-box-footer">
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
                        <i class="fas fa-user-alt"></i>
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
                        <i class="fa fa-users" aria-hidden="true"></i>
                    </div>
                    <a href="#" class="small-box-footer">
                        Chi tiết <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
        </div>
    @endisset
@endsection
