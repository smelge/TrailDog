<?php 
	require("../forum/SSI.php");
	include_once './includes/database_connect.php';
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Traildog 2015 Weather testpage</title>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="description" content="MTB Trail Database">
		<meta name="keywords" content="mtb,mountain,bike,cycling,cross,country,xc,downhill,dh,freeride,united,kingdom,uk,ae,forest,scotland">
		<meta name="author" content="Tavy Fraser">
		
		<!-- Bootstrap -->
		<link href="css/bootstrap.min.css" rel="stylesheet">
		<!--New css-->
		<link rel="stylesheet" type="text/css" href="css/styles.css"/>
		<link rel="stylesheet" href="./css/font-awesome.min.css">
		
		<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
			<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
			<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->
		
		<script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
		<script type="text/javascript" src="https://www.google.com/jsapi?autoload={'modules':[{'name':'visualization','version':'1.1','packages':['geochart']}]}"></script>
		<!--
		Description: Distance calculation from the latitude/longitude of 2 points
		Author: Rajesh Singh (2014)
		Website: http://AssemblySys.com
		
		If you find this script useful, you can show your
		appreciation by getting Rajesh a cup of coffee ;)
		PayPal: rajesh.singh@assemblysys.com
		
		As long as this notice (including author name and details) is included and
		UNALTERED, this code is licensed under the GNU General Public License version 3:
		http://www.gnu.org/licenses/gpl.html
		-->
	</head>
	
	<body>
		<div class="container-fluid" style="padding:0 15px;">
			<?php include "./includes/newheader.php"; ?> <!---Calls all header sections-->
			
			<?php
				$profilename = 'Test Graph - Glentress Red';
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
				$kml_raw = file_get_contents('http://www.trail-dog.co.uk/trails/glentressred.kml');					
				$kml_split = explode(",",$kml_raw);
				$kml_length = count($kml_split);
			/*	
				function distanceCalculation($point1_lat, $point1_long, $point2_lat, $point2_long, $decimals = 2) {
					// Calculate the distance in degrees
					$degrees = rad2deg(acos((sin(deg2rad($point1_lat))*sin(deg2rad($point2_lat))) + (cos(deg2rad($point1_lat))*cos(deg2rad($point2_lat))*cos(deg2rad($point1_long-$point2_long)))));
					
					// Convert the distance in degrees to the chosen unit (kilometres, miles or nautical miles)
					$distance =($degrees * 111.31944)*1000; // 1 degree = 111.31944 km, based on the average diameter of the Earth (12,735 km)
									
					return round($distance, $decimals);
				}
			*/	
				function distanceCalculation($lat_1, $long_1, $lat_2, $long_2) 
				{  
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
				$stopped = 0;
			
				echo "<table class='table-bordered'>";
					echo "<tr>";
						echo "<th style='padding:0 20px;'>Point</th>";
						echo "<th style='padding:0 20px;'>Altitude</th>";
						echo "<th style='padding:0 20px;'>Distance</th>";
						echo "<th style='padding:0 20px;'>Increase</th>";
					echo "</tr>";
				
				while ($kml_loop < $kml_length){		
					$alt_split = explode (" ",$kml_split[$kml_grab]);
					$kml_alt = $alt_split[0];
					$lat_2 = $alt_split[1];
					$long_2 = $kml_split[$long_grab];
					
					if ($long_2 == ''){
						$kml_loop = $kml_length + 10;
					} else {
						$km = distanceCalculation($lat_1, $long_1, $lat_2, $long_2);
						if ($km == 0){
							$stopped++;
						} else {
							$stopped = 0;
						}
						if ($stopped < 2){
							
							$total_km = $total_km + round($km,1);
							
							$massive_kml = $massive_kml . "[".round($total_km).", ".round($kml_alt,1)."],";
							
							echo "<tr style='text-align:center;'>";
								echo "<td>".$kml_loop."</td>";
								echo "<td>".round($kml_alt,1)."</td>";
								echo "<td>".round($total_km,2)."</td>";
								echo "<td>".round($km,2)."</td>";
							echo "</tr>";
						}
						$kml_loop++;
						$kml_grab = $kml_grab + 2;
						$lat_1 = $lat_2;
						$long_1 = $long_2;
						$long_grab = $long_grab + 2;
					}
				}
				
					echo "</tr>";
				echo "</table>";				
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
			
			
			<?php
				//get variables for all countries in database
				/*$get_country_set = mysqli_query($dblink,"SELECT * FROM maplocations");
				while ($country = mysqli_fetch_array($get_country_set)){
					switch ($country['country']){
						case 'nireland':$northern_ireland++;break;
						case 'england':$england++;break;
						case 'scotland':$scotland++;break;
						case 'wales':$wales++;break;
						case 'france':$france++;break;
						case 'switzerland':$switzerland++;break;
					}
				}
				$uk = $england + $scotland + $wales + $northern_ireland;
				echo "England: ".$england."<br>";
				echo "Scotland: ".$scotland."<br>";
				echo "Wales: ".$wales."<br>";
				echo "Northern Ireland: ".$northern_ireland."<br>";
				echo "France: ".$france."<br>";
				echo "Switzerland: ".$switzerland."<br>";
			?>
			
			<script>
				google.setOnLoadCallback(drawRegionsMap);
				
				function drawRegionsMap() {
					
					var data = google.visualization.arrayToDataTable([
					['Country', 'Trails'],
					['United Kingdom', <?php echo $uk;?>],					
					['France', <?php echo $france;?>],
					['Switzerland', <?php echo $switzerland;?>]
					]);
					
					var options = {
						backgroundColor: '#99ccff',
						colorAxis: {colors: ['#cccccc','#cccccc']},
						datalessRegionColor: '#ffffff'						
					};
					var chart = new google.visualization.GeoChart(document.getElementById('regions_div'));
					chart.draw(data, options);
				}
			</script>
			
			<div id="regions_div" style="width: 100%; height: 700px;border:2px solid black;background:lightblue;"></div>
		
		
		<?php
			//Testing MD5
		/*	
			echo "Available algorithms:<br>";
			print_r(hash_algos());
			
			echo "<br>md5 test<br><br>";
			$test_string = 'jammy bastard';
			echo "String 1: ".$test_string."<br>";
			$encoded = md5($test_string);
			echo "Encoded: ".$encoded."<br><br>";
			
			echo "Sha256 test<br><br>";
			$test_string_2 = 'jammy bastard';
			$salt = "hello-";
			$iterations = 1000;
			echo "String 2: ".$test_string_2."<br>";
			$encoded_2 = $salt . hash("sha256",$test_string_2);
			echo "Encoded: ".$encoded_2."<br><br>";*/
		?>
		
		<?php
			/*$gpxview = file_get_contents("./trails/testgpx.gpx");
			echo "GPX Raw Data<hr>";
			print_r($gpxview);
			echo "<hr>";*/
			
			/*
			$kmlview = file_get_contents("./trails/kmlconvert.kml");
			$kmlsplit = (explode("<coordinates>",$kmlview));
			$kmlinfo = $kmlsplit[0];
			$kmldata = $kmlsplit[1];
			$kmlsegments = (explode(" ",$kmldata));
			$kmltime = sizeof($kmlsegments) - 1;
			echo "Time of section: ". $kmltime ." sec<br>";
			
			//$kmlparse = str_replace(" ","<br>",$kmlsegments);
			
			echo $kmlinfo."<hr>";
			echo "KML file Structure<hr>";
			
			//altitude chart
			
			$kml_loop = 0;
			
			while ($kml_loop < $kmltime){
				$altitude_get = (explode(",",$kmlsegments[$kml_loop]));
				$altitude = round($altitude_get[2],2);
				echo "[". $kml_loop ."] ". $altitude ."<br>";
				
				if ($kml_loop == 0){
					$alt_array = $altitude;
				} else {
					$alt_array = $alt_array .",". $altitude;
				}
				//echo "[". $kml_loop ."] ". $kmlsegments[$kml_loop] ."<br>";
				$kml_loop++;
			}
			
			echo "Altitude Array:<br>";
			print_r($alt_array);
		?>
		
			<div id="mapcontainer">
				<div id="mapbox">
					<script>
						function initialize() {
							var mapOptions = {
								zoom: 13,
								center: new google.maps.LatLng(57.185913, -3.734065),
								disableDefaultUI:true,
								mapTypeId:google.maps.MapTypeId.TERRAIN
							};
							var map = new google.maps.Map(document.getElementById('mapbox'),
							mapOptions);
							
							//kml overlays
							
							var currentMap = new google.maps.KmlLayer({
								url: 'http://www.trail-dog.co.uk/traildog/trails/kmlconvert.kml',
								//suppressInfoWindows: true
							});								
							currentMap.setMap(map)
						}
						
						google.maps.event.addDomListener(window, 'load', initialize);
					</script>
				</div>
			</div>
		*/ ?>
		
		<?php	
		// Full list of weatherstation locations	
			/*$json_sites = json_decode(file_get_contents("http://datapoint.metoffice.gov.uk/public/data/val/wxfcs/all/json/sitelist?key=012840cc-4116-4d0c-afc5-e8019b0bc70e"), true, 512);
			$map_loop = 0;
		?>
		
			<div id = "mapbox" style="border:2px solid black; height:600px;">
				<script type="text/javascript">
					var locations = [
						<?php/*
							while ($map_loop <  1000){
								$locset = $json_sites['Locations']['Location'][$map_loop];
								$name = $locset['name'];
								$id = $locset['id'];
								$lat = $locset['latitude'];
								$long = $locset['longitude'];
								echo "['".$name."', ".$lat.", ".$long.", ".$id."],";
								$map_loop++;
							}
						?>
					];

					var map = new google.maps.Map(document.getElementById('mapbox'), {
						zoom: 13,
						center: new google.maps.LatLng(54.433655, -2.050622),
						mapTypeId: google.maps.MapTypeId.ROADMAP
					});

					var infowindow = new google.maps.InfoWindow();

					var marker, i;

					for (i = 0; i < locations.length; i++) {  
						marker = new google.maps.Marker({
							position: new google.maps.LatLng(locations[i][1], locations[i][2]),
							map: map
						});

						 google.maps.event.addListener(marker, 'click', (function(marker, i) {
							return function() {
								infowindow.setContent(locations[i][0]);
								infowindow.open(map, marker);
							}
						 })(marker, i));
					}
				 </script>
			</div>
			
		<?php/*
			echo "Site List<br><br>";
			//$json_sites = str_ireplace ("=>","#",$json_sites);
			$station_loop = 0;
			
			echo "<table class='table-bordered'>";
				echo "<tr>";
					echo "<th>Number</th>";
					echo "<th>Name</th>";
					echo "<th>ID</th>";
					echo "<th>Lat</th>";
					echo "<th>Long</th>";
				echo "</tr>";
				while ($station_loop < 5968){
					$locset = $json_sites['Locations']['Location'][$station_loop];
					$name = $locset['name'];
					$id = $locset['id'];
					$lat = $locset['latitude'];
					$long = $locset['longitude'];
					
					echo "<tr>";
						echo "<td>".$station_loop."</td>";
						echo "<td>".$name."</td>";
						echo "<td>".$id."</td>";
						echo "<td>".$lat."</td>";
						echo "<td>".$long."</td>";
					echo "</tr>";
					
					$station_loop++;
				}
			echo "</table>";*/
		?>
		
		</div>
	</body>
</html>