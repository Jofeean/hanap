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
                <li class="@yield('user')">
                    <a href="/user/lists">
                        <i class="ti-user"></i>
                        <p>User Accounts</p>
                    </a>
                </li>
                <li class="@yield('missing')">
                    <a href="/missingperson/lists">
                        <i class="ti-help-alt"></i>
                        <p>Missing Persons</p>
                    </a>
                </li>
                <li class="@yield('police')">
                    <a href="/police/lists">
                        <i class="ti-shield"></i>
                        <p>Police Accounts</p>
                    </a>
                </li>
                <li class="@yield('update')">
                    <a href="/admin/apikey/update">
                        <i class="ti-loop"></i>
                        <p>Update API Key</p>
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
                <div class="collapse navbar-collapse">
                    <ul class="nav navbar-nav navbar-right">
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="ti-settings"></i>
                                <b class="caret"></b>
                            </a>
                            <ul class="dropdown-menu">
                                <li><a href="#" data-toggle="modal" data-target="#police">Register Police</a></li>
                                <li><a href="#" data-toggle="modal" data-target="#admin">Register Admin</a></li>
                                <li><a href="/logout">Logout</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <!-- modal police reg -->
        <div class="modal fade bd-example-modal-lg" id="police"
             tabindex="-1" role="dialog"
             aria-labelledby="myLargeModalLabel"
             aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <div class="row" style="padding-right: 10px; ">
                            <center>
                                <h4>
                                    Register Police Officer
                                </h4>
                            </center>
                        </div>
                    </div>
                    <div class="modal-body" style="margin: 15px">

                        <form action="/police/register/1" method="post" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <div class="row">
                                <div class="col-md-4 col-md-offset-4">
                                    <label style="font-weight: bold">Profile Picture</label>
                                    <div id="dpdis"
                                         style="padding: 20px; background-color: white; border-radius: 10px">
                                    </div>
                                    <br>
                                    <input type="file" id="dp" name="dp" accept=".jpg, .jpeg"/>
                                </div>
                            </div>

                            <div class="row">
                                <br>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="pfname"
                                               value="{{ old('pfname') }}"
                                               placeholder="First Name">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="plname"
                                               value="{{ old('plname') }}"
                                               placeholder="Last Name">
                                    </div>
                                </div>
                            </div>

                            <br>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <select class="form-control" name="pgender">
                                            <option value="Male">Male</option>
                                            <option value="Female">Female</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <input type="date" name="pbirthday" class="form-control"
                                               value="{{ old('pbirthday') }}">
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <input type="number" name="pmobilenum" class="form-control"
                                               value="{{ old('pmobilenum') }}"
                                               placeholder="Mobile Number">
                                    </div>
                                </div>
                            </div>

                            <br>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="paddress"
                                               value="{{ old('paddress') }}"
                                               placeholder="Address">
                                    </div>
                                </div>
                            </div>

                            <br>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <input type="text" name="pemail" class="form-control"
                                               value="{{ old('pemail') }}"
                                               placeholder="Email">
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <input type="password" name="ppassword" class="form-control" value=""
                                               placeholder="Password">
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <input type="password" class="form-control" name="prepass"
                                               placeholder="Confirm Password">
                                    </div>
                                </div>
                            </div>

                            <br>
                            <div class="footer">
                                <div class="left-side">
                                    <input type="submit" class="btn btn-info">
                                    <input type="reset" class="btn btn-warning" value="cancel">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- modal admin reg -->
        <div class="modal fade bd-example-modal-lg" id="admin"
             tabindex="-1" role="dialog"
             aria-labelledby="myLargeModalLabel"
             aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <div class="row" style="padding-right: 10px; ">
                            <center>
                                <h4>
                                    Register Admin
                                </h4>
                            </center>
                        </div>
                    </div>
                    <div class="modal-body" style="margin: 15px">

                        <form action="/admin/register/2" method="post">
                            {{ csrf_field() }}
                            <div class="row">
                                <br>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="fname" value="{{ old('fname') }}"
                                               placeholder="First Name">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="lname" value="{{ old('lname') }}"
                                               placeholder="Last Name">
                                    </div>
                                </div>
                            </div>

                            <br>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <select class="form-control" name="gender">
                                            <option value="Male">Male</option>
                                            <option value="Female">Female</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <input type="date" name="birthday" class="form-control"
                                               value="{{ old('birthday') }}">
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <input type="number" name="mobilenum" class="form-control"
                                               value="{{ old('mobilenum') }}"
                                               placeholder="Mobile Number">
                                    </div>
                                </div>
                            </div>

                            <br>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="address"
                                               value="{{ old('address') }}"
                                               placeholder="Address">
                                    </div>
                                </div>
                            </div>

                            <br>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <input type="text" name="email" class="form-control" value="{{ old('email') }}"
                                               placeholder="Email">
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <input type="password" name="password" class="form-control"
                                               placeholder="Password">
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <input type="password" class="form-control" name="repass"
                                               placeholder="Confirm Password">
                                    </div>
                                </div>
                            </div>

                            <br>
                            <div class="footer">
                                <div class="left-side">
                                    <input type="submit" class="btn btn-info">
                                    <input type="reset" class="btn btn-warning" value="cancel">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

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

<script type="text/javascript">
    $(document).ready(function () {

        $(document).ready(function () {
            @if ($errors->has('police') && $errors->has('success'))
            $.notify({
                icon: 'ti-check',
                message: "Police officer successfully registered."

            }, {
                type: 'success',
                timer: 4000
            });
            @elseif ($errors->has('police') && $errors->has('den'))
            $.notify({
                icon: 'ti-close',
                message: "Please check all the fields at the police registration form."

            }, {
                type: 'danger',
                timer: 4000
            });
            $('#police').modal('show');
            @endif

            @if ($errors->has('admin') && $errors->has('success'))
            $.notify({
                icon: 'ti-check',
                message: "Admin officer successfully registered."

            }, {
                type: 'success',
                timer: 4000
            });
            @elseif ($errors->has('admin') && $errors->has('den'))
            $.notify({
                icon: 'ti-close',
                message: "Please check all the fields at the admin registration form."

            }, {
                type: 'danger',
                timer: 4000
            });
            $('#admin').modal('show');
            @endif
        });


        $("#dp").on('change', function () {
            //Get count of selected files
            var countFiles = $(this)[0].files.length;
            var imgPath = $(this)[0].value;
            var extn = imgPath.substring(imgPath.lastIndexOf('.') + 1).toLowerCase();
            var image_holder = $("#dpdis");
            image_holder.empty();
            //loop for each file selected for uploaded.
            for (var i = 0; i < countFiles; i++) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $("<img />", {
                        "src": e.target.result,
                        'style': "max-height: 300px; max-width: 100%"
                    }).appendTo(image_holder);
                }
                image_holder.show();
                reader.readAsDataURL($(this)[0].files[i]);
            }

        });
    });
</script>

@yield('scripts')

</html>
