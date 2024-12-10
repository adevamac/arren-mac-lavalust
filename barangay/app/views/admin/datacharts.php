<?php
defined('PREVENT_DIRECT_ACCESS') or exit('No direct script access allowed');

?>

<div class="row">
    <!-- Gender Distribution Chart -->
    <div class="col-lg-6 mb-4">
        <div class="card shadow h-100">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Gender Distribution</h6>
            </div>
            <div class="card-body">
                <!-- Chart container -->
                <div class="chart-container">
                    <canvas id="genderChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Civil Status Distribution Chart -->
    <div class="col-lg-6 mb-4">
        <div class="card shadow h-100">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Civil Status Distribution</h6>
            </div>
            <div class="card-body">
                <!-- Chart container -->
                <div class="chart-container">
                    <canvas id="civilStatusChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Second Row of Charts -->
<div class="row">
    <!-- Age Distribution Chart -->
    <div class="col-lg-6 mb-4">
        <div class="card shadow h-100">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Age Distribution</h6>
            </div>
            <div class="card-body">
                <!-- Chart container -->
                <div class="chart-container">
                    <canvas id="ageChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Occupation Status Chart -->
    <div class="col-lg-6 mb-4">
        <div class="card shadow h-100">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Occupation Status Distribution</h6>
            </div>
            <div class="card-body">
                <div class="chart-container">
                    <canvas id="occupationStatusChart"></canvas>
                </div>
            </div>
        </div>
    </div>

