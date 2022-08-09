<nav class="main-header navbar navbar-expand-sm bg-dark">
    <ul class="navbar-nav">
        <li class="nav-item" style="display: flex;align-items: center">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button" style="color: #156A8F">
                <i class="fas fa-bars text-white"></i>
            </a>
        </li>
    </ul>
    <div class="container col-md-11" style="margin: 0;">
        <div class="col-md-8">
            <div class="navbar-header">
                <span class="navbar-brand text-uppercase text-white fw-bold fs-1" href="index">Hệ thống điểm danh</span>
            </div>
        </div>
        <div class="col-md-4">
            <ul class="navbar-nav float-right" style="float:right">
                <li class="nav-item"><a class="nav-link text-white fs-5" href="#">{{ auth()->user()->full_name }}</a></li>
                <li class="nav-item"><a class="nav-link text-white fs-5" href="{{ asset('logout') }}"><i class="fas fa-sign-out-alt"></i></a></li>
            </ul>
        </div>
    </div>
</nav>

<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="{{ asset('admin') }}" class="brand-link">
        <img src="{{ asset('img/bkacad.png') }}" alt="HỆ THỐNG ĐIỂM DANH BKACAD" class="brand-image" />
        <span class="brand-text font-weight-light font-weight-bold">BKACAD</span>
    </a>
    <div class="sidebar">
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                <li class="nav-item">
                    <a href="{{ asset('admin/program') }}" class="nav-link">
                        <i class="nav-icon fas fa-certificate"></i>
                        <p>
                            CHƯƠNG TRÌNH HỌC
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ asset('admin/major') }}" class="nav-link">
                        <i class="nav-icon fas fa-graduation-cap"></i>
                        <p>
                            CHUYÊN NGÀNH HỌC
                        </p>
                    </a>
                <li class="nav-item">
                    <a href="{{ asset('admin/subject') }}" class="nav-link">
                        <i class="nav-icon fas fa-book-open"></i>
                        <p>
                            BỘ MÔN
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ asset('admin/class') }}" class="nav-link">
                        <i class="nav-icon fas fa-chalkboard"></i>
                        <p>
                            LỚP HỌC
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ asset('admin/student') }}" class="nav-link">
                        <i class="nav-icon fas fa-user-graduate"></i>
                        <p>
                            SINH VIÊN
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ asset('admin/course') }}" class="nav-link">
                        <i class="nav-icon fas fa-chalkboard-teacher"></i>
                        <p>
                            KHÓA HỌC
                        </p>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</aside>
