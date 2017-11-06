<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8"/>
    <link rel="icon" type="image/png" href="{!! asset('images/logo.png') !!}">
    <link rel="apple-touch-icon" sizes="76x76" href="{!! asset('images/logo.png') !!}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>

    <title>@yield('title')</title>

    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport'/>
    <meta name="viewport" content="width=device-width"/>


    <!-- Bootstrap core CSS     -->
    <link href="{{ asset('paperdash/css/bootstrap.min.css') }}" rel="stylesheet"/>

    <!-- Animation library for notifications   -->
    <link href="{{ asset('paperdash/css/animate.min.css') }}" rel="stylesheet"/>

    <!--  Paper Dashboard core CSS    -->
    <link href="{{ asset('paperdash/css/paper-dashboard.css') }}" rel="stylesheet"/>


    <!--  CSS for Demo Purpose, don't include it in your project     -->
    <link href="{{ asset('paperdash/css/demo.css') }}" rel="stylesheet"/>


    <!--  Fonts and icons     -->
    <link href="http://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Muli:400,300' rel='stylesheet' type='text/css'>
    <link href="{{ asset('paperdash/css/themify-icons.css') }}" rel="stylesheet">

    @yield('styles')

    <style>
        .color1 {
            fill: #ee7d60;
        }

        .color2 {
            fill: #7A9E9F;
        }

        .color3 {
            fill: #68B3C8;
        }

        .color4 {
            fill: #7AC29A;
        }

        .color5 {
            fill: #F3BB45;
        }

        .color6 {
            fill: #EB5E28;
        }

    </style>

</head>
<body>
<div class="wrapper">
    <div class="sidebar" data-background-color="white" data-active-color="primary">

        <!--
            Tip 1: you can change the color of the sidebar's background using: data-background-color="white | black"
            Tip 2: you can change the color of the active button using the data-active-color="primary | info | success | warning | danger"
        -->

        <div class="sidebar-wrapper">
            <div class="logo">
                <a href="/" class="simple-text">
                    <img src="{!! asset('images/logo1.png') !!}" style="height: 60px">
                </a>
            </div>

            <ul class="nav">
                <li class="@yield('dash')">
                    <a href="/">
                        <i class="ti-panel"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li class="@yield('missing')">
                    <a href="/missingperson/reports">
                        <i class="ti-help-alt"></i>
                        <p>Missing Persons</p>
                    </a>
                </li>
                <li>
                    <a href="/logout">
                        <i class="ti-arrow-circle-left"></i>
                        <p>Logout</p>
                    </a>
                </li>
            </ul>
        </div>
    </div>

    <div class="main-panel">
        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar bar1"></span>
                        <span class="icon-bar bar2"></span>
                        <span class="icon-bar bar3"></span>
                    </button>
                    <a class="navbar-brand" href="#">@yield('indication')</a>
                </div>
            </div>
        </nav>

        @yield('body')
        <footer class="footer">
            <div class="container-fluid">
                <div class="copyright pull-right">
                    &copy;
                    <script>document.write(new Date().getFullYear())</script>
                    , made with <i class="fa fa-heart heart"></i> by <a href="http://www.creative-tim.com">Creative
                        Tim</a>
                </div>
            </div>
        </footer>
    </div>
</div>
</body>

<!--   Core JS Files   -->
<script src="{{ asset('paperdash/js/jquery-1.10.2.js') }}" type="text/javascript"></script>
<script src="{{ asset('paperdash/js/bootstrap.min.js') }}" type="text/javascript"></script>

<!--  Checkbox, Radio & Switch Plugins -->
<script src="{{ asset('paperdash/js/bootstrap-checkbox-radio.js') }}"></script>

<!--  Charts Plugin -->
<script src="{{ asset('paperdash/js/chartist.min.js') }}"></script>

<!--  Notifications Plugin    -->
<script src="{{ asset('paperdash/js/bootstrap-notify.js') }}"></script>

<!--  Google Maps Plugin    -->
<script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCjfaN0UOgDsLhmGNnK7fJVHQTTQ-w3BWQ&callback"
        type="text/javascript"></script>

<!-- Paper Dashboard Core javascript and methods for Demo purpose -->
<script src="{{ asset('paperdash/js/paper-dashboard.js') }}"></script>

<!-- Paper Dashboard DEMO methods, don't include it in your project! -->

@yield('scripts')

</html>
