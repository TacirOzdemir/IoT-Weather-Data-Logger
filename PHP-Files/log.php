<?php 
	// Start MySQL Connection
	$mysqli = mysqli_connect("localhost","tacirozdemir","zgb6Epvkw0S#","tacirozd_IoT_Project");
?>

<html>
	<head>
		<title>Raspberry Pi Weather Log</title>
		
		<link rel="stylesheet" type="text/css" href="log_style.css" >
	</head>

	<body>
		<h1>Raspberry Pi Weather Log</h1>


		<table border="0" cellspacing="0" cellpadding="4">
			<tr>
				<td class="table_titles">ID</td>
				<td class="table_titles">Date and Time</td>
				<td class="table_titles">Temperature</td>
				<td class="table_titles">Humidity</td>
			</tr>

			<?php
				// Retrieve all records and order
				$query = "SELECT * FROM Data ORDER BY ID desc";
				$result = mysqli_query($mysqli, $query);

				// Used for row color toggle
				$oddrow = true;

				// Process every record
				while( $row = mysqli_fetch_array( $result ) ){
					if ($oddrow) 
					{ 
						$css_class=' class="table_cells_odd"'; 
					}
					else
					{ 
						$css_class=' class="table_cells_even"'; 
					}

					$oddrow = !$oddrow;

					echo '<tr>';
					echo '   <td'.$css_class.'>'.$row["ID"].'</td>';
					echo '   <td'.$css_class.'>'.$row["Date"].'</td>';
					echo '   <td'.$css_class.'>'.$row["Temperature"].'</td>';
					echo '   <td'.$css_class.'>'.$row["Humidity"].'</td>';
					echo '</tr>';
				}
			?>
			
		</table>
	</body>
</html>