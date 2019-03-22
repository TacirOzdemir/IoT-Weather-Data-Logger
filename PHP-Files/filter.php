<?php
	// If variable is set and not NULL
	if(isset($_POST["from_date"], $_POST["to_date"])) {
		
		// Start MySQL Connection
		$mysqli = mysqli_connect("localhost","tacirozdemir","zgb6Epvkw0S#","tacirozd_IoT_Project");
		
		$output = '';
		
		// Select data between dates
		$query = " SELECT * FROM Data WHERE Date BETWEEN '".$_POST["from_date"]."' AND '".$_POST["to_date"]."' ORDER BY ID desc ";
		$result = mysqli_query($mysqli, $query);
		
		$table_class = "table table-bordered";
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
		
		// If number of rows in table are more than 0
		if( mysqli_num_rows($result) > 0 ) {
			
			// Fetch data and enter into table
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
		}
		
		// If number of rows is 0
		else {
			$output .= '
				<tr>
					<td colspan="4" >No Order Found</td>
				</tr>
			';
		}
		
		// Close table
		$output .= '</table>';
		
		// echo table
		echo $output;
	}
?>