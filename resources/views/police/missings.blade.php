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
                                    Missing @elseif($missing->Missing_status == 1) Found @endif<br>
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