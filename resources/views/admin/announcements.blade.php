@extends('master2')

@section('title')
    Announcements and News
@endsection

@section('indication')
    Announcements and News
@endsection

@section('announcements')
    active
@endsection

@section('body')


    <div class="content">
        <div class="container-fluid">
            <div class="row">

                <div class="col-md-6">
                    <div class="card">
                        <div class="header">
                            <h4 class="title">Announcements</h4>
                            <div class="col-md-4">
                                <p class="category">All Announcements at Homepage</p>
                            </div>
                            <button class="btn btn-success pull-right" data-toggle="modal" data-target="#announcements">
                                <span class="ti-plus"></span> Add Announcement
                            </button>
                        </div>
                        <div class="content table-responsive table-full-width">
                            <table class="table table-striped">
                                <thead>
                                <th>Announcements</th>
                                <th>Date Added</th>
                                <th>Actions</th>
                                </thead>
                                <tbody>

                                @foreach($announcements as $announcement)
                                    <tr>
                                        <th>
                                            <center>
                                                <img src="{{ asset('images/announcements/'.$announcement->Announcement_picture) }}"
                                                     style="max-height: 200px; max-width: 70%"
                                                     class="img-rounded">
                                            </center>
                                        </th>
                                        <th>{{ $announcement->created_at }}</th>
                                        <th><a href="/announcements/delete/{{ $announcement->Announcement_id }}"
                                               class="btn btn-danger">Delete</a></th>
                                    </tr>
                                @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                {{--Announcements--}}
                <div class="modal fade bd-example-modal-lg" id="announcements"
                     tabindex="-1" role="dialog"
                     aria-labelledby="myLargeModalLabel"
                     aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                <div class="row" style="padding-right: 10px; ">
                                    <center>
                                        <h4>
                                            Add Announcement
                                        </h4>
                                    </center>
                                </div>
                            </div>
                            <div class="modal-body" style="margin: 15px">

                                <form action="/announcements/add/1" method="post" enctype="multipart/form-data">
                                    {{ csrf_field() }}
                                    <div class="row">
                                        <div class="col-md-10 col-md-offset-1">
                                            <center>
                                                <label style="font-weight: bold">Picture</label>
                                                <div id="anndis"
                                                     style="padding: 20px; background-color: white; border-radius: 10px">
                                                </div>
                                                <br>
                                                <input type="file" id="ann" name="ann" accept=".jpg, .jpeg"/>
                                            </center>
                                        </div>
                                    </div>

                                    <br>
                                    <div class="footer">
                                        <div class="left-side">
                                            <input type="submit" class="btn btn-info">
                                            <input type="reset" class="btn btn-warning" value="cancel">
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card">
                        <div class="header">
                            <h4 class="title">News</h4>
                            <div class="col-md-4">
                                <p class="category">All News at Homepage</p>
                            </div>
                            <button class="btn btn-success pull-right" data-toggle="modal" data-target="#newss">
                                <span class="ti-plus"></span> Add News
                            </button>
                        </div>
                        <div class="content table-responsive table-full-width">
                            <table class="table table-striped">
                                <thead>
                                <th>News</th>
                                <th>Date Added</th>
                                <th>Caption</th>
                                <th>Actions</th>
                                </thead>
                                <tbody>

                                @foreach($news as $new)
                                    <tr>
                                        <th>
                                            <center>
                                                <img src="{{ asset('images/articles/'.$new->News_picture) }}"
                                                     style="max-height: 200px; max-width: 70%"
                                                     class="img-rounded">
                                            </center>
                                        </th>
                                        <th>{{ $new->created_at }}</th>
                                        <th width="40%">{{ $new->News_caption }}</th>
                                        <th><a href="/news/delete/{{ $new->News_id }}" class="btn btn-danger">Delete</a>
                                        </th>
                                    </tr>
                                @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                {{--News--}}
                <div class="modal fade bd-example-modal-lg" id="newss"
                     tabindex="-1" role="dialog"
                     aria-labelledby="myLargeModalLabel"
                     aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                <div class="row" style="padding-right: 10px; ">
                                    <center>
                                        <h4>
                                            Add News
                                        </h4>
                                    </center>
                                </div>
                            </div>
                            <div class="modal-body" style="margin: 15px">

                                <form action="/announcements/add/2" method="post" enctype="multipart/form-data">
                                    {{ csrf_field() }}
                                    <div class="row">
                                        <div class="col-md-10 col-md-offset-1">
                                            <center>
                                                <label style="font-weight: bold">Picture</label>
                                                <div id="newsdis"
                                                     style="padding: 20px; background-color: white; border-radius: 10px">
                                                </div>
                                                <br>
                                                <input type="file" id="news" name="news" accept=".jpg, .jpeg"/>
                                            </center>
                                            <br>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="form-group col-md-8 col-md-offset-2">
                                            <textarea name="caption" class="form-control" placeholder="Caption (250 Characters Only)" rows="5"></textarea>
                                        </div>
                                    </div>

                                    <br>
                                    <div class="footer">
                                        <div class="left-side">
                                            <input type="submit" class="btn btn-info">
                                            <input type="reset" class="btn btn-warning" value="cancel">
                                        </div>
                                    </div>
                                </form>
                            </div>
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
            @if ($errors->has('announcements') && $errors->has('success'))
            $.notify({
                icon: 'ti-check',
                message: "Announcement Successfully Added."

            }, {
                type: 'success',
                timer: 4000
            });

            @elseif ($errors->has('announcements') && $errors->has('den'))
            $.notify({
                icon: 'ti-close',
                message: "Error on Adding Announcement"

            }, {
                type: 'danger',
                timer: 4000
            });
            @elseif ($errors->has('announcements') && $errors->has('del'))
            $.notify({
                icon: 'ti-check',
                message: "Announcement Successfully Deleted"

            }, {
                type: 'success',
                timer: 4000
            });
            @endif

            @if ($errors->has('news') && $errors->has('success'))
            $.notify({
                icon: 'ti-check',
                message: "News Successfully Added."

            }, {
                type: 'success',
                timer: 4000
            });

            @elseif ($errors->has('news') && $errors->has('den'))
            $.notify({
                icon: 'ti-close',
                message: "Error on Adding News"

            }, {
                type: 'danger',
                timer: 4000
            });
            @elseif ($errors->has('news') && $errors->has('del'))
            $.notify({
                icon: 'ti-check',
                message: "News Successfully Deleted"

            }, {
                type: 'success',
                timer: 4000
            });
            @endif
        });

        $("#ann").on('change', function () {
            //Get count of selected files
            var countFiles = $(this)[0].files.length;
            var imgPath = $(this)[0].value;
            var extn = imgPath.substring(imgPath.lastIndexOf('.') + 1).toLowerCase();
            var image_holder = $("#anndis");
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

        $("#news").on('change', function () {
            //Get count of selected files
            var countFiles = $(this)[0].files.length;
            var imgPath = $(this)[0].value;
            var extn = imgPath.substring(imgPath.lastIndexOf('.') + 1).toLowerCase();
            var image_holder = $("#newsdis");
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

    </script>
@endsection