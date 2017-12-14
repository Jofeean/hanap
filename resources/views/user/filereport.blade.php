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

            @if($errors->has('reported'))
                <div class="alert alert-danger alert-with-icon" data-notify="container">
                    <div class="container">
                        <div class="alert-wrapper">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <i class="nc-icon nc-simple-remove"></i>
                            </button>
                            <div class="message"><i class="nc-icon nc-bell-55"></i>
                                &nbsp;The person was already reported.
                            </div>
                        </div>
                    </div>
                </div>
                <br>
            @endif


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
                        <label style="font-weight: bold">Nickname/Alias</label>
                        <div class="form-group @if($errors->has('nname')) has-danger @endif">
                            <input type="text" class="form-control" name="nname" value="{{ old('nname') }}"
                                   placeholder="Ex: Nene"
                                   @if($errors->has('nname')) id="inputDanger1" @endif>
                            @if($errors->has('nname'))
                                <div class="form-control-feedback">Sorry, the nickname you typed is incorrect</div>
                            @endif
                        </div>
                    </div>

                    <div class="col-md-4">
                        <label style="font-weight: bold">Gender</label>
                        <div class="form-group @if($errors->has('gender')) has-danger @endif">
                            <select class="form-control" name="gender"
                                    @if($errors->has('gender')) id="inputDanger1" @endif>
                                @if($errors->any())<option value="{{ old('gender') }}">{{ old('gender') }}</option>@endif
                                <option value="">-- Select --</option>
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
                        <div class="form-group @if($errors->has('birthday') || $errors->has('bdayy')) has-danger @endif">
                            <div class='input-group date' id='datetimepicker'>
                                <input type='text' class="form-control datetimepicker" name="birthday"
                                       value="{{ old('birthday') }}"
                                       placeholder="Birthday" @if($errors->has('birthday') || $errors->has('bdayy')) id="inputDanger1" @endif>
                                <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"><i class="fa fa-calendar" aria-hidden="true"></i></span>
                                </span>
                            </div>
                            @if($errors->has('birthday') || $errors->has('bdayy'))
                                <div class="form-control-feedback">Sorry, the date of birth typed is incorrect</div>
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
                        <label style="font-weight: bold">Hair Color</label>
                        <div class="form-group @if($errors->has('hcolor')) has-danger @endif">
                            <select class="form-control" name="hcolor"
                                    @if($errors->has('hcolor')) id="inputDanger1" @endif>
                                @if($errors->any())<option value="{{ old('hcolor') }}">{{ old('hcolor') }}</option>@endif
                                <option value="">-- Select --</option>
                                <option value="Brown">Brown</option>
                                <option value="Black">Black</option>
                                <option value="White">White</option>
                                <option value="Gray">Gray</option>
                                <option value="Blonde">Blonde</option>
                                <option value="Red">Red</option>
                                <option value="Blue">Blue</option>
                                <option value="Green">Green</option>
                                <option value="Orange">Orange</option>
                                <option value="Pink">Pink</option>
                                <option value="Bald">Bald</option>
                                <option value="Unsure">Unsure</option>
                            </select>
                            @if($errors->has('hcolor'))
                                <div class="form-control-feedback">Sorry, the Hair color you selected is incorrect</div>
                            @endif
                        </div>
                    </div>

                    <div class="col-md-4">
                        <label style="font-weight: bold">Height</label>
                        <div class="form-group @if($errors->has('height')) has-danger @endif">
                            <input type="number" class="form-control" name="height" value="{{ old('height') }}"
                                   placeholder="CM"
                                   @if($errors->has('height')) id="inputDanger1" @endif>
                            @if($errors->has('height'))
                                <div class="form-control-feedback">Sorry, the height you typed is incorrect</div>
                            @endif
                        </div>
                    </div>

                    <div class="col-md-4">
                        <label style="font-weight: bold">Eye Color</label>
                        <div class="form-group @if($errors->has('eye')) has-danger @endif">
                            <select class="form-control" name="eye"
                                    @if($errors->has('eye')) id="inputDanger1" @endif>
                                @if($errors->any())<option value="{{ old('eye') }}">{{ old('eye') }}</option>@endif
                                <option value="">-- Select --</option>
                                <option value="Black">Black</option>
                                <option value="Blue">Blue</option>
                                <option value="Brown">Brown</option>
                                <option value="Gray">Gray</option>
                                <option value="Green">Green</option>
                                <option value="Unsure">Unsure</option>
                            </select>
                            @if($errors->has('eye'))
                                <div class="form-control-feedback">Sorry, the eye color you selected is incorrect</div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <label style="font-weight: bold">Hair</label>
                        <div class="form-group @if($errors->has('hair')) has-danger @endif">
                            <select class="form-control" name="hair"
                                    @if($errors->has('hair')) id="inputDanger1" @endif>
                                @if($errors->any())<option value="{{ old('hair') }}">{{ old('hair') }}</option>@endif
                                <option value="">-- Select --</option>
                                <option value="Straight">Straight</option>
                                <option value="Curly">Curly</option>
                                <option value="Short">Short</option>
                                <option value="Long">Long</option>
                                <option value="Frizzy">Frizzy</option>
                            </select>
                            @if($errors->has('hair'))
                                <div class="form-control-feedback">Sorry, the hair you selected is incorrect</div>
                            @endif
                        </div>
                    </div>

                    <div class="col-md-4">
                        <label style="font-weight: bold">Weight</label>
                        <div class="form-group @if($errors->has('weight')) has-danger @endif">
                            <input type="number" class="form-control" name="weight" value="{{ old('weight') }}"
                                   placeholder="KG"
                                   @if($errors->has('weight')) id="inputDanger1" @endif>
                            @if($errors->has('weight'))
                                <div class="form-control-feedback">Sorry, the weight you typed is incorrect</div>
                            @endif
                        </div>
                    </div>

                    <div class="col-md-4">
                        <label style="font-weight: bold">Body Type</label>
                        <div class="form-group @if($errors->has('btype')) has-danger @endif">
                            <select class="form-control" name="btype"
                                    @if($errors->has('btype')) id="inputDanger1" @endif>
                                @if($errors->any())<option value="{{ old('btype') }}">{{ old('btype') }}</option>@endif
                                <option value="">-- Select --</option>
                                <option value="Slim">Slim</option>
                                <option value="Athletic">Athletic</option>
                                <option value="Muscular">Muscular</option>
                                <option value="Round">Round</option>
                                <option value="Big-boned">Big-boned</option>
                            </select>
                            @if($errors->has('btype'))
                                <div class="form-control-feedback">Sorry, the body type you selected is incorrect</div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <label style="font-weight: bold">Body Hair</label>
                        <div class="form-group @if($errors->has('bhair')) has-danger @endif">
                            <input type="text" class="form-control" name="bhair" value="{{ old('bhair') }}"
                                   placeholder="Ex:  Arms, Legs, Chest, etc."
                                   @if($errors->has('bhair')) id="inputDanger1" @endif>
                            @if($errors->has('bhair'))
                                <div class="form-control-feedback">Sorry, the body hair you typed is incorrect</div>
                            @endif
                        </div>
                    </div>

                    <div class="col-md-4">
                        <label style="font-weight: bold">Facial Hair</label>
                        <div class="form-group @if($errors->has('fhair')) has-danger @endif">
                            <input type="text" class="form-control" name="fhair" value="{{ old('fhair') }}"
                                   placeholder="Ex:  Arms, Legs, Chest, etc."
                                   @if($errors->has('fhair')) id="inputDanger1" @endif>
                            @if($errors->has('fhair'))
                                <div class="form-control-feedback">Sorry, the facial hair you typed is incorrect</div>
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
                        <div class="form-group @if($errors->has('dodis') || $errors->has('dodiss') || $errors->has('dodisss')) has-danger @endif">
                            <div class='input-group date' id='dodis'>
                                <input type='text' class="form-control datetimepicker" name="dodis"
                                       value="{{ old('dodis') }}"
                                       placeholder="Date of Disappearance"
                                       @if($errors->has('dodis')  || $errors->has('dodiss') || $errors->has('dodisss')) id="inputDanger1" @endif>
                                <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"><i class="fa fa-calendar" aria-hidden="true"></i></span>
                        </span>
                            </div>
                            @if($errors->has('dodis')  || $errors->has('dodiss') || $errors->has('dodisss') )
                                <div class="form-control-feedback">Sorry, the date of disappearance you typed is
                                    incorrect
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="col-md-4">
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

                    <div class="col-md-4">
                        <label style="font-weight: bold">City</label>
                        <div class="form-group @if($errors->has('city1')) has-danger @endif">
                            <select class="form-control" name="city1"
                                    @if($errors->has('city1')) id="inputDanger1" @endif>
                                @if($errors->any())<option value="{{ old('city') }}">{{ old('city') }}</option>@endif
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
                            @if($errors->has('city1'))
                                <div class="form-control-feedback">Sorry, the city you selected is incorrect</div>
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
                        <label style="font-weight: bold">Distinctive Physical Feature</label>
                        <div class="form-group @if($errors->has('bmark')) has-danger @endif">
                        <textarea type="text" class="form-control" name="bmark" rows="12" style="resize: none"
                                  @if($errors->has('bmark')) id="inputDanger1" @endif
                                  placeholder="Ex: Amputated left arm, Tattoo in right arm, Nose piercing, Notched lips, Unknown, etc.">{{ old('bmark') }}</textarea>
                            @if($errors->has('bmark'))
                                <div class="form-control-feedback">Sorry, the body markings you typed is incorrect</div>
                            @endif
                        </div>
                    </div>

                    <div class="col-md-4">
                        <label style="font-weight: bold">Clothes/Accessories</label>
                        <div class="form-group @if($errors->has('clothes')) has-danger @endif">
                        <textarea type="text" class="form-control" name="clothes" rows="12" style="resize: none"
                                  @if($errors->has('clothes')) id="inputDanger1" @endif
                                  placeholder="Ex: White shirt, black pants, yellow slippers, sunglasses, cross necklace/pendant, Unknown, etc">{{ old('clothes') }}</textarea>
                            @if($errors->has('clothes'))
                                <div class="form-control-feedback">Sorry, the clothes you typed is incorrect</div>
                            @endif
                        </div>
                    </div>

                    <div class="col-md-4">
                        <label style="font-weight: bold">Medical</label>
                        <div class="form-group @if($errors->has('other')) has-danger @endif">
                        <textarea type="text" class="form-control" name="other" rows="12" style="resize: none"
                                  @if($errors->has('other')) id="inputDanger1" @endif
                                  placeholder="Ex: Known illnesses, Allergies, Mental disorders, Unknown, etc.">{{ old('other') }}</textarea>
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
        $('#resultsmodal').modal('show');

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