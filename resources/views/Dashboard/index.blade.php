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
                            <h5 class="card-title"><i class="fas fa-users"></i> User Age Distribution (Pie Chart)</h5>
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
<style>
    .card {
        border-radius: 12px;
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease-in-out;
        background-color: #f9f9f9;
    }

    .card:hover {
        transform: translateY(-5px);
    }

    .chart-container {
        width: 100%;
        height: 300px;
        margin-top: 20px;
    }

    .card-body {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
    }

    .chart-card {
        flex: 1;
        padding: 20px;
        margin: 10px;
        background-color: #e9ecf0;
        border-radius: 8px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .stats-container {
        display: flex;
        justify-content: space-between;
        margin-bottom: 40px;
    }

    .stats-card {
        flex: 1;
        padding: 20px;
        color: white;
        border-radius: 8px;
        text-align: center;
        margin: 5px;
        transition: transform 0.3s ease;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .stats-card:hover {
        transform: translateY(-5px);
    }

    .stats-card h3 {
        font-size: 1.8rem;
        margin-bottom: 10px;
    }

    .stats-card p {
        font-size: 1.4rem;
    }

    .stats-card-blue {
        background: #dc3545;
    }

    .stats-card-green {
        background: #28a745;
    }

    .stats-card-yellow {
        background: #ffc107;
    }

    .stats-card-red {
        background: #007bff;
    }

    .chart-cards .card-body {
        padding: 20px;
    }

    .card-title {
        font-size: 1.2rem;
        font-weight: bold;
        margin-bottom: 15px;
    }

    @media (max-width: 768px) {
        .stats-container {
            flex-direction: column;
            align-items: center;
        }

        .stats-card {
            margin: 10px 0;
            width: 100%;
        }

        .chart-cards .col-lg-6,
        .chart-cards .col-md-6 {
            flex: 1;
            max-width: 100%;
            margin-bottom: 20px;
        }
    }
</style>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>

    document.addEventListener('DOMContentLoaded', () => {
        const bearerToken = document.querySelector('meta[name="bearer-token"]').getAttribute('content');
        console.log(bearerToken);
        fetch('/api/dashboard-data', {
                    method: 'GET',
                    headers: {
                        'Content-Type': 'application/json',
                        'Authorization': `Bearer ${bearerToken}`,
                        'X-Requested-With': 'XMLHttpRequest'  
                    },
                    credentials: 'same-origin'
                })
            .then(response => {
                if (!response.ok) {
                    // if (response.status === 401 || response.status === 403) {
                    //     window.location.href = '/login';  // Redirect to login if unauthorized
                    //     throw new Error('Unauthorized');
                    // }
                    throw new Error('Network response was not ok');
                }
                return response.json()
            })
            .then(data => {
                
                barChart.data.datasets[0].data = data.pageViewsData.values;
                barChart.data.labels = data.pageViewsData.labels;
                barChart.update();

                lineChart.data.datasets[0].data = data.articlesPublishedData.values;
                lineChart.data.labels = data.articlesPublishedData.labels;
                lineChart.update();

                // Update Doughnut Chart
                doughnutChart.data.labels = data.categoryDistribution.labels;
                doughnutChart.data.datasets[0].data = data.categoryDistribution.values;
                doughnutChart.update();
            })
            .catch(error => console.error('Error fetching dashboard data:', error));
    });

    // Bar Chart with gradient and better animation
    const ctxBar = document.getElementById('barChart').getContext('2d');
    const gradientBar = ctxBar.createLinearGradient(0, 0, 0, 400);
    gradientBar.addColorStop(0, 'rgba(0,123,255,0.6)');
    gradientBar.addColorStop(1, 'rgba(0,123,255,0.2)');

    const barChart = new Chart(ctxBar, {
        type: 'bar',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May'],
            datasets: [{
                label: 'Page Views',
                data: [1500, 2000, 3000, 4000, 2500],
                backgroundColor: gradientBar,
                borderColor: '#007bff',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(0,0,0,0.1)'
                    }
                },
                x: {
                    grid: {
                        color: 'rgba(0,0,0,0.1)'
                    }
                }
            },
            animations: {
                tension: {
                    duration: 500,
                    easing: 'easeInOutQuad',
                    from: 1,
                    to: 0,
                    loop: true
                }
            },
            tooltips: {
                backgroundColor: 'rgba(0, 123, 255, 0.7)',
                titleFontSize: 14,
                bodyFontSize: 12,
                bodyFontColor: '#fff',
                borderColor: 'rgba(0, 123, 255, 0.8)',
                borderWidth: 2
            }
        }
    });

    // Line Chart with smooth gradient
    const ctxLine = document.getElementById('lineChart').getContext('2d');
    const gradientLine = ctxLine.createLinearGradient(0, 0, 0, 400);
    gradientLine.addColorStop(0, 'rgba(40,167,69,0.6)');
    gradientLine.addColorStop(1, 'rgba(40,167,69,0.2)');

    const lineChart = new Chart(ctxLine, {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May'],
            datasets: [{
                label: 'Articles Published',
                data: [20, 40, 35, 55, 50],
                borderColor: '#28a745',
                borderWidth: 2,
                fill: true,
                backgroundColor: gradientLine,
                tension: 0.3
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    grid: {
                        color: 'rgba(0,0,0,0.1)'
                    }
                },
                x: {
                    grid: {
                        color: 'rgba(0,0,0,0.1)'
                    }
                }
            },
            tooltips: {
                backgroundColor: 'rgba(40, 167, 69, 0.7)',
                titleFontSize: 14,
                bodyFontSize: 12,
                bodyFontColor: '#fff',
                borderColor: 'rgba(40, 167, 69, 0.8)',
                borderWidth: 2
            }
        }
    });

    // Doughnut Chart with smoother design
    const ctxDoughnut = document.getElementById('doughnutChart').getContext('2d');
    const doughnutChart = new Chart(ctxDoughnut, {
        type: 'doughnut',
        data: {
            labels: ['Technology', 'Lifestyle', 'Health', 'Business'],
            datasets: [{
                data: [50, 20, 15, 15],
                backgroundColor: ['#007bff', '#28a745', '#ffc107', '#dc3545'],
                borderColor: '#fff',
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            cutout: '70%',
            plugins: {
                tooltip: {
                    backgroundColor: 'rgba(0, 123, 255, 0.7)',
                    titleFontSize: 14,
                    bodyFontSize: 12,
                    bodyFontColor: '#fff',
                    borderColor: 'rgba(0, 123, 255, 0.8)',
                    borderWidth: 2
                },
                legend: {
                    position: 'bottom',
                    labels: {
                        fontColor: '#333',
                        fontSize: 14
                    }
                }
            }
        }
    });

    // Pie Chart with improved animation
    const ctxPie = document.getElementById('pieChart').getContext('2d');
    const pieChart = new Chart(ctxPie, {
        type: 'pie',
        data: {
            labels: ['18-24', '25-34', '35-44', '45+'],
            datasets: [{
                data: [30, 40, 20, 10],
                backgroundColor: ['#007bff', '#28a745', '#ffc107', '#dc3545'],
                borderColor: '#fff',
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            animation: {
                duration: 1000,
                easing: 'easeOutBounce'
            },
            plugins: {
                tooltip: {
                    backgroundColor: 'rgba(0, 123, 255, 0.7)',
                    titleFontSize: 14,
                    bodyFontSize: 12,
                    bodyFontColor: '#fff',
                    borderColor: 'rgba(0, 123, 255, 0.8)',
                    borderWidth: 2
                },
                legend: {
                    position: 'top',
                    labels: {
                        fontColor: '#333',
                        fontSize: 14
                    }
                }
            }
        }
    });
</script>

@endsection