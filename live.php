<?php
$query_live = "SELECT temperature,pressure,humidity,airq FROM sensor ORDER BY id DESC LIMIT 1";

$live_result = $conn->query($query_live);

$conn->close();

if ($live_result->num_rows > 0){
	while($row = $live_result->fetch_assoc()) {
		$live_temp=$row["temperature"];
		$live_hum=$row["humidity"];
		$live_press=$row["pressure"];
		$live_air_q=$row["airq"];
	}
}

?>
