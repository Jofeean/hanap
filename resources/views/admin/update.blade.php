@extends('master2')

@section('title')
    Update API Key
@endsection

@section('indication')
    Update API Key
@endsection

@section('update')
    active
@endsection

@section('body')


    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-4 col-md-offset-4">
                    <div class="card">
                        <form action="/apikey/update" method="post">
                            {{ csrf_field()  }}
                            <div style="padding: 10px">
                                <label style="font-weight: bold">Enter API Key</label>
                                <div class="form-group">
                                    <input type="text" class="form-control" name="apikey" placeholder="API Key">
                                    @if($errors->has('apikey'))
                                        <div style="color: red">Sorry, the API key you typed is incorrect.
                                        </div>
                                    @endif
                                </div>
                                <br>
                                <input type="submit" class="btn btn-info">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection