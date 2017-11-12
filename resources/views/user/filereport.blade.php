@extends('master')

@section('title')
    File Report
@endsection

@section('body')
    <br><br><br><br>
    <form method="post" enctype="multipart/form-data" action="/dofile">
        {{csrf_field()}}
        <div class="container">


            <br><br>
            <h1>File a Report</h1>
            <br>
            <h2>Step 1: Basic Information of the Missing Person</h2>
            <hr>
            <br>

            <div style="background-color: white; padding: 20px; border-radius: 10px">
                <div class="row">
                    <div class="col-md-4">
                        <label style="font-weight: bold">First Name</label>
                        <div class="form-group @if($errors->has('fname')) has-danger @endif">
                            <input type="text" class="form-control" name="fname" value="{{ old('fname') }}"
                                   placeholder="Ex: Juan"
                                   @if($errors->has('fname')) id="inputDanger1" @endif>
                            @if($errors->has('fname'))
                                <div class="form-control-feedback">Sorry, the first name you typed is incorrect</div>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label style="font-weight: bold">Middle Name</label>
                        <div class="form-group @if($errors->has('mname')) has-danger @endif">
                            <input type="text" class="form-control" name="mname" value="{{ old('mname') }}"
                                   placeholder="Ex: Luna"
                                   @if($errors->has('mname')) id="inputDanger1" @endif>
                            @if($errors->has('mname'))
                                <div class="form-control-feedback">Sorry, the middle name you typed is incorrect</div>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label style="font-weight: bold">Last Name</label>
                        <div class="form-group @if($errors->has('lname')) has-danger @endif">
                            <input type="text" class="form-control" name="lname" value="{{ old('lname') }}"
                                   placeholder="Ex: Dela Cruz III"
                                   @if($errors->has('lname')) id="inputDanger1" @endif>
                            @if($errors->has('lname'))
                                <div class="form-control-feedback">Sorry, the middle name you typed is incorrect</div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <label style="font-weight: bold">Gender</label>
                        <div class="form-group @if($errors->has('gender')) has-danger @endif">
                            <select class="form-control" name="gender"
                                    @if($errors->has('gender')) id="inputDanger1" @endif>
                                <option value="-- Select --">-- Select --</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select>
                            @if($errors->has('gender'))
                                <div class="form-control-feedback">Sorry, the gender you selected is incorrect</div>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label style="font-weight: bold">Birthday</label>
                        <div class="form-group @if($errors->has('birthday')) has-danger @endif">
                            <div class='input-group date' id='datetimepicker'>
                                <input type='text' class="form-control datetimepicker" name="birthday"
                                       value="{{ old('birthday') }}"
                                       placeholder="Birthday" @if($errors->has('birthday')) id="inputDanger1" @endif>
                                <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"><i class="fa fa-calendar" aria-hidden="true"></i></span>
                                </span>
                            </div>
                            @if($errors->has('birthday'))
                                <div class="form-control-feedback">Sorry, the date of birth typed is incorrect</div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <label style="font-weight: bold">Address</label>
                        <div class="form-group @if($errors->has('address')) has-danger @endif">
                            <input type="text" class="form-control" name="address" value="{{ old('address') }}"
                                   placeholder="Address Where the Missing Person Lives"
                                   @if($errors->has('address')) id="inputDanger1" @endif>
                            @if($errors->has('address'))
                                <div class="form-control-feedback">Sorry, the address you typed is incorrect</div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <br>
            <h2>Step 2: Physical Appearance</h2>
            <hr>
            <br>

            <div style="background-color: white; padding: 20px; border-radius: 10px">
                <div class="row">
                    <div class="col-md-4">
                        <label style="font-weight: bold">Height</label>
                        <div class="form-group @if($errors->has('height')) has-danger @endif">
                            <input type="text" class="form-control" name="height" value="{{ old('height') }}"
                                   placeholder="Height of the Missing Person in Foot"
                                   @if($errors->has('height')) id="inputDanger1" @endif>
                            @if($errors->has('height'))
                                <div class="form-control-feedback">Sorry, the height you typed is incorrect</div>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label style="font-weight: bold">Weight</label>
                        <div class="form-group @if($errors->has('weight')) has-danger @endif">
                            <input type="text" class="form-control" name="weight" value="{{ old('weight') }}"
                                   placeholder="Weight of the Missing Person in Kilogram"
                                   @if($errors->has('weight')) id="inputDanger1" @endif>
                            @if($errors->has('weight'))
                                <div class="form-control-feedback">Sorry, the weight you typed is incorrect</div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <label style="font-weight: bold">Eye Color</label>
                        <div class="form-group @if($errors->has('eye')) has-danger @endif">
                            <input type="text" class="form-control" name="eye" value="{{ old('eye') }}"
                                   placeholder="Color of the Eye like Blue, Green, Black etc."
                                   @if($errors->has('eye')) id="inputDanger1" @endif>
                            @if($errors->has('eye'))
                                <div class="form-control-feedback">Sorry, the eye color you typed is incorrect</div>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label style="font-weight: bold">Body Type</label>
                        <div class="form-group @if($errors->has('btype')) has-danger @endif">
                            <input type="text" class="form-control" name="btype" value="{{ old('btype') }}"
                                   placeholder="Body Type like Obese, Thin, Buffed etc."
                                   @if($errors->has('btype')) id="inputDanger1" @endif>
                            @if($errors->has('btype'))
                                <div class="form-control-feedback">Sorry, the body you typed is incorrect</div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <br>
            <h2>Step 3: Details of the Disappearance</h2>
            <hr>
            <br>

            <div style="background-color: white; padding: 20px; border-radius: 10px">
                <div class="row">
                    <div class="col-md-4">
                        <label style="font-weight: bold">Date of Disappearance</label>
                        <div class="form-group @if($errors->has('dodis')) has-danger @endif">
                            <div class='input-group date' id='dodis'>
                                <input type='text' class="form-control datetimepicker" name="dodis"
                                       value="{{ old('dodis') }}"
                                       placeholder="Date of Disappearance"
                                       @if($errors->has('dodis')) id="inputDanger1" @endif>
                                <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"><i class="fa fa-calendar" aria-hidden="true"></i></span>
                        </span>
                            </div>
                            @if($errors->has('dodis'))
                                <div class="form-control-feedback">Sorry, the date of disappearance you typed is
                                    incorrect
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-1">
                        <label style="font-weight: bold">Zone</label>
                        <div class="form-group">
                            <select class="form-control" name="zone">
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                                <option value="6">6</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-11">
                        <label style="font-weight: bold">Address</label>
                        <div class="form-group @if($errors->has('disaddress')) has-danger @endif">
                            <input type="text" class="form-control" name="disaddress" value="{{ old('disaddress') }}"
                                   placeholder="Address Where the Missing Person Disappeared"
                                   @if($errors->has('disaddress')) id="inputDanger1" @endif>
                            @if($errors->has('disaddress'))
                                <div class="form-control-feedback">Sorry, the address you typed is incorrect</div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <br>
            <h2>Step 4: Additional Information</h2>
            <hr>
            <br>

            <div style="background-color: white; padding: 20px; border-radius: 10px">
                <div class="row">
                    <div class="col-md-4">
                        <label style="font-weight: bold">Body Markings</label>
                        <div class="form-group @if($errors->has('bmark')) has-danger @endif">
                        <textarea type="text" class="form-control" name="bmark" rows="12" style="resize: none"
                                  @if($errors->has('bmark')) id="inputDanger1" @endif
                                  placeholder="Body Markings like Tattoo on the Shoulder, Birth Mark at the back, Body Pierce at the Lips etc.">{{ old('bmark') }}</textarea>
                            @if($errors->has('bmark'))
                                <div class="form-control-feedback">Sorry, the body markings you typed is incorrect</div>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label style="font-weight: bold">Clothes</label>
                        <div class="form-group @if($errors->has('clothes')) has-danger @endif">
                        <textarea type="text" class="form-control" name="clothes" rows="12" style="resize: none"
                                  @if($errors->has('clothes')) id="inputDanger1" @endif
                                  placeholder="Clothes Wore by the Missing Person before He went Missing">{{ old('clothes') }}</textarea>
                            @if($errors->has('clothes'))
                                <div class="form-control-feedback">Sorry, the clothes you typed is incorrect</div>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label style="font-weight: bold">Other</label>
                        <div class="form-group @if($errors->has('other')) has-danger @endif">
                        <textarea type="text" class="form-control" name="other" rows="12" style="resize: none"
                                  @if($errors->has('other')) id="inputDanger1" @endif
                                  placeholder="Other Information about the Missing Person like Mentally Ill, Arm has been Decapitated etc.">{{ old('other') }}</textarea>
                            @if($errors->has('other'))
                                <div class="form-control-feedback">Sorry, the clothes you typed is incorrect</div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <br>
            <h2>Step 5: Picture</h2>
            <hr>
            <br>

            <center>
                <div class="col-md-8">
                    <label style="font-weight: bold">Photo of the Missing Person</label>
                    <div id="pmpdis" style="height: 350px; padding: 20px; background-color: white; border-radius: 10px">
                        <h3>Example of a good picture</h3>
                        <img src="{!! asset('images/sample.jpg') !!}" height="250px">
                        <h6>Image will be use for finding a match</h6>
                        @if($errors->has('pmp'))
                            <div class="form-control-feedback" style="color: red">Sorry, you must provide a picture
                            </div>
                        @endif
                    </div>
                    <br>
                    <input type="file" id="pmp" name="pmp" accept=".jpg, .jpeg"/>
                </div>
            </center>

            <br>
            <br>
            <br>

            <center>
                <button type="button" class="btn btn-primary btn-round btn-lg" data-toggle="modal"
                        data-target="#condition">Submit
                </button>
                <input type="reset" value="Cancel" class="btn btn-warning btn-round btn-lg">
            </center>

            <!-- Modal -->
            <div class="modal fade" id="condition" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                 aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title text-center" id="exampleModalLabel">Terms</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            Filing a Missing Person Report is subject for public viewing and can be seen by other users.
                            Information that a user submits can also be used a piece of evidence in accordance to the
                            laws of the Republic of the Philippines.

                            <br><br>

                            After declaring that a Missing Person has been Found. There will be a buffer time of 24
                            hours before the Found Person can be declared again as Missing. This is to prevent spam and
                            damaging the website.

                            <br><br>

                            By clicking “Submit” I agree and understand the terms that were presented.
                        </div>
                        <div class="modal-footer">
                            <div class="left-side">
                                <input type="submit" class="btn btn-default btn-link">
                            </div>
                            <div class="divider"></div>
                            <div class="right-side">
                                <button type="button" class="btn btn-danger btn-link" data-dismiss="modal"
                                        aria-label="Close">Disagree
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </form>
@endsection

@section('scripts')
    <script type="text/javascript">
        $('#datetimepicker').datetimepicker({
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

        $('#dodis').datetimepicker({
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
            format: 'M/D/Y',

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