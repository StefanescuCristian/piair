<?php
//load file
require 'conn.php';
require 'history.php';

?>
<!DOCTYPE html>
<html>

<head>
	<title>RPi Weather Station</title>
  <link rel="stylesheet" type="text/css" href="theme.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.3/Chart.bundle.js" integrity="sha256-o8aByMEvaNTcBsw94EfRLbBrJBI+c3mjna/j4LrfyJ8=" crossorigin="anonymous"></script>
</head>

<body>

  <ul>
     <li><div id="live"><a href="index.php">Live stats</a></div></li>
     <li><div id="history"><a class="active" href="graphs.php">History</a></div></li>
  </ul>
<br/>
<div class="chart-temperature" style="position: relative; height:40vh; width:95vw">
  <canvas id="chart-temp"></canvas>
</div>

<div class="chart-pressure" style="position: relative; height:40vh; width:95vw">
  <canvas id="chart-press"></canvas>
</div>

<div id="soruces" align="center">
Sources: <a href="https://www.chartjs.org">https://www.chartjs.org</a>
</div>

<script>
var ctx_t = document.getElementById("chart-temp").getContext('2d');
var chart_temp = new Chart(ctx_t, {
    type: 'line',
    data: {
        labels: [<?=$vector_csv_data?>],
        datasets: [{
            label: 'Temperatura',
            data: [<?=$vector_csv_temperature?>],
            borderColor: 'rgb(50, 50, 200, 0.7)',
            backgroundColor: 'rgb(255, 255, 255, 0.0)',
            pointRadius: '0',
          },
              {
              label: 'Umiditate',
              data: [<?=$vector_csv_humidity?>],
              borderColor: 'rgb(200, 200, 50, 0.7)',
              backgroundColor: 'rgb(255, 255, 255, 0.0)',
              pointRadius: '0',
              },
            {
            label: 'IAQ',
            data: [<?=$vector_csv_airq?>],
            borderColor: 'rgb(50, 200, 50, 0.7)',
            backgroundColor: 'rgb(255, 255, 255, 0.0)',
            pointRadius: '',
            }
          ]
    },
    options: {
      maintainAspectRatio: false,
      responsive: true,
      animation: {
        duration: '1',
      },
      legend: {
        position: 'bottom',
      },
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero:false
                }
            }]
        },
    }
});

var ctx_p = document.getElementById("chart-press").getContext('2d');
var chart_press = new Chart(ctx_p, {
    type: 'line',
    data: {
        labels: [<?=$vector_csv_data?>],
        datasets: [{
            label: 'Presiune',
            data: [<?=$vector_csv_pressure?>],
            borderColor: 'rgb(200, 50, 50, 0.7)',
            backgroundColor: 'rgb(255, 255, 255, 0.0)',
            pointRadius: '0',
            }]
    },
    options: {
      maintainAspectRatio: false,
      responsive: true,
      animation: {
        duration: '1',
      },
      legend: {
        position: 'bottom',
      },
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero:false
                }
            }]
        }
    }
});

</script>

</body>
</html>
