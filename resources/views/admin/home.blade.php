@extends('master2')

@section('title')
    Home
@endsection

@section('indication')
    Dashboard
@endsection

@section('dash')
    active
@endsection


@section('body')

    <div class="content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-lg-3 col-sm-6">
                    <div class="card">
                        <div class="content">
                            <div class="row">
                                <div class="col-xs-5">
                                    <div class="icon-big icon-warning text-center">
                                        <i class="ti-alert"></i>
                                    </div>
                                </div>
                                <div class="col-xs-7">
                                    <div class="numbers">
                                        <p>Reports</p>
                                        {{ $report }}
                                    </div>
                                </div>
                            </div>
                            <div class="footer">
                                <hr/>
                                <div class="stats">
                                    <a href="/missingperson/lists"><i class="ti-help-alt"></i> See at missing person
                                        list</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <div class="card">
                        <div class="content">
                            <div class="row">
                                <div class="col-xs-5">
                                    <div class="icon-big icon-success text-center">
                                        <i class="ti-eye"></i>
                                    </div>
                                </div>
                                <div class="col-xs-7">
                                    <div class="numbers">
                                        <p>Founds</p>
                                        {{ $found }}
                                    </div>
                                </div>
                            </div>
                            <div class="footer">
                                <hr/>
                                <div class="stats">
                                    <a href="/missingperson/lists"><i class="ti-help-alt"></i> See at missing person
                                        list</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <div class="card">
                        <div class="content">
                            <div class="row">
                                <div class="col-xs-5">
                                    <div class="icon-big icon-danger text-center">
                                        <i class="ti-user"></i>
                                    </div>
                                </div>
                                <div class="col-xs-7">
                                    <div class="numbers">
                                        <p>Unverified Accounts</p>
                                        {{ $unverified   }}
                                    </div>
                                </div>
                            </div>
                            <div class="footer">
                                <hr/>
                                <div class="stats">
                                    <a href="/user/lists"><i class="ti-help-alt"></i> See at user list</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <div class="card">
                        <div class="content">
                            <div class="row">
                                <div class="col-xs-5">
                                    <div class="icon-big icon-info text-center">
                                        <i class="ti-shield"></i>
                                    </div>
                                </div>
                                <div class="col-xs-7">
                                    <div class="numbers">
                                        <p>Police</p>
                                        {{ $police }}
                                    </div>
                                </div>
                            </div>
                            <div class="footer">
                                <hr/>
                                <div class="stats">
                                    <a href="/police/lists"><i class="ti-help-alt"></i> See at police list</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">

                <div class="col-md-12">
                    <div class="card ">
                        <div class="header">
                            <h4 class="title">Months where persons got lost and found</h4>
                            <p class="category">Overall statistics</p>
                        </div>
                        <div class="content">
                            <div id="chartActivity" class="ct-chart"></div>

                            <div class="footer">
                                <div class="chart-legend">
                                    <i class="fa fa-circle text-info"></i> Reports
                                    <i class="fa fa-circle text-warning"></i> Found
                                </div>
                                <hr>
                                <div class="stats">
                                    <i class="ti-check-box"></i> Data information certified
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="row">

                <div class="col-md-6">
                    <div class="card">
                        <div class="header">
                            <h4 class="title">Age statistics of all the persons went missing</h4>
                            <p class="category">Over all statistics</p>
                        </div>
                        <div class="content">
                            <br>
                            <div class="row">
                                <div class="col-xs-4">
                                    <div class="chart-legend">
                                        <i class="fa fa-circle" style="color: #ee7d60;"></i> < 10 = {{ $age1 }}<br>
                                        <i class="fa fa-circle text-primary"></i> 11 - 20 = {{ $age2 }}<br>
                                        <i class="fa fa-circle text-info"></i> 21 - 30 = {{ $age3 }}<br>
                                        <i class="fa fa-circle text-success"></i> 31 - 40 = {{ $age4 }}<br>
                                        <i class="fa fa-circle text-warning"></i> 41 - 50 = {{ $age5 }}<br>
                                        <i class="fa fa-circle text-danger"></i> 51 > = {{ $age6 }}
                                    </div>
                                </div>
                                <div class="col-xs-8">
                                    <div id="chartPreferences" class="ct-chart"></div>
                                </div>
                            </div>
                            <div style="padding: 5px">
                                <hr>
                                <div class="stats">
                                    <i class="ti-check-box"></i> All the data are came from the reports
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card">
                        <div class="header">
                            <h4 class="title">Gender statistics of all the persons went missing</h4>
                            <p class="category">Over all statistics</p>
                        </div>
                        <div class="content">
                            <br>
                            <div class="row">
                                <div class="col-xs-4">
                                    <div class="chart-legend">
                                        <i class="fa fa-circle text-info"></i> Male = {{ $male }}<br>
                                        <i class="fa fa-circle text-success"></i> Female = {{ $female }}
                                    </div>
                                </div>
                                <div class="col-xs-8">
                                    <div id="gender" class="ct-chart"></div>
                                </div>
                            </div>
                            <div style="padding: 5px">
                                <hr>
                                <div class="stats">
                                    <i class="ti-check-box"></i> All the data are came from the reports
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="header">
                            <h4 class="title">Age statistics of all the missing person found</h4>
                            <p class="category">Over all statistics</p>
                        </div>
                        <div class="content">
                            <br>
                            <div class="row">
                                <div class="col-xs-4">
                                    <div class="chart-legend">
                                        <i class="fa fa-circle" style="color: #ee7d60;"></i> < 10 = {{ $fage1 }}<br>
                                        <i class="fa fa-circle text-primary"></i> 11 - 20 = {{ $fage2 }}<br>
                                        <i class="fa fa-circle text-info"></i> 21 - 30 = {{ $fage3 }}<br>
                                        <i class="fa fa-circle text-success"></i> 31 - 40 = {{ $fage4 }}<br>
                                        <i class="fa fa-circle text-warning"></i> 41 - 50 = {{ $fage5 }}<br>
                                        <i class="fa fa-circle text-danger"></i> 51 > = {{ $fage6 }}
                                    </div>
                                </div>
                                <div class="col-xs-8">
                                    <div id="foundage" class="ct-chart"></div>
                                </div>
                            </div>
                            <div style="padding: 5px">
                                <hr>
                                <div class="stats">
                                    <i class="ti-check-box"></i> All the data are came from the reports
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card">
                        <div class="header">
                            <h4 class="title">Gender statistics of all the missing person found</h4>
                            <p class="category">Over all statistics</p>
                        </div>
                        <div class="content">
                            <br>
                            <div class="row">
                                <div class="col-xs-4">
                                    <div class="chart-legend">
                                        <i class="fa fa-circle text-info"></i> Male = {{ $fmale }}<br>
                                        <i class="fa fa-circle text-success"></i> Female = {{ $ffemale }}
                                    </div>
                                </div>
                                <div class="col-xs-8">
                                    <div id="foundgender" class="ct-chart"></div>
                                </div>
                            </div>
                            <div style="padding: 5px">
                                <hr>
                                <div class="stats">
                                    <i class="ti-check-box"></i> All the data are came from the reports
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

