@extends('master')

@section('title')
    File Report
@endsection

@section('body')
    <br><br><br><br>
    <form method="post" action="/missingperson/reportsighting/match" enctype="multipart/form-data">
        {{csrf_field()}}
        <div class="container">

            @if (count($errors) > 0)
                <div id="modal-error" style="color: black;">
                    Please check all the fields
                    @foreach ($errors->all() as $error)
                        <br>
                        {{ $error }}
                    @endforeach
                </div>
            @endif

            @if($matches != 'wala')
            <!-- Modal -->
                <div class="modal fade" id="resultsmodal"
                     tabindex="-1" role="dialog"
                     aria-labelledby="myLargeModalLabel"
                     aria-hidden="true">
                    <div class="modal-dialog modal-full" role="document">
                        <div class="modal-content" style="background-color: rgb(244,244,244)">
                            <div class="modal-header">
                                <center>
                                    <b>
                                        <h2>
                                            @if(count($matches) == 0)
                                                There are no matches
                                            @elseif(count($matches) != 0)
                                                Here are the matches
                                            @endif
                                        </h2>
                                    </b>
                                    <button type="button" class="close pull-right" data-dismiss="modal"
                                            aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </center>
                                <br>
                            </div>
                            @if(count($matches) != 0)
                                <div class="modal-body" style="margin: 15px">
                                    <div class="row">
                                        @foreach($matches as $missing)
                                            <div class="col-md-4" style="padding: 5px;">
                                                <div class="col-md-12"
                                                     style="background-color: white; border-radius: 10px; height: 1200px">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="pull-left">
                                                                <img src="{!! asset('images/dpthumb/'.$missing['User_picture']) !!}"
                                                                     style="max-height: 75px; max-width: 100%; margin-top: 5px"
                                                                     class="img-rounded">
                                                            </div>
                                                            <div class="pull-left" style="margin-left: 5px">
                                                                <br>
                                                                <b>Reported by:</b><br>
                                                                {{ $missing['User_name'] }}<br>
                                                                {{ $missing['User_mobilenum'] }}
                                                            </div>

                                                            <br>
                                                            <center>
                                                                <table style="height: 425px;" class="col-md-12">
                                                                    <td valign="middle" align="center">
                                                                        <img src="{!! asset('images/missing/'.$missing['Missing_picture']) !!}"
                                                                             style="max-height: 400px; max-width: 100%; margin-top: 5px"
                                                                             class="img-rounded">
                                                                        <br>
                                                                    </td>
                                                                </table>
                                                                <h4>
                                                                    Confidence: {{ round($missing['confidence']*100, 2) }}
                                                                    %
                                                                </h4>
                                                            </center>
                                                        </div>
                                                    </div>
                                                    <br>
                                                    <h5>Profile:</h5>
                                                    <HR>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <b>Name:</b> {{ $missing['Missing_name'] }}
                                                            <br>
                                                            <b>Gender:</b> {{ $missing['Missing_gender'] }}
                                                            <br>
                                                            <b>Birthday:</b> {{ $missing['Missing_bday'] }}
                                                        </div>
                                                    </div>
                                                    <br>
                                                    <h5>Details of Disappearance:</h5>
                                                    <HR>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <b>Date Of
                                                                Disappearance:</b> {{ $missing['Missing_dodis'] }}
                                                            <br>
                                                            <b>Address Last
                                                                Seen:</b> {{ $missing['Missing_disaddress'] }}
                                                        </div>
                                                    </div>
                                                    <br>
                                                    <h5>Appearance:</h5>
                                                    <HR>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <b>Height:</b> {{ $missing['Missing_height'] }} ft
                                                            <br>
                                                            <b>Weight:</b> {{ $missing['Missing_weight'] }} kg
                                                        </div>
                                                        <div class="col-md-6">
                                                            <b>Eye Color:</b> {{ $missing['Missing_eyecolor'] }}
                                                            <br>
                                                            <b>Body Physique:</b> {{ $missing['Missing_bodytype'] }}
                                                        </div>
                                                    </div>
                                                    <br>
                                                    <h5>Other Details:</h5>
                                                    <HR>
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <b>Body Markings:</b>
                                                            <br>
                                                            {{ $missing['Missing_bodymarkings'] }}
                                                        </div>
                                                        <div class="col-md-4">
                                                            <b>Clothes:</b>
                                                            <br>
                                                            {{ $missing['Missing_clothes'] }}
                                                        </div>
                                                        <div class="col-md-4">
                                                            <b>Others:</b>
                                                            <br>
                                                            {{ $missing['Missing_other'] }}
                                                        </div>
                                                    </div>
                                                    <br><br>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endif

            <br><br>
            <h1>Report Suspected Missing Person</h1>
            <hr>
            <br>

            <div style="background-color: white; padding: 20px; border-radius: 10px">
                <center>
                    <div class="col-md-8">
                        <label style="font-weight: bold">Photo of the Missing Person</label>
                        <div id="pmpdis"
                             style="padding: 20px; background-color: white; border-radius: 10px"></div>
                        <br>
                        <input type="file" id="pmp" name="pmp" accept=".jpg, .jpeg"/>
                    </div>
                </center>
                <br><br>

                <div class="row">
                    <div class="col-md-4">

                        <div class="col-md-12">
                            <label style="font-weight: bold">Date</label>
                            <div class="form-group">
                                <div class='input-group date' id='date'>
                                    <input type='text' class="form-control datetimepicker" name="date"
                                           value="{{ old('date') }}"
                                           placeholder="Date you Saw the Missing Person"/>
                                    <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"><i class="fa fa-calendar" aria-hidden="true"></i></span>
                        </span>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <label style="font-weight: bold">Time</label>
                            <div class="form-group">
                                <div class='input-group date' id='time'>
                                    <input type='text' class="form-control datetimepicker" name="time"
                                           value="{{ old('time') }}"
                                           placeholder="Time you Saw the Missing Person"/>
                                    <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"><i class="fa fa-calendar" aria-hidden="true"></i></span>
                        </span>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="col-md-4">
                        <label style="font-weight: bold">Other</label>
                        <div class="form-group">
                        <textarea type="text" class="form-control" name="other" rows="12" style="resize: none"
                                  placeholder="Other Information about the Missing Person when you saw it like clothes wore, body markings, etc">{{ old('other') }}</textarea>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <label style="font-weight: bold">Address</label>
                        <div class="form-group">
                            <textarea type="text" class="form-control" name="address" rows="12" style="resize: none"
                                      placeholder="Where you saw the missing person">{{ old('address') }}</textarea>
                        </div>
                    </div>


                </div>
            </div>

            <br><br>

            <center>
                <input type="submit" class="btn btn-primary btn-round btn-lg">
                <input type="reset" value="Cancel" class="btn btn-warning btn-round btn-lg">
            </center>


        </div>
    </form>
