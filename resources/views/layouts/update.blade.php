<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    <title>{{trans('update.update')}} | SMS</title>
    @include('layouts._assets')
    @yield('styles')
    <link rel="stylesheet" href="{{ asset('css/install.css') }}">
</head>
<body class="nav-md">
<div class="container body">
    <div class="main_container">
        <div class="col-md-3 left_col">
            <div class="left_col scroll-view">
                <div class="navbar nav_title" style="float:none; border: 0;">
                    <a href="{{ url('/') }}" class="logo">
                        <img src="{{ url('uploads/site/sms.png') }}" alt="logo"
                             style="width:40px;height:40px;"/>
                        SMS
                    </a>
                </div>
                @include('/update.steps')
            </div>
        </div>
        <div class="right_col" role="main">
            @include('layouts.messages')
            @yield('content')
        </div>
    </div>
</div>
<script src="{{ asset('js/libs.js') }}" type="text/javascript"></script>

@yield('scripts')
</body>
</html>