</div>
<!-- 3rd Row of Charts -->
<div class="row">
    <!-- Streets/Sitios Chart -->
    <div class="col-lg-6 mb-4">
        <div class="card shadow h-100">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Top Streets/Sitios</h6>
            </div>
            <div class="card-body">
                <!-- Chart container -->
                <div class="chart-container">
                    <canvas id="streetSitioChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-6 mb-4">
        <div class="card shadow h-100">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Age Distribution by Civil Status</h6>
            </div>
            <div class="card-body">
                <div class="chart-container">
                    <canvas id="ageCivilStatusChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Prepare labels and data for the gender chart
    var genderLabels = [];
    var genderData = [];
    <?php foreach ($gender_distribution as $item): ?>
        genderLabels.push('<?php echo addslashes($item['gender']); ?>');
        genderData.push(<?php echo $item['count']; ?>);
    <?php endforeach; ?>

    var ctxGender = document.getElementById('genderChart').getContext('2d');
    var genderChart = new Chart(ctxGender, {
        type: 'pie', // or 'doughnut' for a donut chart
        data: {
            labels: genderLabels,
            datasets: [{
                label: 'Gender Distribution',
                data: genderData,
                backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56'], // Customize colors as needed
                borderColor: ['#FFFFFF', '#FFFFFF', '#FFFFFF'],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false, // Prevent scaling issue
            plugins: {
                legend: {
                    display: true,
                    position: 'top'
                },
                tooltip: {
                    callbacks: {
                        label: function(tooltipItem) {
                            return tooltipItem.label + ': ' + tooltipItem.raw;
                        }
                    }
                }
            }
        }
    });

    // Prepare labels and data for the civil status chart
    var civilStatusLabels = [];
    var civilStatusData = [];
    <?php foreach ($civil_status_distribution as $item): ?>
        civilStatusLabels.push('<?php echo addslashes($item['civil_status']); ?>');
        civilStatusData.push(<?php echo $item['count']; ?>);
    <?php endforeach; ?>

    var ctxCivilStatus = document.getElementById('civilStatusChart').getContext('2d');
    var civilStatusChart = new Chart(ctxCivilStatus, {
        type: 'bar', // or 'doughnut' for a donut chart
        data: {
            labels: civilStatusLabels,
            datasets: [{
                label: 'Civil Status Distribution',
                data: civilStatusData,
                backgroundColor: '#4e73df', // Customize color
                borderColor: '#2e59d9',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false, // Prevent scaling issue
            scales: {
                x: {
                    beginAtZero: true
                },
                y: {
                    beginAtZero: true
                }
            },
            plugins: {
                legend: {
                    display: true,
                    position: 'top'
                },
                tooltip: {
                    callbacks: {
                        label: function(tooltipItem) {
                            return tooltipItem.label + ': ' + tooltipItem.raw;
                        }
                    }
                }
            }
        }
    });

    // Prepare labels and data for the age chart
    var ageLabels = [];
    var ageCounts = [];
    <?php foreach ($age_distribution as $item): ?>
        ageLabels.push("<?php echo $item['age_range']; ?>");
        ageCounts.push(<?php echo $item['count']; ?>);
    <?php endforeach; ?>

    // Render Chart.js Bar Chart
    var ctx = document.getElementById('ageChart').getContext('2d');
    var ageChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ageLabels,
            datasets: [{
                label: 'Age Distribution',
                data: ageCounts,
                backgroundColor: [
                    '#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF', '#FF9F40'
                ],
                borderColor: [
                    '#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF', '#FF9F40'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    // Prepare data for Occupation Status Chart
    var occupationLabels = [];
    var occupationData = [];

    <?php foreach ($occupation_status_distribution as $item): ?>
        occupationLabels.push('<?php echo addslashes($item['occupation_status']); ?>');
        occupationData.push(<?php echo $item['count']; ?>);
    <?php endforeach; ?>

    // Create Occupation Status Chart
    var ctxOccupation = document.getElementById('occupationStatusChart').getContext('2d');
    var occupationStatusChart = new Chart(ctxOccupation, {
        type: 'bar', // Change to 'horizontalBar' for horizontal bar chart
        data: {
            labels: occupationLabels,
            datasets: [{
                label: 'Occupation Status Distribution',
                data: occupationData,
                backgroundColor: [
                    '#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF', '#FF9F40'
                ],
                borderColor: [
                    '#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF', '#FF9F40'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: { // For vertical bar chart
                    beginAtZero: true
                },
                x: { // For horizontal bar chart
                    beginAtZero: true
                }
            },
            plugins: {
                legend: {
                    display: true,
                    position: 'top'
                },
                tooltip: {
                    callbacks: {
                        label: function(tooltipItem) {
                            return tooltipItem.label + ': ' + tooltipItem.raw;
                        }
                    }
                }
            }
        }
    });

    // Prepare labels and data for the chart
    var streetSitioLabels = [];
    var streetSitioCounts = [];
    <?php foreach ($street_sitio_distribution as $item): ?>
        streetSitioLabels.push('<?php echo addslashes($item['street_sitio']); ?>');
        streetSitioCounts.push(<?php echo $item['count']; ?>);
    <?php endforeach; ?>

    var ctxStreetSitio = document.getElementById('streetSitioChart').getContext('2d');
    var streetSitioChart = new Chart(ctxStreetSitio, {
        type: 'bar', // Change to 'horizontalBar' for horizontal bars
        data: {
            labels: streetSitioLabels,
            datasets: [{
                label: 'Number of Individuals',
                data: streetSitioCounts,
                backgroundColor: '#4e73df', // Customize color as needed
                borderColor: '#2e59d9',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                x: {
                    beginAtZero: true
                },
                y: {
                    beginAtZero: true
                }
            },
            plugins: {
                legend: {
                    display: true,
                    position: 'top'
                },
                tooltip: {
                    callbacks: {
                        label: function(tooltipItem) {
                            return tooltipItem.label + ': ' + tooltipItem.raw;
                        }
                    }
                }
            }
        }
    });

    // Prepare labels and data for the stacked bar chart
    var ageLabels = [];
    var civilStatusData = {};

    // Collect age labels and organize data by civil status
    <?php foreach ($age_civil_status_distribution as $item): ?>
        if (!ageLabels.includes('<?php echo $item['age_group']; ?>')) {
            ageLabels.push('<?php echo $item['age_group']; ?>');
        }

        if (!civilStatusData['<?php echo addslashes($item['civil_status']); ?>']) {
            civilStatusData['<?php echo addslashes($item['civil_status']); ?>'] = [];
        }

        // Push count for the specific age group and civil status
        civilStatusData['<?php echo addslashes($item['civil_status']); ?>'].push(<?php echo $item['count']; ?>);
    <?php endforeach; ?>

    // Create datasets for each civil status
    var datasets = [];
    var colors = ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF', '#FF9F40']; // Example colors
    var i = 0;

    // Ensure each dataset has data for all age ranges
    for (var status in civilStatusData) {
        var data = [];
        ageLabels.forEach(function(label) {
            var foundIndex = ageLabels.indexOf(label);
            var found = civilStatusData[status][foundIndex];
            data.push(found !== undefined ? found : 0); // Default to 0 if not found
        });

        datasets.push({
            label: status,
            data: data,
            backgroundColor: colors[i % colors.length],
            borderWidth: 1
        });
        i++;
    }

    // Render Chart.js Stacked Bar Chart
    var ctx = document.getElementById('ageCivilStatusChart').getContext('2d');
    var ageCivilStatusChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ageLabels,
            datasets: datasets
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true
                }
            },
            plugins: {
                legend: {
                    display: true,
                    position: 'top'
                },
                tooltip: {
                    callbacks: {
                        label: function(tooltipItem) {
                            return tooltipItem.label + ': ' + tooltipItem.raw;
                        }
                    }
                }
            }
        }
    });
</script>