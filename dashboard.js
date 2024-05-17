import track from track.php;

document.addEventListener('DOMContentLoaded', function () {
    fetch('track.php')
        .then(response => response.json())
        .then(data => {
            Highcharts.chart('operationTimeChart', {
                chart: { type: 'column' },
                title: { text: 'Email Operations Duration' },
                xAxis: { categories: Object.keys(data) },
                yAxis: { min: 0, title: { text: 'Duration (seconds)' } },
                plotOptions: { column: { colorByPoint: true } },
                series: [{
                    name: 'Durations',
                    data: Object.values(data),
                    showInLegend: false
                }]
            });
        })
        .catch(error => console.log('Error loading the data:', error));
});
