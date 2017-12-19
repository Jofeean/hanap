@extends('master2')

@section('title')
    Missing Person List
@endsection

@section('indication')
    Missing Person List
@endsection

@section('missing')
    active
@endsection

@section('body')


    <div class="content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-md-12">
                    <div style="background-color: white; border-radius: 10px">
                        <div class="row" style="padding: 20px">
                            <div class="page-carousel col-md-12">
                                <div id="carouselExampleIndicators-1" class="carousel slide"
                                     data-ride="carousel">
                                    <div class="carousel-inner" style="height: 370px;">
                                        <?php $i = $t = 0; $gals = array(); ?>
                                        @foreach($galleries as $gallery)
                                            <?php

                                            if ($loop->first) {
                                                $t = 1;
                                            } elseif ($i != 7) {
                                                array_push($gals, $gallery);
                                            }
                                            ?>

                                            @if($i == 6)
                                                <div class="item @if($t == 1) active @endif">
                                                    <div style="margin: auto">
                                                        <table style="height: 370px;">

                                                            <td valign="middle" align="center">
                                                                <div class="row" style="height: 250px">
                                                                    @foreach($gals as $gal)
                                                                        <div class="col-md-2">
                                                                            <img class="d-block img-fluid"
                                                                                 src="{!! asset('images/missingthumb/'. $gal->Missing_picture) !!}"
                                                                                 alt="First slide"
                                                                                 style="max-width: 100%; max-height: 250px; width: auto;"><br>
                                                                        </div>
                                                                    @endforeach
                                                                </div>
                                                                <div class="row">
                                                                    @foreach($gals as $gal)
                                                                        <div class="col-md-2">
                                                                            Name: {{ $gal->Missing_fname }} {{ $gal->Missing_lname }}
                                                                            <br>
                                                                            Missing
                                                                            since: {{ $gal->Missing_dodis }}
                                                                        </div>
                                                                    @endforeach
                                                                </div>
                                                            </td>
                                                            <?php $t = 0 ?>
                                                        </table>
                                                        <div class="carousel-caption d-none d-md-block">
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php $gals = array(); $i = 0?>

                                            @elseif($loop->last)

                                                <div class="carousel-item @if($t == 1) active @endif">
                                                    <div style="margin: auto">
                                                        <table style="height: 370px;">

                                                            <td valign="middle" align="center">
                                                                <div class="row" style="height: 250px">
                                                                    @foreach($gals as $gal)
                                                                        <div class="col-md-2">
                                                                            <img class="d-block img-fluid"
                                                                                 src="{!! asset('images/missingthumb/'. $gal->Missing_picture) !!}"
                                                                                 alt="First slide"
                                                                                 style="max-width: 100%; max-height: 250px; width: auto;"><br>
                                                                        </div>
                                                                    @endforeach
                                                                </div>
                                                                <div class="row">
                                                                    @foreach($gals as $gal)
                                                                        <div class="col-md-2">
                                                                            Name: {{ $gal->Missing_fname }} {{ $gal->Missing_lname }}
                                                                            <br>
                                                                            Missing
                                                                            since: {{ $gal->Missing_dodis }}
                                                                        </div>
                                                                    @endforeach
                                                                </div>
                                                            </td>
                                                            <?php $t = 0 ?>
                                                        </table>
                                                        <div class="carousel-caption d-none d-md-block">
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php $gals = array()?>
                                            @endif

                                            <?php $i++; ?>
                                        @endforeach
                                    </div>
                                    <a class="left carousel-control"
                                       href="#carouselExampleIndicators-1" data-slide="prev">
                                        <span class="sr-only">Previous</span>
                                    </a>
                                    <a class="right carousel-control"
                                       href="#carouselExampleIndicators-1" data-slide="next">
                                        <span class="sr-only">Next</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="row" style="padding: 20px">

                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="header">
                            <h4 class="title">All Reported Missing Persons</h4>
                            <div class="col-md-4">
                                <p class="category">Found/Still Missing</p>
                            </div>

                            <form action="#" method="">
                                <div class="col-md-7">

                                    <div class="form-group">
                                        <input type="text" class="form-control" name="search"
                                               placeholder="Name, Address, Gender, Birthdays">
                                        @if($errors->has('search'))
                                            <div style="color: red">Sorry, you must enter a text.
                                            </div>
                                        @endif
                                    </div>

                                </div>

                                <div class="col-md-1">
                                    <input type="submit" value="Search" class="btn btn-info">
                                </div>

                            </form>

                        </div>

                        <div class="content table-responsive table-full-width">
                            <table class="table table-striped">
                                <thead>
                                <th>Missing ID</th>
                                <th>Picture</th>
                                <th>Name</th>
                                <th>Date Missing</th>
                                <th>Address Missing</th>
                                <th>Gender</th>
                                <th>Age</th>
                                <th>Actions</th>
                                </thead>
                                <tbody>
                                @foreach($missings as $missing)
                                    <?php
                                    $date = new DateTime($missing->Missing_bday);
                                    $now = new DateTime();
                                    $interval = $now->diff($date);
                                    ?>
                                    <tr>
                                        <td>{{ $missing->Missing_id }}</td>
                                        <td>
                                            <center>
                                                <a style="margin-top: 20px"
                                                   data-toggle="modal" data-target="#{{ $missing->Missing_id }}">
                                                    <img src="{{ asset('images/missingthumb/'.$missing->Missing_picture) }}"
                                                         style="max-height: 100px; max-width: 70%"
                                                         class="img-rounded">
                                                </a>
                                            </center>
                                        </td>
                                        <td>{{ $missing->Missing_fname }} {{ $missing->Missing_mname }} {{ $missing->Missing_lname }}</td>
                                        <td>{{ $missing->Missing_dodis }}</td>
                                        <td>{{ $missing->Missing_disaddress }}</td>
                                        <td>{{ $missing->Missing_gender }}</td>
                                        <td>{{ $interval->y  }}</td>
                                        <td>
                                            <a class="btn btn-info" style="margin-top: 20px"
                                               data-toggle="modal" data-target="#{{ $missing->Missing_id }}">View
                                            </a>
                                            @if($missing->Missing_status == 0)
                                                <a class="btn btn-danger" style="margin-top: 20px"
                                                   href="/missingperson/found/{{ $missing->Missing_id }}">
                                                    Missing
                                                </a>
                                            @elseif($missing->Missing_status == 1)
                                                <a class="btn btn-success" style="margin-top: 20px"
                                                   href="/missingperson/found/{{ $missing->Missing_id }}">Found
                                                </a>
                                            @endif
                                        </td>
                                    </tr>

                                    <!-- Modal -->
                                    <div class="modal fade bd-example-modal-lg" id="{{ $missing->Missing_id }}"
                                         tabindex="-1" role="dialog"
                                         aria-labelledby="myLargeModalLabel"
                                         aria-hidden="true">
                                        <div class="modal-dialog modal-lg" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <div style="padding-left: 10px">
                                                        <br>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
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
                                                </div>
                                                <div class="modal-body" style="margin: 15px">
                                                    <div class="row">
                                                        <center>
                                                            <img src="{{ asset('images/missing/'.$missing->Missing_picture) }}"
                                                                 style="max-height: 400px; max-width: 100%"
                                                                 class="img-rounded">
                                                        </center>
                                                    </div>
                                                    <div class="row">
                                                        <br>
                                                        <div class="col-md-6">
                                                            <h4>Profile:</h4>
                                                            <hr>
                                                            <b>Name:</b> {{ $missing->Missing_fname }} {{ $missing->Missing_mname }} {{ $missing->Missing_lname }}
                                                            <br>
                                                            <b>Gender:</b> {{ $missing->Missing_gender }}
                                                            <br>
                                                            <b>Birthday:</b> {{ $missing->Missing_bday }}
                                                            <br>
                                                            <b>Address Living:</b> {{ $missing->Missing_livaddress }}
                                                            <HR>
                                                            <b>Date of Disappearance:</b> {{ $missing->Missing_dodis }}
                                                        </div>
                                                        <div class="col-md-6">
                                                            <h4>Details of Disappearance:</h4>
                                                            <HR>
                                                            <b>Date Of Disappearance:</b> {{ $missing->Missing_dodis }}
                                                            <br>
                                                            <b>Address Last Seen:</b> {{ $missing->Missing_disaddress }}
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-12">
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
                                                                    <b>Body
                                                                        Physique:</b> {{ $missing->Missing_bodytype }}
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <div class="pull-left" style="margin-left: 5px">
                                                        @if($missing->Missing_status == 0)
                                                            <a class="btn btn-danger btn-lg" style="margin-top: 20px"
                                                               href="/missingperson/found/{{ $missing->Missing_id }}">
                                                                Missing
                                                            </a>
                                                        @elseif($missing->Missing_status == 1)
                                                            <a class="btn btn-success btn-lg" style="margin-top: 20px"
                                                               href="/missingperson/found/{{ $missing->Missing_id }}">
                                                                Found
                                                            </a>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script type="text/javascript">
        $(document).ready(function () {
            @if ($errors->has('success'))
            $.notify({
                icon: 'ti-check',
                message: "Missing person was found."

            }, {
                type: 'success',
                timer: 4000
            });
            @elseif ($errors->has('denied'))
            $.notify({
                icon: 'ti-close',
                message: "Missing person was found already."

            }, {
                type: 'danger',
                timer: 4000
            });
            @endif
        });

    </script>
@endsection