<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <head>
        <meta harset="utf-8"/>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
        <link rel="icon" type="image/png" href="{!! asset('images/logo.png') !!}">
        <link rel="apple-touch-icon" sizes="76x76" href="{!! asset('images/logo.png') !!}">
        <title>@yield('title')</title>

        <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport'/>
        <meta name="viewport" content="width=device-width"/>

        <link href="{!! asset('css/bootstrap.min.css') !!}" rel="stylesheet"/>
        <link href="{!! asset('css/paper-kit.css?v=2.0.1') !!}" rel="stylesheet"/>

        <link href="{!! asset('css/demo.css') !!}" rel="stylesheet"/>

        <!--     Fonts and icons     -->
        <link href='http://fonts.googleapis.com/css?family=Montserrat:400,300,700' rel='stylesheet' type='text/css'>
        <link href="http://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
        <link href="{!! asset('css/nucleo-icons.css') !!}" rel="stylesheet"/>

        <style>
            #imagePreview {
                width: 180px;
                height: 180px;
                background-position: center center;
                background-size: cover;
                -webkit-box-shadow: 0 0 1px 1px rgba(0, 0, 0, .3);
                display: inline-block;
            }
        </style>

        @yield('styles')

    </head>
</head>
<body style="background-color: rgba(0,0,0,0.04)">
@include('includes.nav')
@yield('body')
<br><br><br><br>
</body>

<!-- Core JS Files -->
<script src="{!! asset('js/jquery-3.2.1.js') !!}" type="text/javascript"></script>
<script src="{!! asset('js/jquery-ui-1.12.1.custom.min.js') !!}" type="text/javascript"></script>
<script src="{!! asset('js/tether.min.js') !!}" type="text/javascript"></script>
<script src="{!! asset('js/bootstrap.min.js') !!}" type="text/javascript"></script>
<script src="{!! asset('js/angular.min.js') !!}" type="text/javascript"></script>
<script src='https://www.google.com/recaptcha/api.js'></script>

<!-- Switches -->
<script src="{!! asset('js/bootstrap-switch.min.js') !!}"></script>

<!--  Plugins for Slider -->
<script src="{!! asset('js/nouislider.js') !!}"></script>

<!--  Plugins for DateTimePicker -->
<script src="{!! asset('js/moment.min.js') !!}"></script>
<script src="{!! asset('js/bootstrap-datetimepicker.min.js') !!}"></script>

<!--  Paper Kit Initialization and functons -->
<script src="{!! asset('js/paper-kit.js?v=2.0.1') !!}"></script>

@yield('scripts')

</html>
