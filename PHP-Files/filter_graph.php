<?php
	// If variable is set and not NULL
	if(isset($_POST["from_date"], $_POST["to_date"])) {
		
		// Start MySQL Connection
		$mysqli = mysqli_connect("localhost","tacirozdemir","zgb6Epvkw0S#","tacirozd_IoT_Project");
		
		// Select data between dates
		$query = " SELECT * FROM Data WHERE Date BETWEEN '".$_POST["from_date"]."' AND '".$_POST["to_date"]."' ";
		$result = mysqli_query($mysqli, $query);
		
		// Make array for each value
		$date = array();
		$temp = array();
		$hum = array();
		
		// If number of rows in table are more than 0
		if( mysqli_num_rows($result) > 0 ) {
			
			// Get data and put into array
			while( $row = mysqli_fetch_array($result) ) {
				$date[] = $row['Date'];
				$temp[] = $row['Temperature']; 
				$hum[] = $row['Humidity'];
			}
		}
		
		// Convert normal array to json array and echo
		$json = array('date' => $date, 'temp' => $temp, 'hum' => $hum);
		echo json_encode($json);
	}
?>