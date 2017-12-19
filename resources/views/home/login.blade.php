@extends('master')

@section('title')
    Home
@endsection

@section('body')

    <div class="container-fluid">

        <br><br><br><br><br>
        <div class="row">
            <div class="col-md-10 offset-1">
                <h1>News and Announcements</h1>
                <br>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 offset-md-1">
                <div class="card page-carousel">
                    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                        <ol class="carousel-indicators">
                            @for($i = sizeof($announcements)-1; $i>=0; $i-- )
                                <li data-target="#carouselExampleIndicators" data-slide-to="{{ $i }}"
                                    class="@if($loop->first) active @endif"></li>
                            @endfor
                        </ol>
                        <div class="carousel-inner" role="listbox" style="height: 500px;">
                            @foreach($announcements as $announcement)
                                <div class="carousel-item @if($loop->first) active @endif">
                                    <div style="margin: auto">
                                        <table style="height: 500px;">
                                            <td valign="middle" align="center">
                                                <img class="d-block img-fluid"
                                                     src="{!! asset('images/announcements/'. $announcement->Announcement_picture) !!}"
                                                     alt="First slide"
                                                     style="max-width: 100%; max-height: 500px; width: auto;">
                                            </td>
                                        </table>
                                        <div class="carousel-caption d-none d-md-block">
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <a class="left carousel-control carousel-control-prev" href="#carouselExampleIndicators"
                           role="button" data-slide="prev">
                            <span class="fa fa-angle-left"></span>
                            <span class="sr-only">Previous</span>
                        </a>
                        <a class="right carousel-control carousel-control-next"
                           href="#carouselExampleIndicators" role="button" data-slide="next">
                            <span class="fa fa-angle-right"></span>
                            <span class="sr-only">Next</span>
                        </a>
                    </div>
                </div>
            </div>

            @if(session('priv') != 'user')
                <div class="col-md-4">
                    <center>
                        <div class="card card-register" style="margin-top: 0px">
                            <h1 class="title" style="color: white">Welcome</h1>

                            @if($errors->has('notactive'))
                                <div class="alert alert-danger alert-with-icon" data-notify="container">
                                    <div class="container">
                                        <div class="alert-wrapper">
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <i class="nc-icon nc-simple-remove"></i>
                                            </button>
                                            <div class="message"><i class="nc-icon nc-bell-55"></i> Your account is not
                                                activated
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            @if($errors->has('registered'))
                                <div class="alert alert-success alert-with-icon" data-notify="container">
                                    <div class="container">
                                        <div class="alert-wrapper">
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <i class="nc-icon nc-simple-remove"></i>
                                            </button>
                                            <div class="message"><i class="nc-icon nc-bell-55"></i>
                                                You registered successfully. Please wait for the activation of your
                                                account.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <form class="register-form" method="post" action="/dologin">
                                {{ csrf_field() }}

                                <div class="form-group @if($errors->has('email')) has-danger @endif">
                                    <label class="pull-left">Email</label>
                                    <input type="text" class="form-control" name="email" value="{{ old('email') }}"
                                           aria-describedby="basic-addon1"
                                           @if(!($errors->has('email'))) placeholder="Email" @endif
                                           @if($errors->has('email')) id="inputDanger1" placeholder="Error" @endif>
                                    @if($errors->has('email'))
                                        <div class="form-control-feedback">Sorry, the email you typed is incorrect
                                        </div>
                                    @endif
                                </div>

                                <div class="form-group @if($errors->has('password')) has-danger @endif">
                                    <label class="pull-left">Password</label>
                                    <input type="password" class="form-control" name="password"
                                           placeholder="Password"
                                           @if($errors->has('password')) id="inputDanger1"
                                           placeholder="Error" @endif>
                                    @if($errors->has('password'))
                                        <div class="form-control-feedback">Sorry, the password you typed is
                                            incorrect
                                        </div>
                                    @endif
                                </div>

                                <center>
                                    <button class="btn btn-danger btn-block btn-round col-md-6">Login</button>
                                </center>

                            </form>
                            <div class="forgot">
                                {{--<a href="#" class="btn btn-link btn-default" style="color: white">Forgot password?</a>--}}
                                <a href="/registration" class="btn btn-link btn-default"
                                   style="color: white">Register!</a>
                            </div>
                        </div>
                        <div class="footer register-footer text-center" style="color: black">
                            <h6>&copy;
                                <script>document.write(new Date().getFullYear())</script>
                                , Copyrights Reserved <i class="fa fa-heart heart"></i> HANAP by Praxis
                            </h6>
                            {{--<h6>--}}
                            {{--Template by <i class="fa fa-heart heart"></i> Creative-Tim--}}
                            {{--</h6>--}}
                        </div>
                    </center>
                </div>
            @endif

            @if(session('priv') == 'user')
                <div class="col-md-4">
                    <center>
                        <div style="background-color: white; border-radius: 10px">
                            <div class="row" style="padding: 20px">
                                <div class="page-carousel">
                                    <div id="carouselExampleIndicators-1" class="carousel slide" data-ride="carousel">
                                        <ol class="carousel-indicators">
                                            <li data-target="#carouselExampleIndicators-1" data-slide-to="0"
                                                class="active"></li>
                                            <li data-target="#carouselExampleIndicators-1" data-slide-to="1"></li>
                                            <li data-target="#carouselExampleIndicators-1" data-slide-to="2"></li>
                                        </ol>
                                        <div class="carousel-inner" role="listbox" style="height: 500px;">
                                            @foreach($news as $announcement)
                                                <div class="carousel-item @if($loop->first) active @endif">
                                                    <div style="margin: auto">
                                                        <table style="height: 500px;">
                                                            <td valign="middle" align="center">
                                                                <img class="d-block img-fluid"
                                                                     src="{!! asset('images/articles/'. $announcement->News_picture) !!}"
                                                                     alt="First slide"
                                                                     style="max-width: 100%; max-height: 500px; width: auto;">
                                                            </td>
                                                        </table>
                                                        <div class="carousel-caption d-none d-md-block">
                                                        </div>
                                                    </div>
                                                    <div class="carousel-caption"
                                                         style="background: rgba(11,16,17,0.21); border-radius: 10px">
                                                        <p>{{ $announcement->News_caption }}</p>
                                                    </div>
                                                </div>
                                            @endforeach

                                        </div>

                                        <a class="left carousel-control carousel-control-prev"
                                           href="#carouselExampleIndicators-1" role="button" data-slide="prev">
                                            <span class="fa fa-angle-left"></span>
                                            <span class="sr-only">Previous</span>
                                        </a>
                                        <a class="right carousel-control carousel-control-next"
                                           href="#carouselExampleIndicators-1" role="button" data-slide="next">
                                            <span class="fa fa-angle-right"></span>
                                            <span class="sr-only">Next</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="row" style="padding: 20px">

                            </div>
                        </div>
                    </center>
                </div>
            @endif
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-10 offset-md-1">
                <h1>Missing Person List</h1>
                <br>
                <div class="row">
                    @foreach($missings as $missing)
                        <div class="col-md-4" data-toggle="modal" data-target="#{{ $missing->Missing_id }}">
                            <div class="card">
                                <div class="col-md-12">
                                    <table style="height: 350px;" class="col-md-12">
                                        <td valign="middle" align="center">
                                            <br>
                                            <img src="{!! asset('images/missingthumb/'.$missing->Missing_picture) !!}"
                                                 style="max-height: 350px; max-width: 100%;" class="img-rounded">
                                        </td>
                                    </table>
                                    <?php
                                    $date = new DateTime($missing->Missing_bday);
                                    $now = new DateTime();
                                    $interval = $now->diff($date);
                                    ?>
                                    <br>
                                    <b>Name:</b> {{ $missing->Missing_fname }} {{ $missing->Missing_mname }} {{ $missing->Missing_lname }}
                                    <br>
                                    <b>Age:</b> {{ $interval->y }}<br>
                                    <b>Missing Since:</b> {{ $missing->Missing_dodis }}
                                    <br><br>
                                </div>
                            </div>
                        </div>

                        <!-- Modal -->
                        <div class="modal fade bd-example-modal-lg" id="{{ $missing->Missing_id }}"
                             tabindex="-1" role="dialog"
                             aria-labelledby="myLargeModalLabel"
                             aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <br>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                        Reported by:
                                        @foreach($users as $user)
                                            @if($user->User_id == $missing->User_id)
                                                <div class="row">
                                                    <div class="col-md-2">
                                                        <div class="pull-right">
                                                            <img src="{!! asset('images/dpthumb/'.$user->User_picture) !!}"
                                                                 style="max-height: 75px; max-width: 100%"
                                                                 class="img-rounded">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4" style="text-align: left">
                                                        <b>{{ $user->User_fname }} {{ $user->User_mname }} {{ $user->User_lname }}</b>
                                                        <br>
                                                        <b>{{ $user->User_mobilenum }}</b>
                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                    <div class="modal-body" style="margin: 15px">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <center>
                                                    <img src="{!! asset('images/missing/'.$missing->Missing_picture) !!}"
                                                         style="max-height: 400px; max-width: 100%"
                                                         class="img-rounded">
                                                </center>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <br>
                                            <div class="col-md-6">
                                                <h4>Profile:</h4>
                                                <HR>
                                                <b>Name:</b> {{ $missing->Missing_fname }} {{ $missing->Missing_mname }} {{ $missing->Missing_lname }}
                                                <br>
                                                <b>Gender:</b> {{ $missing->Missing_gender }}
                                                <br>
                                                <b>Birthday:</b> {{ $missing->Missing_bday }}
                                                <br>
                                                <b>Address it Lives:</b> {{ $missing->Missing_livaddress }}
                                            </div>
                                            <div class="col-md-6">
                                                <h4>Details of Disappearance:</h4>
                                                <HR>
                                                <b>Date Of Disappearance:</b> {{ $missing->Missing_dodis }}
                                                <br>
                                                <b>Address Last Seen:</b> {{ $missing->Missing_disaddress }}
                                            </div>
                                        </div>
                                        <h4>Appearance:</h4>
                                        <HR>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <b>Height:</b> {{ $missing->Missing_height }} ft
                                                <br>
                                                <b>Weight:</b> {{ $missing->Missing_weight }} kg
                                            </div>
                                            <div class="col-md-4">
                                                <b>Eye Color:</b> {{ $missing->Missing_eyecolor }}
                                                <br>
                                                <b>Body Physique:</b> {{ $missing->Missing_bodytype }}
                                            </div>
                                        </div>
                                        <br>
                                        <h4>Other Details:</h4>
                                        <HR>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <b>Body Markings:</b>
                                                <br>
                                                {{ $missing->Missing_bodymarkings }}
                                            </div>
                                            <div class="col-md-4">
                                                <b>Clothes:</b>
                                                <br>
                                                {{ $missing->Missing_clothes }}
                                            </div>
                                            <div class="col-md-4">
                                                <b>Others:</b>
                                                <br>
                                                {{ $missing->Missing_other }}
                                            </div>
                                        </div>
                                        <br><br>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>


@endsection

@section('scripts')

    <script type="text/javascript">

    </script>

@endsection