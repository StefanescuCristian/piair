<?php
//load file
require 'conn.php';
require 'live.php';
?>
<!DOCTYPE html>
<html>

<head>
	<title>RPi Weather Station</title>
	<link rel="stylesheet" type="text/css" href="theme.css">
	<script src="https://cdn.rawgit.com/Mikhus/canvas-gauges/gh-pages/download/2.1.5/all/gauge.min.js" integrity="sha384-i97mzZI+SCEReyHBSaYZjZ/SwkC601M8cm2HFCebvPNDv2SW3UGBpDXmhpZ/fgoO" crossorigin="anonymous"></script>
	<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>

	<script type="text/javascript">

	function doRefresh(){
		$("#gauges").load(location.href+" #gauges>*","");
	}
  $(function() {
		setInterval(doRefresh, 5000);
  });
	</script>
</head>

<body>
<ul>
   <li><div id="live"><a class="active" href="index.php">Live stats</a></div></li>
   <li><div id="history"><a href="graphs.php">History</a></div></li>
</ul>


<div id="gauges" align="center">
<canvas id="thermometer"
		data-type="linear-gauge"
		data-width="150"
		data-height="600"
	  data-units="<?=$live_temp?> °C"
		data-min-value="0"
		data-max-value="50"
		data-major-ticks="0,10,20,30,40,50"
		data-minor-ticks="10"
		data-borders="false"
		data-border-shadow-width="0"
		data-value-box="false"
		data-highlights='[{"from": 35, "to": 50, "color": "rgba(200, 50, 50, .75)"}]'
		data-value=<?=$live_temp?>
></canvas>
<canvas id="barometer"
		data-type="radial-gauge"
		data-width="300"
		data-height="300"
	  data-units="<?=$live_press?> hPa"
		data-min-value="600"
		data-max-value="1200"
		data-major-ticks="600,700,800,900,1000,1100,1200"
		data-minor-ticks="10"
		data-borders="false"
		data-border-shadow-width="0"
		data-value-box="false"
		data-highlights='[{"from": 1100, "to": 1200, "color": "rgba(200, 50, 50, .75)"}]'
		data-value=<?=$live_press?>
></canvas>
<canvas id="hygrometer"
		data-type="linear-gauge"
		data-width="150"
		data-height="600"
	  data-units="<?=$live_hum?> %RH"
		data-min-value="0"
		data-max-value="100"
		data-major-ticks="0,10,20,30,40,50,60,70,80,90,100"
		data-minor-ticks="10"
		data-borders="false"
		data-border-shadow-width="0"
		data-value-box="false"
		data-highlights='[{"from": 0, "to": 30, "color": "rgba(200, 50, 50, .75)"},{"from": 30, "to": 60, "color": "rgba(50, 200, 50, .75)"},{"from": 60, "to": 100, "color": "rgba(200, 50, 50, .75)"}]'
		data-value=<?=$live_hum?>
></canvas>
<canvas id="iaq_index"
		data-type="radial-gauge"
		data-width="300"
		data-height="300"
		data-units="IAQ: <?=$live_air_q?> %"
		data-min-value="0"
		data-start-angle="0"
		data-ticks-angle="180"
		data-value-box="false"
		data-max-value="100"
		data-major-ticks="0,20,40,60,80,100"
		data-minor-ticks="2"
		data-stroke-ticks="true"
		data-highlights='[{"from": 0, "to": 40, "color": "rgba(200, 50, 50, .75)"},{"from": 40, "to": 60, "color": "rgba(200, 200, 50, .75)"},{"from": 60, "to": 100, "color": "rgba(50, 200, 50, .75)"}]'
		data-color-plate="#fff"
		data-border-shadow-width="0"
		data-borders="false"
		data-needle-type="arrow"
		data-needle-width="2"
		data-needle-circle-size="7"
		data-needle-circle-outer="true"
		data-needle-circle-inner="false"
		data-value=<?=$live_air_q?>
></canvas>
</div>

<br/><br/><br/>

<div id="soruces" align="center">
Sources: <a href="https://canvas-gauges.com/">https://canvas-gauges.com/</a>, <a href="https://code.jquery.com/">https://code.jquery.com/</a>
</div>

</body>
