<nav class="main-header navbar navbar-expand-sm" style="background: #006182">
    <ul class="navbar-nav">
        <li class="nav-item" style="display: flex;align-items: center">
            <a class="nav-link text-white" data-widget="pushmenu" href="#" role="button" style="color: #156A8F">
                <i class="fas fa-bars"></i>
            </a>
        </li>
    </ul>
    <div class="container">
        <div class="navbar-header">
            <a class="navbar-brand text-uppercase text-white fw-bold fs-2" href="{{ asset('/') }}">
                Hệ thống điểm danh - Học viện công nghệ BKACAD
            </a>
        </div>
        <ul class="navbar-nav float-right" style="float:right">
            <li class="nav-item"><a class="nav-link text-white fs-5" href="#">{{ auth()->user()->full_name }}</a></li>
            <li class="nav-item"><a class="nav-link text-white fs-5" href="{{ asset('logout') }}">Đăng xuất</a></li>
        </ul>
    </div>
</nav>