@endsection

@section('scripts')
    <script type="text/javascript">
        $('#resultsmodal').modal('show');

        $('#date').datetimepicker({
            icons: {
                time: "fa fa-clock-o",
                date: "fa fa-calendar",
                up: "fa fa-chevron-up",
                down: "fa fa-chevron-down",
                previous: 'fa fa-chevron-left',
                next: 'fa fa-chevron-right',
                today: 'fa fa-screenshot',
                clear: 'fa fa-trash',
                close: 'fa fa-remove'
            },
            debug: true,
            format: 'M/D/Y'

        });

        $('#time').datetimepicker({
            icons: {
                time: "fa fa-clock-o",
                date: "fa fa-calendar",
                up: "fa fa-chevron-up",
                down: "fa fa-chevron-down",
                previous: 'fa fa-chevron-left',
                next: 'fa fa-chevron-right',
                today: 'fa fa-screenshot',
                clear: 'fa fa-trash',
                close: 'fa fa-remove'
            },
            debug: true,
            format: 'HH:mm'

        });

        $(document).ready(function () {
            $("#pmp").on('change', function () {
                //Get count of selected files
                var countFiles = $(this)[0].files.length;
                var imgPath = $(this)[0].value;
                var extn = imgPath.substring(imgPath.lastIndexOf('.') + 1).toLowerCase();
                var image_holder = $("#pmpdis");
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
@endsection