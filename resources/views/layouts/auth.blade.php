<!DOCTYPE html>
<html lang="en">
<head>
    @include('layouts._meta')
    @include('layouts._assets')
</head>
<body style="background: url('{{ url('uploads/site').'/'.Settings::get('login') }}');
        background-repeat:no-repeat;">
<div class="app" id="app">
    <div class="login animated fadeIn" style="background: url('{{ url('uploads/site').'/'.Settings::get('login') }}');
            background-repeat:no-repeat;">
        <div class="navbar">
            <a class="navbar-brand text-center" style="float:none;">
                <img src="{{ url('uploads/site').'/thumb_'.Settings::get('logo') }}"
                     alt="{{ Settings::get('name') }}" class="img-circle"
                     style="margin:auto;width:60px;height:60px;">
            </a>
        </div>
        <div>
            @include('flash::message')
            @yield('content')
            <script>
                $('#phone, #mobile').intlTelInput({nationalMode: false, initialCountry: "{{strtolower(Settings::get('country_code'))}}"});
            </script>
        </div>
    </div>
</div>
</body>
</html>