@endsection

@section('scripts')
    {{--<script src="{{ asset('paperdash/js/demo.js') }}"></script>--}}


    <script type="text/javascript">
        demo = {
            initChartist: function () {


                var data = {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mai', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                    series: [
                        [{{ $jan }}, {{ $feb }}, {{ $mar }}, {{ $apr }}, {{ $may}}, {{ $jun }}, {{ $jul }}, {{ $aug}}, {{ $sep }}, {{ $oct }}, {{ $nov }}, {{ $dec}}],
                        [{{ $fjan }}, {{ $ffeb }}, {{ $fmar }}, {{ $fapr }}, {{ $fmay}}, {{ $fjun }}, {{ $fjul }}, {{ $faug}}, {{ $fsep }}, {{ $foct }}, {{ $fnov }}, {{ $fdec}}]
                    ]
                };

                var options = {
                    seriesBarDistance: 10,
                    axisX: {
                        showGrid: false
                    },
                    height: "245px"
                };

                Chartist.Line('#chartActivity', data, options);

                //missing
                <?php
                $total = $age1 + $age2 + $age3 + $age4 + $age5 + $age6;
                $lab1 = round(($age1 / $total) * 100, 2);
                $lab2 = round(($age2 / $total) * 100, 2);
                $lab3 = round(($age3 / $total) * 100, 2);
                $lab4 = round(($age4 / $total) * 100, 2);
                $lab5 = round(($age5 / $total) * 100, 2);
                $lab6 = round(($age6 / $total) * 100, 2);
                $series = array();
                $labels = array();

                if ($age1 != 0) {
                    array_push($series, [
                        'serie' => $age1,
                        'color' => 'color1'
                    ]);
                    array_push($labels, $lab1);
                }
                if ($age2 != 0) {
                    array_push($series, [
                        'serie' => $age2,
                        'color' => 'color2'
                    ]);
                    array_push($labels, $lab2);
                }
                if ($age3 != 0) {
                    array_push($series, [
                        'serie' => $age3,
                        'color' => 'color3'
                    ]);
                    array_push($labels, $lab3);
                }
                if ($age4 != 0) {
                    array_push($series, [
                        'serie' => $age4,
                        'color' => 'color4'
                    ]);
                    array_push($labels, $lab4);
                }
                if ($age5 != 0) {
                    array_push($series, [
                        'serie' => $age5,
                        'color' => 'color5'
                    ]);
                    array_push($labels, $lab5);
                }
                if ($age6 != 0) {
                    array_push($series, [
                        'serie' => $age6,
                        'color' => 'color6'
                    ]);
                    array_push($labels, $lab6);
                }

                ?>

                new Chartist.Pie('#chartPreferences', {
                    series: [
                            @foreach($series as $ser)
                        {
                            value: '{{ $ser['serie'] }}',
                            className: '{{ $ser['color'] }}'
                        },
                        @endforeach
                    ],
                    labels: [
                        @foreach($labels as $label)
                            '{{ $label }} %',
                        @endforeach
                    ]
                }, {labelDirection: 'explode'});

                <?php
                $total = $female + $male;
                $lab1 = round(($female / $total) * 100, 2);
                $lab2 = round(($male / $total) * 100, 2);
                $series = array();
                $labels = array();

                if ($female != 0) {
                    array_push($series, [
                        'serie' => $female,
                        'color' => 'color4'
                    ]);
                    array_push($labels, $lab1);
                }
                if ($male != 0) {
                    array_push($series, [
                        'serie' => $male,
                        'color' => 'color3'
                    ]);
                    array_push($labels, $lab2);
                }


                ?>

                new Chartist.Pie('#gender', {
                    series: [
                            @foreach($series as $ser)
                        {
                            value: '{{ $ser['serie'] }}',
                            className: '{{ $ser['color'] }}'
                        },
                        @endforeach
                    ],
                    labels: [
                        @foreach($labels as $label)
                            '{{ $label }} %',
                        @endforeach
                    ]
                }, {labelDirection: 'explode'});

                //found
                <?php
                $total = $fage1 + $fage2 + $fage3 + $fage4 + $fage5 + $fage6;
                $lab1 = round(($fage1 / $total) * 100, 2);
                $lab2 = round(($fage2 / $total) * 100, 2);
                $lab3 = round(($fage3 / $total) * 100, 2);
                $lab4 = round(($fage4 / $total) * 100, 2);
                $lab5 = round(($fage5 / $total) * 100, 2);
                $lab6 = round(($fage6 / $total) * 100, 2);
                $series = array();
                $labels = array();

                if ($fage1 != 0) {
                    array_push($series, [
                        'serie' => $fage1,
                        'color' => 'color1'
                    ]);
                    array_push($labels, $lab1);
                }
                if ($fage2 != 0) {
                    array_push($series, [
                        'serie' => $fage2,
                        'color' => 'color2'
                    ]);
                    array_push($labels, $lab2);
                }
                if ($fage3 != 0) {
                    array_push($series, [
                        'serie' => $fage3,
                        'color' => 'color3'
                    ]);
                    array_push($labels, $lab3);
                }
                if ($fage4 != 0) {
                    array_push($series, [
                        'serie' => $fage4,
                        'color' => 'color4'
                    ]);
                    array_push($labels, $lab4);
                }
                if ($fage5 != 0) {
                    array_push($series, [
                        'serie' => $fage5,
                        'color' => 'color5'
                    ]);
                    array_push($labels, $lab5);
                }
                if ($fage6 != 0) {
                    array_push($series, [
                        'serie' => $fage6,
                        'color' => 'color6'
                    ]);
                    array_push($labels, $lab6);
                }

                ?>

                new Chartist.Pie('#foundage', {
                    series: [
                            @foreach($series as $ser)
                        {
                            value: '{{ $ser['serie'] }}',
                            className: '{{ $ser['color'] }}'
                        },
                        @endforeach
                    ],
                    labels: [
                        @foreach($labels as $label)
                            '{{ $label }} %',
                        @endforeach
                    ]
                }, {labelDirection: 'explode'});

                <?php
                $total = $ffemale + $fmale;
                $lab1 = round(($ffemale / $total) * 100, 2);
                $lab2 = round(($fmale / $total) * 100, 2);
                $series = array();
                $labels = array();

                if ($ffemale != 0) {
                    array_push($series, [
                        'serie' => $ffemale,
                        'color' => 'color4'
                    ]);
                    array_push($labels, $lab1);
                }
                if ($fmale != 0) {
                    array_push($series, [
                        'serie' => $fmale,
                        'color' => 'color3'
                    ]);
                    array_push($labels, $lab2);
                }


                ?>

                new Chartist.Pie('#foundgender', {
                    series: [
                            @foreach($series as $ser)
                        {
                            value: '{{ $ser['serie'] }}',
                            className: '{{ $ser['color'] }}'
                        },
                        @endforeach
                    ],
                    labels: [
                        @foreach($labels as $label)
                            '{{ $label }} %',
                        @endforeach
                    ]
                }, {labelDirection: 'explode'});
            }
        }

        $(document).ready(function () {

            demo.initChartist();

        });
    </script>

@endsection