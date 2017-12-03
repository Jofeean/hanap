@extends('master2')

@section('title')
    User Accounts
@endsection

@section('indication')
    Users Accounts
@endsection

@section('user')
    active
@endsection

@section('body')


    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="header">
                            <h4 class="title">All User Accounts</h4>
                            <p class="category">Activated/Inactive accounts</p>
                        </div>
                        <div class="content table-responsive table-full-width">
                            <table class="table table-striped">
                                <thead>
                                <th>User ID</th>
                                <th>Profile Picture</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Contact No</th>
                                <th>Valid ID 1</th>
                                <th>Actions</th>
                                </thead>
                                <tbody>
                                @foreach($users as $user)
                                    <tr>
                                        <td>{{ $user->User_id }}</td>
                                        <td>
                                            <center>
                                                <a style="margin-top: 20px"
                                                   data-toggle="modal" data-target="#{{ $user->User_id }}"><img
                                                            src="{{ asset('images/dpthumb/'.$user->User_picture) }}"
                                                            style="max-height: 100px; max-width: 70%"
                                                            class="img-rounded">
                                                </a>
                                            </center>
                                        </td>
                                        <td>{{ $user->User_fname }} {{ $user->User_mname }} {{ $user->User_lname }}</td>
                                        <td>{{ $user->User_email }}</td>
                                        <td>{{ $user->User_mobilenum }}</td>
                                        <td><img src="{{ asset('images/vi1thumb/'.$user->User_valId1) }}"
                                                 style="max-height: 100px; max-width: 70%" class="img-rounded"></td>
                                        <td>
                                            <a class="btn btn-info" style="margin-top: 20px"
                                               data-toggle="modal" data-target="#{{ $user->User_id }}">View
                                            </a>
                                            @if($user->User_status == 0)
                                                <a class="btn btn-danger" style="margin-top: 20px"
                                                   href="/user/activate/{{ $user->User_id }}">Activate
                                                </a>
                                            @elseif($user->User_status == 1)
                                                <a class="btn btn-success" href="/user/activate/{{ $user->User_id }}"
                                                   style="margin-top: 20px">Active
                                                </a>
                                            @endif
                                            @if($user->User_status == 0)
                                                <a class="btn btn-warning" href="/user/deny/{{ $user->User_id }}"
                                                   style="margin-top: 20px">Deny
                                                </a>
                                            @elseif($user->User_status == 2)
                                                <a class="btn btn-danger" href="/user/deny/{{ $user->User_id }}"
                                                   style="margin-top: 20px">Denied
                                                </a>
                                            @endif
                                        </td>
                                    </tr>

                                    <!-- Modal -->
                                    <div class="modal fade bd-example-modal-lg" id="{{ $user->User_id }}"
                                         tabindex="-1" role="dialog"
                                         aria-labelledby="myLargeModalLabel"
                                         aria-hidden="true">
                                        <div class="modal-dialog modal-lg" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <div class="col-md-11">
                                                        <center>{{ $user->User_fname }} {{ $user->User_mname }} {{ $user->User_lname }}</center>
                                                    </div>
                                                    <div class="col-md-1">
                                                        <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <br>
                                                </div>
                                                <div class="modal-body" style="margin: 15px">
                                                    <div class="row">
                                                        <center>
                                                            <img src="{{ asset('images/dp/'.$user->User_picture) }}"
                                                                 style="max-height: 400px; max-width: 100%"
                                                                 class="img-rounded">
                                                        </center>
                                                    </div>
                                                    <div class="row">
                                                        <br>
                                                        <div class="col-md-6">
                                                            <h4>Profile:</h4>
                                                            <hr>
                                                            <b>Name:</b> {{ $user->User_fname }} {{ $user->User_mname }} {{ $user->User_lname }}
                                                            <br>
                                                            <b>Gender:</b> {{ $user->User_gender }}
                                                            <br>
                                                            <b>Birthday:</b> {{ $user->User_bday }}
                                                            <br>
                                                            <b>Address:</b> {{ $user->User_address }} {{ $user->User_city }}
                                                            <HR>
                                                            <b>Email:</b> {{ $user->User_email }}
                                                            <br>
                                                            <b>Mobile Number:</b> {{ $user->User_mobilenum }}
                                                        </div>
                                                        <div class="col-md-6">
                                                            <h4>Valid ID:</h4>
                                                            <hr>
                                                            <img src="{{ asset('images/vi1/'.$user->User_valId1) }}"
                                                                 style="max-height: 200px; max-width: 100%"
                                                                 class="img-rounded">
                                                            <br>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <div class="pull-left" style="margin-left: 5px">
                                                        @if($user->User_status == 0)
                                                            <a class="btn btn-danger btn-lg" style="margin-top: 20px"
                                                               href="/user/activate/{{ $user->User_id }}">Activate
                                                            </a>
                                                        @elseif($user->User_status == 1)
                                                            <a class="btn btn-success btn-lg"
                                                               href="/user/activate/{{ $user->User_id }}"
                                                               style="margin-top: 20px">Active
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
                message: "Account has been successfully  activated."

            }, {
                type: 'success',
                timer: 4000
            });

            @elseif ($errors->has('denied'))
            $.notify({
                icon: 'ti-close',
                message: "Account has already  activated."

            }, {
                type: 'danger',
                timer: 4000
            });
            @endif

            @if ($errors->has('success1'))
            $.notify({
                icon: 'ti-check',
                message: "Account has been denied."

            }, {
                type: 'success',
                timer: 4000
            });

            @elseif ($errors->has('denied1'))
            $.notify({
                icon: 'ti-close',
                message: "Account has already denied."

            }, {
                type: 'danger',
                timer: 4000
            });
            @endif
        });

    </script>
@endsection