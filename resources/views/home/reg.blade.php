@extends('master')

@section('title')
    Registration
@endsection

@section('body')
    <br><br><br><br>
    <form method="post" enctype="multipart/form-data" action="/doreg">
        {{ csrf_field() }}
        <div class="container">

            <br><br>
            <h1>Registration</h1>
            <br>
            @if (count($errors) > 0)
                <div class="alert alert-danger">
                    Please check all the fields and be sure to click the captcha
                    <br>
                </div>
            @endif
            <h2>Step 1: Basic Information</h2>
            <hr>
            <br>

            <div style="background-color: white; padding: 20px; border-radius: 10px">
                <div class="row">
                    <div class="col-md-4">
                        <label style="font-weight: bold">First Name</label>
                        <div class="form-group @if($errors->has('fname')) has-danger @endif">
                            <input type="text" class="form-control" name="fname" value="{{ old('fname') }}"
                                   placeholder="First Name"
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
                                   placeholder="Middle Name"
                                   @if($errors->has('mname')) id="inputDanger1" @endif>
                            @if($errors->has('mname'))
                                <div class="form-control-feedback">Sorry, the middle name you typed is incorrect</div>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group @if($errors->has('lname')) has-danger @endif">
                            <label style="font-weight: bold">Last Name</label>
                            <input type="text" class="form-control" name="lname" value="{{ old('lname') }}"
                                   placeholder="Last Name"
                                   @if($errors->has('lname')) id="inputDanger1" @endif>
                            @if($errors->has('lname'))
                                <div class="form-control-feedback">Sorry, the last name you typed is incorrect</div>
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
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select>
                            @if($errors->has('gender'))
                                <div class="form-control-feedback">Sorry, the last name you typed is incorrect</div>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label style="font-weight: bold">Birthday</label>
                        <div class="form-group @if($errors->has('birthday')) has-danger @endif">
                            <div class='input-group date' id='datetimepicker'>
                                <input type='text' class="form-control datetimepicker" name="birthday"
                                       value="{{ old('birthday') }}"
                                       placeholder="Birthday"
                                       @if($errors->has('birthday')) id="inputDanger1" @endif>
                                <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"><i class="fa fa-calendar" aria-hidden="true"></i></span></span>
                            </div>
                            @if($errors->has('birthday'))
                                <div class="form-control-feedback">Sorry, the date of birth you typed is
                                    incorrect
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label style="font-weight: bold">Contact Number</label>
                        <div class="form-group @if($errors->has('connum')) has-danger @endif">
                            <input type="number" class="form-control" name="connum" value="{{ old('connum') }}"
                                   placeholder="Contact Number"
                                   @if($errors->has('connum')) id="inputDanger1" @endif>
                            @if($errors->has('connum'))
                                <div class="form-control-feedback">Sorry, the contact number you typed is incorrect
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <label style="font-weight: bold">Address</label>
                        <div class="form-group @if($errors->has('address')) has-danger @endif">
                            <input type="text" class="form-control" name="address" value="{{ old('address') }}"
                                   placeholder="Address"
                                   @if($errors->has('address')) id="inputDanger1" @endif>
                            @if($errors->has('address'))
                                <div class="form-control-feedback">Sorry, the address you typed is incorrect</div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <br>
            <h2>Step 2: Account Information</h2>
            <hr>
            <br>

            <div style="background-color: white; padding: 20px; border-radius: 10px">
                <div class="row">
                    <div class="col-md-4">
                        <label style="font-weight: bold">Email</label>
                        <div class="form-group @if($errors->has('email')) has-danger @endif">
                            <input type="text" class="form-control" name="email" value="{{ old('email') }}"
                                   placeholder="Email"
                                   @if($errors->has('email')) id="inputDanger1" @endif>
                            @if($errors->has('email'))
                                <div class="form-control-feedback">Sorry, the email you typed is incorrect or already
                                    registered
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label style="font-weight: bold">Password</label>
                        <div class="form-group @if($errors->has('password')) has-danger @endif">
                            <input type="password" class="form-control" name="password" placeholder="Password"
                                   @if($errors->has('password')) id="inputDanger1" @endif>
                            @if($errors->has('password'))
                                <div class="form-control-feedback">Sorry, the password you typed is incorrect. It must
                                    be 6-15 characters long
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label style="font-weight: bold">Confirm Password</label>
                        <div class="form-group @if($errors->has('repass')) has-danger @endif">
                            <input type="password" class="form-control" name="repass" placeholder="Confirm Password"
                                   @if($errors->has('repass')) id="inputDanger1" @endif>
                            @if($errors->has('repass'))
                                <div class="form-control-feedback">Sorry, the password you typed doesn't match the first
                                    one
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <br>
            <h2>Step 3: Pictures</h2>
            <hr>
            <br>

            <div class="row">
                <div class="col-md-4">
                    <label style="font-weight: bold">Profile Picture</label>
                    <div id="dpdis" style="padding: 20px; background-color: white; border-radius: 10px">
                        @if($errors->has('dp'))
                            <div class="form-control-feedback" style="color: red">Sorry, you must provide a picture
                            </div>
                        @endif
                    </div>
                    <br>
                    <input type="file" id="dp" name="dp" accept=".jpg, .jpeg"/>
                </div>
                <div class="col-md-4">
                    <label style="font-weight: bold">Valid ID 1</label>
                    <div id="vidis1" style="padding: 20px; background-color: white; border-radius: 10px">
                        @if($errors->has('vi1'))
                            <div class="form-control-feedback" style="color: red">Sorry, you must provide a valid ID
                            </div>
                        @endif
                    </div>
                    <br>
                    <input type="file" id="vi1" name="vi1" accept=".jpg, .jpeg"/>
                </div>
                <div class="col-md-4">
                    <label style="font-weight: bold">Valid ID 2</label>
                    <div id="vidis2" style="padding: 20px; background-color: white; border-radius: 10px">
                        @if($errors->has('vi1'))
                            <div class="form-control-feedback" style="color: red">Sorry, you must provide another valid
                                ID
                            </div>
                        @endif</div>
                    <br>
                    <input type="file" id="vi2" name="vi2" accept=".jpg, .jpeg"/>
                </div>
            </div>

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
                            <h5 class="modal-title text-center" id="exampleModalLabel">Terms and Condition</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body"> Far far away, behind the word mountains, far from the countries
                            Vokalia
                            and Consonantia, there live the blind texts. Separated they live in Bookmarksgrove right
                            at
                            the coast of the Semantics, a large language ocean. A small river named Duden flows by
                            their
                            place and supplies it with the necessary regelialia. It is a paradisematic country, in
                            which
                            roasted parts of sentences fly into your mouth. Even the all-powerful Pointing has no
                            control about the blind texts it is an almost unorthographic life One day however a
                            small
                            line of blind text by the name of Lorem Ipsum decided to leave for the far World of
                            Grammar.
                            <br><br>
                            <center>
                                <div class="g-recaptcha" data-sitekey="6Lc87hAUAAAAAFWWUUfvGbGR-FMi-GZpN_t_ezcY"></div>
                            </center>
                        </div>
                        <div class="modal-footer">
                            <div class="left-side">
                                <input type="submit" class="btn btn-default btn-link">
                            </div>
                            <div class="divider"></div>
                            <div class="right-side">
                                <button type="button" class="btn btn-danger btn-link">Disagree</button>
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

        $(document).ready(function () {
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

        $(document).ready(function () {
            $("#vi1").on('change', function () {
                //Get count of selected files
                var countFiles = $(this)[0].files.length;
                var imgPath = $(this)[0].value;
                var extn = imgPath.substring(imgPath.lastIndexOf('.') + 1).toLowerCase();
                var image_holder = $("#vidis1");
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

        $(document).ready(function () {
            $("#vi2").on('change', function () {
                //Get count of selected files
                var countFiles = $(this)[0].files.length;
                var imgPath = $(this)[0].value;
                var extn = imgPath.substring(imgPath.lastIndexOf('.') + 1).toLowerCase();
                var image_holder = $("#vidis2");
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