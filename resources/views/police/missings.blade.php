@extends('master3')

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
            <br>

            <div class="row">
                <div class="row">
                    <div class="col-md-3">
                        <div class="card">
                            <div class="header">
                                <h4 class="title">All Reported Missing Persons</h4>
                                <p class="category">Found/Still Missing</p>
                                <br>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <form action="/missingperson/reports/search-result" method="post">
                        {{ csrf_field() }}
                        <div class="col-md-5">

                            <div class="form-group">
                                <input type="text" class="form-control" name="fname"
                                       placeholder="Name, Address, Gender, Birthdays">
                                @if($errors->has('fname'))
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

                @foreach($missings as $missing)
                    <div class="col-md-4" data-toggle="modal" data-target="#{{ $missing->Missing_id }}">
                        <div class="col-md-12 card">
                            <table style="height: 350px;" class="col-md-12">
                                <td valign="middle" align="center">
                                    <br>
                                    <img src="{!! asset('images/missingthumb/'.$missing->Missing_picture) !!}"
                                         style="max-height: 350px; max-width: 100%;" class="img-rounded">
                                </td>
                            </table>
                            <div class="col-md-12">
                                <?php
                                $date = new DateTime($missing->Missing_bday);
                                $now = new DateTime();
                                $interval = $now->diff($date);
                                ?>
                                <br>
                                <b>Name:</b> {{ $missing->Missing_fname }} {{ $missing->Missing_mname }} {{ $missing->Missing_lname }}
                                <br>
                                <b>Age:</b> {{ $interval->y }}<br>
                                <b>Status:</b> @if($missing->Missing_status == 0)
                                    <span style="color: red; font-weight: bold">Missing</span>
                                @elseif($missing->Missing_status == 1)
                                    <span style="color: lightgreen; font-weight: bold">Found</span> @endif<br>
                                <b>Missing on:</b> {{ $missing->Missing_dodis }}
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
            </div>
        </div>
    </div>
@endsection

@section('scripts')
@endsection