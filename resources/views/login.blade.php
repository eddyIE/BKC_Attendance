<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Điểm Danh BKACAD</title>
    <link rel="icon" href="{{ asset('img/bkacad.png') }}">

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('css/fontawesome-free/css/all.min.css') }}">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="{{ asset('css/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('css/adminlte.min.css') }}">

</head>
<body class="hold-transition login-page" style="background-image: url('{{asset('img/website-login-background.jpg')}}')">
    <div class="login-box">
    <div class="card">
        <div class="card-header text-center">
            <h1><b class="text-uppercase">Đăng Nhập</b></h1>
        </div>
        <div class="card-body">
            @if($errors->any())
                <div class="alert alert-danger">
                    @foreach($errors->all() as $message)
                        {{ $message }}<br>
                    @endforeach
                </div>
            @else
                <p class="login-box-msg"></p>
            @endif
            <form action="{{ asset('login-process') }}" method="post">
                @csrf
                <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="Username" name="username">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-user"></span>
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <input type="password" class="form-control" placeholder="Password" name="password">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-8"></div>
                    <!-- /.col -->
                    <div class="col-4">
                        <button type="submit" class="btn btn-primary btn-block">Đăng Nhập</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
    <script>
        <!-- jQuery -->
        <script src="{{ asset('js/jquery/jquery.min.js') }}" async></script>
        <!-- Bootstrap 4 -->
        <script src="{{ asset('js/bootstrap/bootstrap.bundle.min.js') }}" async></script>
        <!-- AdminLTE App -->
        <script src="{{ asset('js/adminlte.min.js') }}" async></script>
    </script>
</body>
</html>
