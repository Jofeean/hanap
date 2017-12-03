@if(session('id') == null)
    <nav class="navbar navbar-toggleable-md fixed-top" style="background-color: #3c6385; ">
        <div class="container">
            <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse"
                    data-target="#navbar-warning" aria-controls="navbarNav" aria-expanded="false"
                    aria-label="Toggle navigation">
                <span class="navbar-toggler-bar"></span>
                <span class="navbar-toggler-bar"></span>
                <span class="navbar-toggler-bar"></span>
            </button>
            <a class="navbar-brand" href="/" style="color: white;">
                <img src="{!! asset('images/logopng.png') !!}" style="height: 50px">
            </a>
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="/" style="color: white;">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/missingperson/list" style="color: white;">Mising Person List</a>
                    </li>
                    {{--<li class="nav-item">--}}
                        {{--<a class="nav-link" href="#" style="color: white;">About</a>--}}
                    {{--</li>--}}
                </ul>
            </div>
        </div>
    </nav>

@elseif(session('priv') == 'user')
    <nav class="navbar navbar-toggleable-md fixed-top" style="background-color: #3c6385">
        <div class="container">
            <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse"
                    data-target="#navbar-warning" aria-controls="navbarNav" aria-expanded="false"
                    aria-label="Toggle navigation">
                <span class="navbar-toggler-bar"></span>
                <span class="navbar-toggler-bar"></span>
                <span class="navbar-toggler-bar"></span>
            </button>
            <a class="navbar-brand" href="/" style="color: white;">
                <img src="{!! asset('images/logopng.png') !!}" style="height: 50px">
            </a>
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <ul class="navbar-nav ml-auto">
                    {{--<li class="nav-item">--}}
                        {{--<a class="nav-link" href="#" style="color: white;">About</a>--}}
                    {{--</li>--}}
                    <li class="nav-item">
                        <a class="nav-link" href="/missingperson/list" style="color: white;">Mising Person List</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="http://example.com" id="navbarDropdownMenuLink"
                           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="color: white;">
                            {{ session('fname') }}
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            <li class="dropdown-header">{{ session('fname') }} {{ session('lname') }}</li>
                            <li class="dropdown-item"><a href="/missingperson/yourreports">Your Reports</a></li>
                            <li class="dropdown-item"><a href="/missingperson/filereport">File a Report</a></li>
                            <li class="dropdown-item"><a href="/missingperson/reportsighting">Report Suspected Missing
                                    Person</a></li>
                            <div class="dropdown-divider"></div>
                            <li class="dropdown-item"><a href="/logout">Logout</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
@endif

<br><br>