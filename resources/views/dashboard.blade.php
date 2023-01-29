@extends('layouts.master')
@section('content')

<div class="row">
    <div class="col-12 col-md-12">
        <div class="panel panel-headline">
            <div class="panel-loader loader-today-visitor">
                <div class="loader4"></div>
            </div>
            <div class="panel-heading">
                <h3 class="panel-title">Today's Visitor</h3>
                <p class="panel-subtitle" id="today-visitor-date"></p>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <canvas id="today-visitor-chart" style="max-height: 350px;"></canvas>
                    </div>
                </div>
                <br><br>
                <div class="row">
                    <div class="col-md-4 col-md-offset-2">
                        <div class="metric">
                            <span class="icon"><i class="fas fa-users"></i></span>
                            <p>
                                <span class="number" id="today-visits">0</span>
                                <span class="title">Today Visits</span>
                            </p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="metric">
                            <span class="icon"><i class="fas fa-analytics"></i></span>
                            <p>
                                <span class="number" id="average-daily-visits">0</span>
                                <span class="title">Average Daily Visits</span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <br>
        </div>
    </div>

    <div class="col-12 col-md-12">
        <div class="panel panel-headline">
            <div class="panel-loader loader-yearly-visitor">
                <div class="loader4"></div>
            </div>
            <div class="panel-heading">
                <p class="panel-subtitle" style="display: flex; gap: 10px; align-items:center;">
                    <select class="form-control" id="select-year" style="width: 100px">
                        
                    </select>
                    Visitors
                </p>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <canvas id="years-visitor-chart" style="max-height: 400px;"></canvas>
                    </div>
                </div>
            </div>
            <br>
        </div>
    </div>

    <div class="col-12 col-md-6">
        <div class="panel panel-headline">
            <div class="panel-loader loader-yearly-visitor">
                <div class="loader4"></div>
            </div>
            <div class="panel-heading">
                <h3 class="panel-title" id="country-visiting"></h3>
            </div>
            <div class="panel-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Country Name</th>
                            <th>Number of Visits</th>
                        </tr>
                    </thead>
                    <tbody id="country-visiting-data">
                        
                    </tbody>
                </table>
            </div>
            <br>
        </div>
    </div>

    <div class="col-12 col-md-6">
        <div class="panel panel-headline">
            <div class="panel-loader loader-yearly-visitor" id="yearly-by-country-loader">
                <div class="loader4"></div>
            </div>
            <div class="panel-heading">
                <h3 class="panel-title" id="yearly-by-country-title"></h3>
            </div>
            <div class="panel-body" id="yearly-by-country">
                <div class="null-data-wrapper">
                    <i class="far fa-info-circle"></i> <h4>Select country to view visitors</h4>
                </div>
            </div>
            <br>
        </div>
    </div>
</div>

@endsection