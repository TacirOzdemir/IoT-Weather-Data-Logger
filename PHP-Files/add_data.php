<?php
	// Rpi sends data here and this script stores it in the database
	
	// Connect to MySQL
	$mysqli = mysqli_connect("localhost","tacirozdemir","zgb6Epvkw0S#","tacirozd_IoT_Project");
	
	// Set timezone
	date_default_timezone_set('Europe/Brussels');

	// Get date
	$dateS = date('Y/m/d H:i:s', time());
	echo $dateS;
	
	// Enter values into table in database
	$SQL = "INSERT INTO tacirozd_IoT_Project.Data (Date,Temperature,Humidity) VALUES ('$dateS','".$_GET["temp"]."','".$_GET["hum"]."')";

	// Execute SQL statement
	mysqli_query($mysqli, $SQL);
?>