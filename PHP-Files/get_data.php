<?php 
	// Start MySQL Connection
	$mysqli = mysqli_connect("localhost","tacirozdemir","zgb6Epvkw0S#","tacirozd_IoT_Project");

	// Retrieve all records
	$query = mysqli_query($mysqli, "SELECT * FROM Data");

	// Make array for each value
	$date = array();
	$temp = array();
	$hum = array();

	// Fetch data
	while( $data = mysqli_fetch_array($query) ) { 
		$date[] = $data['Date'];
		$temp[] = $data['Temperature']; 
		$hum[]  = $data['Humidity'];
	}

	// Close connection
	mysqli_close($mysqli);

	// Convert normal array to json array and echo
	$json = array('date' => $date, 'temp' => $temp, 'hum' => $hum);
	echo json_encode($json);
?>