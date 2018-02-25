@extends('master')

@section('title')
    Reports
@endsection

@section('body')
    <br><br><br><br>
    <div class="container">
        <h1>Your Reports</h1>
        <br>

        <div class="row">

            @foreach($missings as $missing)
                <div class="col-md-4" data-toggle="modal" data-target="#{{ $missing->Missing_id }}">
                    <div class="card">
                        <div class="col-md-12">
                            <br>
                            <div class="col-md-12" style="height: 350px">
                                <table style="height: 350px;" class="col-md-12">
                                    <td valign="middle" align="center">
                                        <img src="{!! asset('images/missingthumb/'.$missing->Missing_picture) !!}"
                                             style="max-height: 350px; max-width: 100%;" class="img-rounded">
                                    </td>
                                </table>
                            </div>

                            <br>
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
                            <br><br>
                        </div>
                    </div>
                </div>

                <?php
                $mat = 0;
                foreach ($matches as $match) {
                    if ($match->Missing_id == $missing->Missing_id) {
                        $mat++;
                    }
                }
                ?>

            <!-- Modal -->
                @if($mat == 0)
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
                                            <br>
                                            <b>Facial Hair:</b> {{ $missing->Missing_facialhair }}
                                        </div>
                                        <div class="col-md-4">
                                            <b>Eye Color:</b> {{ $missing->Missing_eyecolor }}
                                            <br>
                                            <b>Body Physique:</b> {{ $missing->Missing_bodytype }}
                                            <br>
                                            <b>Body Hair:</b> {{ $missing->Missing_bodyhair }}
                                        </div>
                                        <div class="col-md-4">
                                            <b>Hair:</b> {{ $missing->Missing_hair }}
                                            <br>
                                            <b>Hair Color:</b> {{ $missing->Missing_hcolor }}
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
                                    <div class="row">
                                        <div class="pull-left">
                                            <a style="margin-top: 20px"
                                               href="/missingperson/found/{{ $missing->Missing_id }}">
                                                <button class="btn btn-info btn-lg">Found Already?</button>
                                            </a>
                                        </div>
                                    </div>
                                    <br>
                                </div>
                            </div>
                        </div>
                    </div>


                @elseif($mat != 0)
                <!-- Modal -->
                    <div class="modal fade bd-example-modal-lg" id="{{ $missing->Missing_id }}"
                         tabindex="-1" role="dialog"
                         aria-labelledby="myLargeModalLabel"
                         aria-hidden="true">
                        <div class="modal-dialog modal-full" role="document">
                            <div class="modal-content" style="background-color: #f5f5f5;">
                                <div class="modal-header">
                                    <br>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body" style="margin: 15px">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="card" style="padding: 10px">
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
                                                        <br>
                                                        <b>Facial Hair:</b> {{ $missing->Missing_facialhair }}
                                                    </div>
                                                    <div class="col-md-4">
                                                        <b>Eye Color:</b> {{ $missing->Missing_eyecolor }}
                                                        <br>
                                                        <b>Body Physique:</b> {{ $missing->Missing_bodytype }}
                                                        <br>
                                                        <b>Body Hair:</b> {{ $missing->Missing_bodyhair }}
                                                    </div>
                                                    <div class="col-md-4">
                                                        <b>Hair:</b> {{ $missing->Missing_hair }}
                                                        <br>
                                                        <b>Hair Color:</b> {{ $missing->Missing_hcolor }}
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
                                                <div class="row">
                                                        <a style="margin-top: 20px"
                                                           href="/missingperson/found/{{ $missing->Missing_id }}">
                                                            <button class="btn btn-info btn-lg">Found Already?</button>
                                                        </a>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Matches -->
                                        <div class="col-md-6">
                                            <h3>Here are the matches!</h3>
                                            <div style="height: 1000px; overflow: scroll; overflow-y: auto; overflow-x: hidden;">
                                                @foreach($matches as $match)
                                                    @if($match->Missing_id == $missing->Missing_id)
                                                        <div class="card" style="padding: 10px">
                                                            @foreach($sightings as $sighting)
                                                                @if($sighting->Sighting_id == $match->Sighting_id)
                                                                    <div class="row">
                                                                        @foreach($users as $user)
                                                                            @if($user->User_id == $sighting->User_id)
                                                                                <div class="col-md-12">
                                                                                    <h5>Found by:</h5>
                                                                                    <div class="col-md-10 offset-1">
                                                                                        <div class="row">
                                                                                            <div>
                                                                                                <img src="{{ asset('images/dpthumb/'.$user->User_picture) }}"
                                                                                                     style="max-height: 50px"
                                                                                                     class="img-rounded">
                                                                                            </div>
                                                                                            <div style="margin-left: 5px">
                                                                                                {{ $user->User_fname }} {{ $user->User_name }} {{ $user->User_lname }}
                                                                                                <br>
                                                                                                {{ $user->User_mobilenum }}
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            @endif
                                                                        @endforeach
                                                                    </div>
                                                                    <br>
                                                                    <div class="row">
                                                                        <div class="col-md-4">
                                                                            <center>
                                                                                <img src="{{ asset('images/sightingthumb/'.$sighting->Sighting_picture) }}"
                                                                                     style="max-height: 150px"
                                                                                     class="img-rounded">
                                                                                <br>
                                                                            </center>
                                                                        </div>
                                                                        <div class="col-md-8">
                                                                            <b>Confidence:</b> {{ round($match->Match_confidence, 2) }}
                                                                            %
                                                                            <br>
                                                                            <b>Found
                                                                                at:</b> {{ $sighting->Sighting_address }}
                                                                            <br>
                                                                            <b>Time:</b> {{ $sighting->Sighting_date }} {{ $sighting->Sighting_time }}
                                                                            <br>
                                                                            <b>Other:</b> {{ $sighting->Sighting_other }}
                                                                        </div>
                                                                    </div>
                                                                @endif
                                                            @endforeach
                                                        </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
        <br><br>
        <div class="row">
            <div style="margin-left: auto; margin-right: auto">
                {{ $missings->links() }}
            </div>
        </div>
    </div>
@endsection

@section('scripts')

@endsection