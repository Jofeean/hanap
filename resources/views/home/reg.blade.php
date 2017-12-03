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
                                   placeholder="Ex: Cruz"
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
                                   placeholder="Ex: Dela Luna"
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
                                <option>-- Select --</option>
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
                        <div class="form-group @if($errors->has('birthday') || $errors->has('bday')) has-danger @endif">
                            <div class='input-group date' id='datetimepicker'>
                                <input type='text' class="form-control datetimepicker" name="birthday"
                                       value="{{ old('birthday') }}"
                                       placeholder="Birthday"
                                       @if($errors->has('birthday') || $errors->has('bday')) id="inputDanger1" @endif>
                                <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"><i class="fa fa-calendar" aria-hidden="true"></i></span></span>
                            </div>
                            @if($errors->has('birthday'))
                                <div class="form-control-feedback">Sorry, the date of birth you typed is
                                    incorrect
                                </div>
                            @endif
                            @if($errors->has('bday'))
                                <div class="form-control-feedback">Sorry, you must be 18 years old.</div>
                            @endif
                        </div>
                    </div>

                    <div class="col-md-4">
                        <label style="font-weight: bold">Contact Number</label>
                        <div class="form-group @if($errors->has('connum')) has-danger @endif">
                            <input type="number" class="form-control" name="connum" value="{{ old('connum') }}"
                                   placeholder="Ex: 09123456789"
                                   @if($errors->has('connum')) id="inputDanger1" @endif>
                            @if($errors->has('connum'))
                                <div class="form-control-feedback">Sorry, the contact number you typed is incorrect
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-8">
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

                    <div class="col-md-4">
                        <label style="font-weight: bold">City</label>
                        <div class="form-group @if($errors->has('city')) has-danger @endif">
                            <select class="form-control" name="city"
                                    @if($errors->has('city')) id="inputDanger1" @endif>
                                <option value="">-- Select --</option>

                                <option value="Caloocan City">Caloocan</option>

                                <option value="Las Piñas City">Las Piñas</option>

                                <option value="Makati City">Makati</option>
                                <option value="Malabon City">Malabon</option>
                                <option value="Mandaluyong City">Mandaluyong</option>
                                <option value="Manila City">Manila</option>
                                <option value="Marikina City">Marikina</option>
                                <option value="Muntinlupa City">Muntinlupa</option>

                                <option value="Navotas City">Navotas</option>

                                <option value="Parañaque City">Parañaque</option>
                                <option value="Pasay City">Pasay</option>
                                <option value="Pasig City">Pasig</option>

                                <option value="Quezon City">Quezon</option>

                                <option value="San Juan City">San Juan</option>

                                <option value="Taguig City">Taguig</option>

                                <option value="Valenzuela City">Valenzuela</option>
                            </select>
                            @if($errors->has('city'))
                                <div class="form-control-feedback">Sorry, the city you selected is incorrect</div>
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
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title text-center" id="exampleModalLabel">Terms of Service</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">

                            <b>Terms of Service</b>

                            <br><br>

                            Last updated: (October 1, 2017)
                            Please read these Terms of Service carefully before using the www.hanap-praxis.com
                            website and the Hanap mobile application operated by Praxis. Your access to and use of the
                            service is conditioned on your acceptance of and compliance with these terms. These terms
                            apply to all users who access or use the service. By accessing or using Hanap you agree to
                            be bound by these terms. If you disagree with any part of the terms then you may not access
                            Hanap.

                            <br><br>

                            <b>Restrictions</b>

                            <br><br>

                            You are emphatically restricted from all of the following:
                            <br>
                            * publishing any Website material in any media&#59;<br>
                            * selling, sublicensing and/or otherwise commercializing any Website materia&#59;<br>
                            * publicly performing and/or showing any Website material&#59;<br>
                            * using this Website in any way that is, or may be, damaging to this Website&#59;<br>
                            * using this Website in any way that impacts user access to this Website&#59;<br>
                            * using this Website contrary to applicable laws and regulations, or in a way that causes,
                            or may cause, harm to the Website, or to any person or business entity&#59;<br>
                            * engaging in any data mining, data harvesting, data extracting or any other similar
                            activity in relation to this Website, or while using this Website&#59;<br>
                            * using this Website to engage in any advertising or marketing&#59;<br>
                            Certain areas of this Website are restricted from access by you and Praxis may further
                            restrict access by you to any areas of this Website, at any time, in its sole and absolute
                            discretion.  Any user ID and password you may have for this Website are confidential and you
                            must maintain confidentiality of such information.

                            <br><br>

                            <b>Termination</b>

                            <br><br>

                            We may terminate or suspend your access to Hanap immediately, without prior notice or
                            liability, for any reason whatsoever, including without limitation if you breach the Terms.

                            <br><br>

                            <b>Changes</b>

                            <br><br>

                            We reserve the right, at our sole discretion, to modify or replace these Terms at any time.
                            If a revision is material we will try to provide at least 30 days notice prior to any new
                            terms taking effect. What constitutes a material change will be determined at our sole
                            discretion.

                            <br><br>

                            <b>Limitation of liability</b>

                            <br><br>

                            In no event shall Praxis, nor any of its employees, be liable to you for anything arising
                            out of or in any way connected with your use of this Website, whether such liability is
                            under contract, tort or otherwise, and Praxis, including its employees shall not be liable
                            for any indirect, consequential or special liability arising out of or in any way related to
                            your use of this Website.

                            <br><br>

                            <b>Indemnification</b>

                            <br><br>

                            You hereby indemnify to the fullest extent Praxis from and against any and all liabilities,
                            costs, demands, causes of action, damages and expenses (including reasonable attorney’s
                            fees) arising out of or in any way related to your breach of any of the provisions of these
                            Terms.

                            <br><br>

                            <b>Severability</b>

                            <br><br>

                            If any provision of these Terms is found to be unenforceable or invalid under any applicable
                            law, such unenforceability or invalidity shall not render these Terms unenforceable or
                            invalid as a whole, and such provisions shall be deleted without affecting the remaining
                            provisions herein.

                            <br><br>
                            By clicking “Submit” I agree that:
                            I have read the User Agreement
                            I am at least 18 years old


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