<!doctype html>
<html lang="en">
<head>
    @include('admin.layout.header')
</head>
<style>
    @yield('css')
</style>
<body class="hold-transition sidebar-mini layout-fixed sidebar-collapse">
    <nav>
        @include('admin.layout.nav')
    </nav>

    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="card card-body ">
                        @yield('content')
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer class="main-footer">
        @yield('script')
        @include('admin.layout.footer')
    </footer>
</body>
</html>
