<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
<script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
<![endif]-->
@if(Settings::get('rtl_support') == 'yes')
    <link href="{{ asset('css/rtl_libs.css') }}" rel="stylesheet" type="text/css"/>
@else
    <link href="{{ asset('css/libs.css') }}" rel="stylesheet" type="text/css"/>
@endif
<link href="{{ asset('css/sms.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset('css/icheck.css') }}" rel="stylesheet" type="text/css">
<link rel="shortcut icon" href="{{ asset('img/fav.ico') }}" type="image/x-icon">
<link rel="icon" href="{{ asset('img/fav.ico') }}" type="image/x-icon">
<link href="{{ asset('css/custom_colors.css') }}" rel="stylesheet" type="text/css"/>
<script src="{{ asset('js/libs.js') }}" type="text/javascript"></script>
<script src="{{asset('js/sms_app.js')}}" type="text/javascript"></script>
<script src="{{ asset('js/icheck.min.js') }}" type="text/javascript" ></script>
