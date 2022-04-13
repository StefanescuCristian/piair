<?php

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// selecteaza o valoare per minut, tine istoric o ~saptamna
$query_history = "SELECT * FROM (SELECT data,temperature,pressure,humidity,airq FROM sensor WHERE id MOD 60 = 0 ORDER BY id DESC LIMIT 10080) subtable ORDER BY data ASC;";

$his_result = $conn->query($query_history);

$conn->close();

if ($his_result->num_rows > 0) {
  while($row = $his_result->fetch_assoc()) {
    $vector_data[] = $row["data"];
    $vector_pressure[] = $row["pressure"];
    $vector_temperature[] = $row["temperature"];
    $vector_humidity[] = $row["humidity"];
    $vector_airq[] = $row["airq"];
  }
}
$vector_csv_data = "'".implode("','",$vector_data)."'";
$vector_csv_temperature = "'".implode("','",$vector_temperature)."'";
$vector_csv_pressure = "'".implode("','",$vector_pressure)."'";
$vector_csv_humidity = "'".implode("','",$vector_humidity)."'";
$vector_csv_airq = "'".implode("','",$vector_airq)."'";

?>
