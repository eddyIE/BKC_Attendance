<!doctype html>
<html lang="en">
<head>
    @include('admin.layout.header')
</head>
<style>
    .colored-toast.swal2-icon-success {
        background-color: #a5dc86 !important;
    }

    .colored-toast.swal2-icon-error {
        background-color: #f27474 !important;
    }

    .colored-toast.swal2-icon-warning {
        background-color: #f8bb86 !important;
    }

    .colored-toast.swal2-icon-info {
        background-color: #3fc3ee !important;
    }

    .colored-toast.swal2-icon-question {
        background-color: #87adbd !important;
    }

    .colored-toast .swal2-title {
        color: white;
    }

    .colored-toast .swal2-close {
        color: white;
    }

    .colored-toast .swal2-html-container {
        color: white;
    }
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
                    <div class="card card-body">
                        @yield('content')
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer class="main-footer">
        @include('admin.layout.footer')
        @yield('script')
        @livewireScripts
    </footer>
</body>
</html>
