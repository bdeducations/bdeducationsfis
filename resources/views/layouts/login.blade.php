<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <!-- Bootstrap 3.3.6 -->
        <link rel="stylesheet" href="{{ url('/')}}/public/adminlte/bootstrap/css/bootstrap.min.css">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
        <!-- Ionicons -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
        <!-- Theme style -->
        <link rel="stylesheet" href="{{ url('/')}}/public/adminlte/dist/css/AdminLTE.min.css">
        <!-- iCheck -->
        <link rel="stylesheet" href="{{ url('/')}}/public/adminlte/plugins/iCheck/square/blue.css">
        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Scripts -->
        <script type="text/javascript">
            window.Laravel = {!! json_encode([
                'csrfToken' => csrf_token(),
            ]) !!};
        </script>
    </head>
    <body class="hold-transition login-page">
        <div class="login-box">
            <div class="login-logo">
                <a href="{{ url('/')}}"><b>bdeducations</b> FIS</a>
            </div>
            @yield('content')
        </div>
        <!-- Scripts -->
        <script src="{{ url('/')}}/public/adminlte/plugins/jQuery/jquery-2.2.3.min.js"></script>
        <script src="{{ url('/')}}/public/adminlte/bootstrap/js/bootstrap.min.js"></script>
        <script src="{{ url('/')}}/public/adminlte/plugins/iCheck/icheck.min.js"></script>
        <script type="text/javascript">
            $(function () {
                $('input').iCheck({
                  checkboxClass: 'icheckbox_square-blue',
                  radioClass: 'iradio_square-blue',
                  increaseArea: '20%' // optional
                });
            });
        </script>
    </body>
</html>
