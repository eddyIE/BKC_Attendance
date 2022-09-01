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
                <a href="#lecturerList" class="small-box-footer">
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
@endisset
