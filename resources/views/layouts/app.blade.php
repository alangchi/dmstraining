<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

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
</head>
<body>

        

    <div class="container-fluid">
        
        <div class="row">
            <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2 part-left">
                <div class="container-fluid" >
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="logo" >
                                <a href=""><img class="img-responsive" src="/images/logo.png" id="big" alt=""/></a>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ">
                            <div class="list-menu">
                                <div class="list-group">
                                    <a href="{{ url('/devices/histories') }}" class="list-group-item"><span id="icon" class="glyphicon glyphicon-time"></span>Histories</a>
                                    <a href="{{ url('/dashboard') }}" class="list-group-item"><span id="icon" class="glyphicon glyphicon-list-alt"></span>Devices</a>
                                    <a href="{{ url('/device_infos/create_device_info') }}" class="list-group-item "><span id="icon" class="glyphicon glyphicon-plus"></span>Device Info</a>
                                    <a href="{{ url('/users/list_users') }}" class="list-group-item "><span id="icon" class="glyphicon glyphicon-th-list"></span>Users</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xs-10 col-sm-10 col-md-10 col-lg-10 abc-right">
                <div class="container-fluid batrang">
                    <div class="row row-head">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            @include('header')
                        </div>
                    </div>

                    <div class="row row-content">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            @yield('content')
                        </div>
                    </div>

                    <div class="row row-footer">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            @include('footer')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<!-- Scripts -->
<script src="/js/app.js"></script>
<script src="/js/common.js"></script>

</body>
</html>
