<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4 sidebar-no-expand ">
    <!-- Brand Logo -->
    <a href="#" class="brand-link">
        <img src="{{ asset('img/bkacad.png') }}" alt="HỆ THỐNG ĐIỂM DANH BKACAD" class="brand-image"/>
        <span class="brand-text font-weight-light font-weight-bold">BKACAD</span>
    </a>
    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
                 with font-awesome or any other icon font library -->
                <li class="nav-item">
                    <a href="{{ asset('/') }}" class="nav-link">
                        <i class="nav-icon fas fa-school"></i>
                        <p>
                            TRANG CHỦ
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-graduation-cap"></i>
                        <p>
                            ĐIỂM DANH
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ asset('/course') }}" class="nav-link">
                                &ensp;<i class="far fa-circle fa-xs"></i>
                                <p>Điểm danh lớp môn học</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ asset('/my-course') }}" class="nav-link">
                                &ensp;<i class="far fa-circle fa-xs"></i>
                                <p>Danh sách phân công</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="{{ asset('/time-keeping') }}" class="nav-link">
                        <i class="nav-icon fas fa-clipboard-list"></i>
                        <p>LỊCH SỬ DẠY</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ asset('/schedule') }}" class="nav-link">
                        <i class="nav-icon far fa-calendar-alt"></i>
                        <p>THỜI KHÓA BIỂU</p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
