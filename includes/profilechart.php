<?php
	$profilename = $data['trtitle'];
	$gps_track = $data['gps'];
	if ($gps_track == ''){
		$gps_track = $trailtitle;
	}
?>

<script type="text/javascript"
	src="https://www.google.com/jsapi?autoload={
        'modules':[{
			'name':'visualization',
			'version':'1',
			'packages':['corechart']
        }]
    }">
</script>

<?php
	$kml_raw = file_get_contents('http://www.trail-dog.co.uk/trails/'.$gps_track.'.kml');	
	$kml_split = explode(",",$kml_raw);
	$kml_length = count($kml_split);
	 
	function distanceCalculation($lat_1, $long_1, $lat_2, $long_2){  
		$radius = 6371000;  //approximate mean radius of the earth in meters for increased accuracy
					
		$delta_Rad_Lat = deg2rad($lat_2 - $lat_1);  //Latitude delta in radians
		$delta_Rad_Lon = deg2rad($long_2 - $long_1);  //Longitude delta in radians
		$rad_Lat1 = deg2rad($lat_1);  //Latitude 1 in radians
		$rad_Lat2 = deg2rad($lat_2);  //Latitude 2 in radians
					
		$sq_Half_Chord = sin($delta_Rad_Lat / 2) * sin($delta_Rad_Lat / 2) + cos($rad_Lat1) * cos($rad_Lat2) * sin($delta_Rad_Lon / 2) * sin($delta_Rad_Lon / 2);  //Square of half the chord length
		$ang_Dist_Rad = 2 * asin(sqrt($sq_Half_Chord));  //Angular distance in radians
		$distance = $radius * $ang_Dist_Rad;  
				
		return $distance; 
	}
	
	$kml_loop = 0;
	$kml_grab = 4;
	$long_grab = 5;
	$lat_1_set = explode (" ",$kml_split[2]);
	$lat_1 = $lat_1_set[1];
	$long_1 = $kml_split[3];
	$total_km = 0;
	
	while ($kml_loop < $kml_length){		
		$alt_split = explode (" ",$kml_split[$kml_grab]);
		$kml_alt = $alt_split[0];
		$lat_2 = $alt_split[1];
		$long_2 = $kml_split[$long_grab];
				
		if ($long_2 == ''){
			$kml_loop = $kml_length + 10;
		} else {
			$km = distanceCalculation($lat_1, $long_1, $lat_2, $long_2);
			$total_km = $total_km + round($km,1);
				
			$massive_kml = $massive_kml . "[".round($total_km).", ".round($kml_alt,1)."],";
			$kml_loop++;
			$kml_grab = $kml_grab + 2;
			$lat_1 = $lat_2;
			$long_1 = $long_2;
			$long_grab = $long_grab + 2;
		}
	}
?>

<script type="text/javascript">
	google.load("visualization", "1", {packages: ["corechart"]});
	google.setOnLoadCallback(drawChart);
				
	function drawChart() {
		var continuousData = new google.visualization.DataTable();
		continuousData.addColumn('number', 'Number');
		continuousData.addColumn('number', 'Value');
					
		continuousData.addRows([
		<?php print_r($massive_kml);?>
		]);
					
		var continuousChart = new google.visualization.LineChart(document.getElementById('altitude_profile'));
			continuousChart.draw(continuousData, {
			title: '<?php echo $profilename;?>',
			curveType: 'function',
			vAxis: {title: 'Altitude (m)', titleTextStyle: {color: '#000000'}},
			hAxis: {title: 'Distance (m)', titleTextStyle: {color: '#000000'}},
			legend: { position: 'none' },
		});
	}				
	drawChart();
</script>

<div id="altitude_profile" style="width: 100%; height: 300px;"></div>

