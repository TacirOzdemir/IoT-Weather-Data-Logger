<?php 
	// Start MySQL Connection
	$mysqli = mysqli_connect("localhost","tacirozdemir","zgb6Epvkw0S#","tacirozd_IoT_Project");
	
	// Retrieve all records and display them
	$query = "SELECT * FROM Data ORDER BY ID desc";
	$result = mysqli_query($mysqli, $query);
?>
<html>

<head>
    <title>Raspberry Pi DHT11 Data</title>
	
	<!-- Load scripts, links stylesheets etc -->
	<script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.min.js" ></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js" ></script>
	<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="style.css" >
	<link rel="stylesheet" href="http://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Bungee|Ubuntu">
	<link href="https://fonts.googleapis.com/css?family=Bungee" rel="stylesheet">
</head>

<body>
	<!-- Title -->
	<div id="header" style="width:100%; height:100px; padding-top:25px;" >
		<h1 id="headerText" ><span>DHT11 Sensor Data</span></h1>
	</div>
	
	<!-- Chart -->
	<div style="max-width:100%;" >
		<div id="chart-container" >
			<div id="graph-header" style="max-width:100%; height:30px;" >
				<h1 id="graph-interface" >Graphical Interface</h1>
			</div>
			<canvas id="myChart" width="70%" style="margin-top:30px;" ></canvas>
		</div>
	</div>
	
	<br>
	
	<!-- Title date range -->
	<div id="daterangediv" style="height:30px;" ><h1 id="daterangetext" >Date Range</h1></div>
	
	<br>
	<br>
	
	<!-- Date range -->
	<div id="dateranger" >
		<div style="display:inline-block; margin-left: 5%; margin-right: 10px;">
			<input type="text" name="from_date" id="from_date" class="form-control" />
		</div>
		
		<div style="display:inline-block; margin-right: 150px;">
			<input type="text" name="to-date" id="to_date" class="form-control" />
		</div>
		
		<div style="display:inline-block;">
			<input type="button" name="filter" id="filter" class="button" value="filter" />
		</div>
		
		<div style="display:inline-block;">
			<input type="button" name="resume" id="resume" class="button" value="resume"/>
		</div>
	</div>
	
	<br>
	
	<!-- Table -->
	<div id="table" >
		<div id="table-header" style="max-width:100%; height:30px;" ><h1 id="table-interface" >Table Interface</h1></div>
		
		<br>
		<br>
		
		<table class="table table-bordered" >
			<tr>
				<th width="5%" >ID</th>
				<th width="55%" >DATE</th>
				<th width="20%" >TEMPERATURE</th>
				<th width="20%" >HUMIDITY</th>
			</tr>
			
			<!-- Open php bracket -->
			<?php while($row = mysqli_fetch_array($result)) 
			{ 
			?>
			
			<tr>
				<td><?php echo $row["ID"]; ?></td>
				<td><?php echo $row["Date"]; ?></td>
				<td><?php echo $row["Temperature"]; ?></td>
				<td><?php echo $row["Humidity"]; ?></td>
			</tr>
			
			<!-- Close php bracket -->
			<?php 
			}
			?>
			
		</table>
	</div>
	
	<script type="text/javascript" >
		// Initial chart
		updatechart();
		
		// Ajax request to php script, get array and draw chart
		function updatechart(){
			var xmlhttp = new XMLHttpRequest(), data;
			
			// Event handler : every time the readyState property of the XMLHttpRequest changes
			// https://developer.mozilla.org/en-US/docs/Web/API/XMLHttpRequest/onreadystatechange
			xmlhttp.onreadystatechange = function() {
				if( xmlhttp.readyState == 4 && xmlhttp.status == 200 ) {
					data = JSON.parse(xmlhttp.responseText);
					drawChart(data.date, data.temp, data.hum);
				}
			}
			
			// Get data from script
			xmlhttp.open("GET","get_data.php",true);
			xmlhttp.send();
		}
		
		// Chart type, width, color etc
		function drawChart(labels, tempData, humData) {
			var ctx = document.getElementById("myChart").getContext('2d');
			var myChart = new Chart(ctx, {
				type: 'line',
				data: {
					labels: labels,
					datasets: [{
						label: 'Temperature',
						data: tempData,
						backgroundColor: ['rgba(255, 26, 26, 0.2)'],
						borderColor: ['rgba(179,0,0,1)'],
						borderWidth: 1
					},
					{
						label: 'Humidity',
						data: humData,
						backgroundColor: ['rgba(0, 153, 255, 0.2)'],
						borderColor: ['rgba(0,77,128,1)'],
						borderWidth: 1
					}]
				},
				
				// Chart start at zero
				options: {
					scales: {
						yAxes: [{
							ticks: {
								beginAtZero:true
							}
						}]
					}
				}
			});
		}
		
		// Update table from script
		function updatetable() {
			$.get("get_table_data.php", function(data) {
				$("#table").html(data);
			});
		}
		
		// Update chart and table every minute
		var updateChart = setInterval(function() {
			$('#myChart').remove();
			$('#chart-container').append('<canvas id="myChart" width="70%" style="margin-top:30px;" ></canvas>');
			updatechart();
		},60000);
		
		var updateTable = setInterval( updatetable(), 60000 );
		
		// Table datepickers
		$(document).ready(function() {
			
			// Date format
			$.datepicker.setDefaults({
				dateFormat:'yy-mm-dd'
			});
			
			// From date and to date in date format
			$(function(){
				$("#from_date").datepicker();
				$("#to_date").datepicker();
			});
			
			// When the filter button is pressed
			$('#filter').click(function() {
				var from_date = $('#from_date').val();
				var to_date = $('#to_date').val();
				
				// If dates are not invalid
				if( from_date != '' && to_date != '' ) {
					
					// Get new table from script
					$.ajax({
						url: "filter.php",
						method: "POST",
						data:{from_date:from_date, to_date:to_date},
						success:function(data) {
							console.log( data );
							clearInterval(updateTable);
							$('#table').html(data);
						}
					});
					
					// Get new graph from script
					$.ajax({
						url: "filter_graph.php",
						method: "POST",
						data:{from_date:from_date, to_date:to_date},
						success:function(data) {
							var dataArrays = JSON.parse(data);
							clearInterval(updateChart);
							$('#myChart').remove();
							$('#chart-container').append('<canvas id="myChart" width="70%" style="margin-top:30px;" ></canvas>');
							drawChart(dataArrays.date, dataArrays.temp, dataArrays.hum);
						}
					});
				}
				
				// If dates are invalid 
				else {
					alert("Please select a date!");
				}
			});
			
			// When resume button is pressed
			$('#resume').click(function() {
				// Update chart and table
				updatechart();
				updatetable();
				
				// Update chart and table every minute
				updateChart = setInterval(function() {
					$('#myChart').remove();
					$('#chart-container').append('<canvas id="myChart" width="70%" style="margin-top:30px;" ></canvas>');
					updatechart();
				},60000);
				
				updateTable = setInterval( updatetable(), 60000 );
			});
		});
		
	</script>
</body>
</html>