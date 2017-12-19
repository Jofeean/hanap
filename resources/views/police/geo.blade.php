@extends('master3')

@section('title')
    Geo-Map
@endsection

@section('indication')
    Geo-Map
@endsection

@section('geomap')
    active
@endsection

@section('styles')
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        google.charts.load('current', {
            'packages': ['geochart'],
            // Note: you will need to get a mapsApiKey for your project.
            // See: https://developers.google.com/chart/interactive/docs/basic_load_libs#load-settings
            'mapsApiKey': 'AIzaSyD-9tSrke72PouQMnMX-a7eZSW0jkFMBWY'
        });
        google.charts.setOnLoadCallback(drawRegionsMap);

        function drawRegionsMap() {
            var data = google.visualization.arrayToDataTable([
                ['City', 'Missing'],
                ['Caloocan', {{ $cal }}],
                ['Las Piñas', {{ $las }}],
                ['Makati', {{ $mak }}],
                ['Malabon', {{ $mal }}],
                ['Mandaluyong', {{ $mand }}],
                ['Manila', {{ $man }}],
                ['Marikina', {{ $mar }}],
                ['Muntinlupa', {{ $mun }}],
                ['Navotas', {{ $nav }}],
                ['Parañaque', {{ $par }}],
                ['Pasay', {{ $pas }}],
                ['Pasig', {{ $pasi }}],
                ['Quezon', {{ $que }}],
                ['San Juan', {{ $san }}],
                ['Taguig', {{ $tag }}],
                ['Valenzuela', {{ $val }}],
            ]);

            var options = {
                region: 'PH',
                displayMode: 'markers',
                resolution: 'provinces',
                colorAxis: {colors: ['#E67E22', '#2980B9']},
                backgroundColor: '#16A085',
                datalessRegionColor: '#ECF0F1',
                magnifyingGlass: {enable: true, zoomFactor: 9.5},
                selectionMode: 'multiple',
                aggregationTarget: 'category',
            };

            var chart = new google.visualization.GeoChart(document.getElementById('regions_div'));

            chart.draw(data, options);
        }
    </script>
@endsection

@section('body')


    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div style="background-color: white; border-radius: 10px">
                    <div class="row" style="padding: 20px">
                        <div class="page-carousel col-md-12">
                            <div id="carouselExampleIndicators-1" class="carousel slide"
                                 data-ride="carousel">
                                <div class="carousel-inner" style="height: 370px;">
                                    <?php $i = $t = 0; $gals = array(); ?>
                                    @foreach($galleries as $gallery)
                                        <?php

                                        if ($loop->first) {
                                            $t = 1;
                                        } elseif ($i != 7) {
                                            array_push($gals, $gallery);
                                        }
                                        ?>

                                        @if($i == 6)
                                            <div class="item @if($t == 1) active @endif">
                                                <div style="margin: auto">
                                                    <table style="height: 370px;">

                                                        <td valign="middle" align="center">
                                                            <div class="row" style="height: 250px">
                                                                @foreach($gals as $gal)
                                                                    <div class="col-md-2">
                                                                        <img class="d-block img-fluid"
                                                                             src="{!! asset('images/missingthumb/'. $gal->Missing_picture) !!}"
                                                                             alt="First slide"
                                                                             style="max-width: 100%; max-height: 250px; width: auto;"><br>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                            <div class="row">
                                                                @foreach($gals as $gal)
                                                                    <div class="col-md-2">
                                                                        Name: {{ $gal->Missing_fname }} {{ $gal->Missing_lname }}
                                                                        <br>
                                                                        Missing
                                                                        since: {{ $gal->Missing_dodis }}
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </td>
                                                        <?php $t = 0 ?>
                                                    </table>
                                                    <div class="carousel-caption d-none d-md-block">
                                                    </div>
                                                </div>
                                            </div>
                                            <?php $gals = array(); $i = 0?>

                                        @elseif($loop->last)

                                            <div class="carousel-item @if($t == 1) active @endif">
                                                <div style="margin: auto">
                                                    <table style="height: 370px;">

                                                        <td valign="middle" align="center">
                                                            <div class="row" style="height: 250px">
                                                                @foreach($gals as $gal)
                                                                    <div class="col-md-2">
                                                                        <img class="d-block img-fluid"
                                                                             src="{!! asset('images/missingthumb/'. $gal->Missing_picture) !!}"
                                                                             alt="First slide"
                                                                             style="max-width: 100%; max-height: 250px; width: auto;"><br>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                            <div class="row">
                                                                @foreach($gals as $gal)
                                                                    <div class="col-md-2">
                                                                        Name: {{ $gal->Missing_fname }} {{ $gal->Missing_lname }}
                                                                        <br>
                                                                        Missing
                                                                        since: {{ $gal->Missing_dodis }}
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </td>
                                                        <?php $t = 0 ?>
                                                    </table>
                                                    <div class="carousel-caption d-none d-md-block">
                                                    </div>
                                                </div>
                                            </div>
                                            <?php $gals = array()?>
                                        @endif

                                        <?php $i++; ?>
                                    @endforeach
                                </div>
                                <a class="left carousel-control"
                                   href="#carouselExampleIndicators-1" data-slide="prev">
                                    <span class="sr-only">Previous</span>
                                </a>
                                <a class="right carousel-control"
                                   href="#carouselExampleIndicators-1" data-slide="next">
                                    <span class="sr-only">Next</span>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="row" style="padding: 20px">

                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-3">
                <div class="card">
                    <div class="header">
                        <h4 class="title">Geo-Mapping</h4>
                        <p class="category">Numbers of missing persons in the area</p>
                        <br>
                    </div>
                </div>
            </div>
        </div>

        {{-- notif --}}
        <div class="container">
            <div class="row">
                <form action="/geomap/notif" method="post">
                    {{ csrf_field() }}
                    <div class="col-md-8">
                        <div class="form-group">
                            <select class="form-control" name="city">
                                <option value="">-- Cities --</option>

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
                        </div>
                    </div>
                    <div class="col-md-4">
                        <input type="submit" class="btn btn-default pull-right" value="Send Notification">
                    </div>
                </form>
            </div>
            <div class="row">
                <div id="regions_div" style="width: 100%; height: 700px;"></div>
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
                message: "Notification was sent to all users from {{  $errors->first('success') }}"

            }, {
                type: 'success',
                timer: 4000
            });
            @endif

            @if ($errors->has('error'))
            $.notify({
                icon: 'ti-close',
                message: "Please wait {{ $errors->first('error') }} hours before you can send to this particular location."

            }, {
                type: 'danger',
                timer: 4000
            });
            @endif

            @if ($errors->has('city'))
            $.notify({
                icon: 'ti-close',
                message: "Please select a city"

            }, {
                type: 'danger',
                timer: 4000
            });
            @endif
        });

    </script>
@endsection