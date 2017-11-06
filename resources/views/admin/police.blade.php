@extends('master2')

@section('title')
    Police Accounts
@endsection

@section('indication')
    Police Accounts
@endsection

@section('police')
    active
@endsection

@section('body')


    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="header">
                            <h4 class="title">All Police Accounts</h4>
                            <p class="category"></p>
                        </div>
                        <div class="content table-responsive table-full-width">
                            <table class="table table-striped">
                                <thead>
                                <th>User ID</th>
                                <th>Profile Picture</th>
                                <th>Name</th>
                                <th>Gender</th>
                                <th>Email</th>
                                <th>Contact No</th>
                                <th>Birthday</th>
                                <th>Address</th>
                                </thead>
                                <tbody>
                                @foreach($users as $user)
                                    <tr>
                                        <td>{{ $user->Police_id }}</td>
                                        <td>
                                            <a style="margin-top: 20px"
                                               data-toggle="modal" data-target="#{{ $user->Police_id }}"><img
                                                        src="{{ asset('images/dpthumb/'.$user->Police_picture) }}"
                                                        style="max-height: 100px; max-width: 70%" class="img-rounded">
                                            </a>
                                        </td>
                                        <td>{{ $user->Police_Name }} {{ $user->Police_lname }}</td>
                                        <td>{{ $user->Police_gender }}</td>
                                        <td>{{ $user->Police_email }}</td>
                                        <td>{{ $user->Police_mobilenum }}</td>
                                        <td>{{ $user->Police_bday }}</td>
                                        <td>{{ $user->Police_address }}</td>
                                    </tr>
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