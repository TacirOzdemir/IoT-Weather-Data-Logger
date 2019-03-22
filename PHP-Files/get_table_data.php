<?php
	// Start MySQL Connection
	$mysqli = mysqli_connect("localhost","tacirozdemir","zgb6Epvkw0S#","tacirozd_IoT_Project");
	
	// Retrieve all records and order
	$query = "SELECT * FROM Data ORDER BY ID desc";
	$result = mysqli_query($mysqli, $query);
	
	// Output
	$output = '';
	$table_class = "table table-bordered";
	
	// Column-widht
	$id_width = "5%";
	$date_width = "55%";
	$temp_width = "20%";
	$hum_width = "20%";
	
	// Start Table
	$output .= '<div id="table-header" style="max-width:100%; height:30px;" ><h1 id="table-interface" >Table Interface</h1></div>';
	$output .= "
		<br>
		<br>
		<table class=$table_class>
			<tr>
				<th width=$id_width>ID</th>
				<th width=$date_width>DATE</th>
				<th width=$temp_width>TEMPERATURE</th>
				<th width=$hum_width>HUMIDITY</th>
			</tr>
	";
	
	// Constantly fetch data and enter in table
	while( $row = mysqli_fetch_array($result) ) {
		$ID = $row["ID"];
		$Date = $row["Date"];
		$Temperature = $row["Temperature"];
		$Humidity = $row["Humidity"];
		$output .= "
			<tr>
				<td>  $ID  </td>
				<td>  $Date  </td>
				<td>  $Temperature  </td>
				<td>  $Humidity  </td>
			</tr>
		";
	}
	
	// Close table
	$output .= '</table>';
	
	// Echo table
	echo $output;
?>