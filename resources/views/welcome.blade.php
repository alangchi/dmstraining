<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <!-- <title>{{ config('app.name', 'Laravel') }}</title> -->
        <title>DMS - @yield('title')</title>
        <link href="{{{ asset('/css/app.css') }}}" rel="stylesheet">
        <!-- favicon -->
        <link rel="shortcut icon" href="{{{ asset('/images/logo_img.png') }}}">
        <!-- Styles -->
        <link href="/css/dashboard.css" rel="stylesheet">
        <script src="/js/jquery-3.1.1.min.js"></script>
        <script>
            window.Laravel = <?php echo json_encode([
                'csrfToken' => csrf_token(),
            ]); ?>
        </script>
        <style type="text/css">
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Raleway', sans-serif;
                font-weight: 100;
                height: 100vh;
                margin: 0;
            }

            .container-fluid{
                /*background: black;*/
            }
            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 25px;
                font-weight: bold;
            }

            .m-b-md {
                margin-bottom: 50px;
            }
        </style>
    </head>
    <body>
    <div class="container-fluid">
        
        <div class="pull-right">
            <ul>
                <a href="{{ url('/login') }}" class="btn btn-primary">Login</a>
                <a href="{{ url('/register') }}" class="btn btn-primary">Register</a>
            </ul>
        </div>

        <div class="flex-center position-ref full-height">

            @if (Route::has('login'))
                <div class="top-right links">
                    <a href="{{ url('/login') }}">Login</a>
                    <a href="{{ url('/register') }}">Register</a>
                </div>
            @endif

            <div class="content">

                <div class="title m-b-md">
                    @yield('content')
                </div>
            </div>
        </div>
        </div>
    <!-- Scripts -->
    <script src="/js/app.js"></script>
    <script src="/js/common.js"></script>
    </body>
</html>

