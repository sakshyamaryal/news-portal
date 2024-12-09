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

            pieChart.data.labels = data.topCommentedArticles.labels;
            pieChart.data.datasets[0].data = data.topCommentedArticles.values;
            pieChart.update();
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
            data: [],
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
            data: [],
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
            data: [],
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
    type: 'pie', // Pie chart type
    data: {
        labels: ['Article 1', 'Article 2', 'Article 3', 'Article 4'], 
        datasets: [{
            data: [], 
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