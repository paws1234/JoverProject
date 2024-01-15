<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Item Purchase Charts</title>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100">

    <div class="container mx-auto p-8">
        <div id="chartsContainer" class="flex flex-wrap gap-4 justify-center">

            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    var genres = ['Foods', 'Clothes', 'Essentials', 'Furniture', 'Luxury'];

                    genres.forEach(function (genre) {
                        fetchDataAndRenderChart('chartsContainer', genre);
                    });
                });

                function fetchDataAndRenderChart(containerId, genre) {
                    $.ajax({
                        url: 'fetch_data.php',
                        method: 'POST',
                        data: { genre: genre },
                        success: function (response) {
                            console.log('Raw Response for ' + genre + ':', response);

                            try {
                                renderChart(containerId, genre, response);
                            } catch (error) {
                                console.error('Error rendering chart for ' + genre + ':', error);
                            }
                        },
                        error: function (xhr, status, error) {
                            console.error('Error fetching data for ' + genre + ':', error);
                        }
                    });
                }

                function renderChart(containerId, genre, response) {
                    var container = document.getElementById(containerId);

                    if (!container) {
                        console.error('Container element not found.');
                        return;
                    }

                    var canvas = document.createElement('canvas');
                    canvas.id = genre + 'Chart';
                    canvas.className = 'w-full sm:w-1/2 md:w-1/3 lg:w-1/4 p-4';
                    canvas.style.height = '300px';

                    container.appendChild(canvas);

                    var ctx = canvas.getContext('2d');

                    if (!ctx) {
                        console.error('Canvas context is not available for ' + genre + '.');
                        return;
                    }

                    var chartType = getChartType(genre);

                    var myChart = new Chart(ctx, {
                        type: chartType,
                        data: {
                            labels: response.labels,
                            datasets: [{
                                label: response.datasets[0].label,
                                data: response.datasets[0].data,
                                backgroundColor: response.datasets[0].backgroundColor,
                                borderColor: response.datasets[0].borderColor,
                                borderWidth: response.datasets[0].borderWidth,
                            }]
                        },
                        options: {
                            scales: {
                                y: {
                                    beginAtZero: true
                                }
                            }
                        }
                    });
                }

                function getChartType(genre) {
                    switch (genre) {
                        case 'Foods':
                            return 'bar';
                        case 'Clothes':
                            return 'line';
                        case 'Essentials':
                            return 'radar';
                        case 'Furniture':
                            return 'polarArea';
                        case 'Luxury':
                            return 'doughnut';
                        default:
                            return 'bar';
                    }
                }
            </script>
        </div>
    </div>

</body>

</html>
