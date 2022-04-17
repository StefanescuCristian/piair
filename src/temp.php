<?php
require 'conn.php';
$query_live = "SELECT temperature,pressure,humidity,airq FROM sensor ORDER BY id DESC LIMIT 1";

$live_result = $conn->query($query_live);

$conn->close();

if ($live_result->num_rows > 0){
	while($row = $live_result->fetch_assoc()) {
		$live_temp=$row["temperature"];
	}
}
echo $live_temp;
?>
