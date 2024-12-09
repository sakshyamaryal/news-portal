@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="content">
    <main class="p-4">
        <div class="card-main-content">
            <div class="d-flex flex-wrap stats-container">
                <div class="stats-card stats-card-blue">
                    <h3><i class="fas fa-newspaper"></i> Articles</h3>
                    <p>{{ number_format($articlesCount) }}</p> <!-- Display articles count -->
                </div>
                <div class="stats-card stats-card-green">
                    <h3><i class="fas fa-eye"></i> Page Views</h3>
                    <p>{{ number_format($pageViews) }}</p> <!-- Display page views -->
                </div>
                <div class="stats-card stats-card-yellow">
                    <h3><i class="fas fa-users"></i> Users</h3>
                    <p>{{ number_format($usersCount) }}</p> <!-- Display users count -->
                </div>
                <div class="stats-card stats-card-red">
                    <h3><i class="fas fa-comments"></i> Comments</h3>
                    <p>{{ number_format($commentsCount) }}</p> <!-- Display comments count -->
                </div>

            </div>

            <!-- Charts Section -->
            <div class="chart-cards row">
                <div class="col-lg-6 col-md-6 col-sm-12 chart-card">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title"><i class="fas fa-chart-bar"></i> Page Views (Bar Chart)</h5>
                            <div class="chart-container">
                                <canvas id="barChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 chart-card">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title"><i class="fas fa-chart-pie"></i> Article Distribution (Doughnut Chart)</h5>
                            <div class="chart-container">
                                <canvas id="doughnutChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="chart-cards row">

                <div class="col-lg-6 col-md-6 col-sm-12 chart-card">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title"><i class="fas fa-users"></i> Top 20 Commented Article (Pie Chart)</h5>
                            <div class="chart-container">
                                <canvas id="pieChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 chart-card">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title"><i class="fas fa-chart-line"></i> Articles Published (Line Chart)</h5>
                            <div class="chart-container">
                                <canvas id="lineChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>
<link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="{{ asset('js/dashboard.js') }}"></script>

@endsection