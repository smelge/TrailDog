<?php 
	require_once ('./includes/essentials.php');
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="description" content="MTB Trail Database">
		<meta name="keywords" content="mtb,mountain,bike,cycling,cross,country,xc,downhill,dh,freeride,united,kingdom,uk,ae,forest,scotland">
		<meta name="author" content="Tavy Fraser">
					
		<!-- Bootstrap -->
		<link href="css/bootstrap.min.css" rel="stylesheet">
		<!--New css-->
		<link rel="stylesheet" type="text/css" href="css/styles.css"/>
		<link rel="icon" href="./assets/tdicon.png" type="image/x-icon">
		<link rel="stylesheet" href="./css/font-awesome.min.css">
		
		<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
			<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
			<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->
		
		<script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>

		<?php
			$trailcentre = filter_input(INPUT_GET, 'centre', FILTER_SANITIZE_SPECIAL_CHARS);
			$trailtitle = filter_input(INPUT_GET, 'trail', FILTER_SANITIZE_SPECIAL_CHARS);	
			
			$centreset = mysqli_query($dblink,"SELECT * FROM maplocations WHERE link = '$trailcentre'");
			$centre = mysqli_fetch_array($centreset);
			
			$kmlroutes = $centre['kmlname'];
			$kmlsplit = (explode(";",$kmlroutes));
			$kmlstring = count($kmlsplit);
			$kmlloop = 1;
			$kmlinput = '"'. $kmlsplit[0];
			
			while ($kmlloop < $kmlstring - 1){ //sets up array to pass in to javascript
				$kmlinput = $kmlinput .'","'. $kmlsplit[$kmlloop] .'"';
				$kmlloop++;
			}
			
			$sectotal = mysqli_query($dblink,"SELECT * FROM traildata WHERE centre = '$trailcentre' ORDER BY id");
			
			if ($context['user']['is_admin']){
				//Nothing added to viewcount
			} else {
				if ($trailtitle != ''){
					$viewupdate = mysqli_query($dblink,"UPDATE trails SET viewcount = viewcount + 1 WHERE trailcode = '$trailtitle'");
				} else {
					$viewupdate = mysqli_query($dblink,"UPDATE maplocations SET pageviews = pageviews + 1 WHERE link = '$trailcentre'");
				}
			}
			
			//Weather Loader
			
			if ($centre['weather'] != ''){
				$json_array = json_decode(file_get_contents("http://datapoint.metoffice.gov.uk/public/data/val/wxfcs/all/json/354908?res=3hourly&key=012840cc-4116-4d0c-afc5-e8019b0bc70e"), true);
				$json_daily = json_decode(file_get_contents("http://datapoint.metoffice.gov.uk/public/data/val/wxfcs/all/json/". $centre['weather'] ."?res=daily&key=012840cc-4116-4d0c-afc5-e8019b0bc70e"), true);
			}
		?>
		
		<title>Traildog: <?php echo $centre['name'];?></title>
		
		<script> 
		//menubar slider toggle
			$(document).ready(function(){
				$("#locheadup").show();
				$("#locheaddown").hide();
				$("#lochead").click(function(){
					$("#locdrop").slideToggle("slow");
					$("#locheadup").toggle();
					$("#locheaddown").toggle();
				});
			});
			
			$(document).ready(function(){
				$("#dirheadup").hide();
				$("#dirheaddown").show();
				$("#dirhead").click(function(){
					$("#dirdrop").slideToggle("slow");
					$("#dirheadup").toggle();
					$("#dirheaddown").toggle();
					calcRoute();
				});
			});	
			
			$(document).ready(function(){
				$("#upheadup").hide();
				$("#upheaddown").show();
				$("#uphead").click(function(){
					$("#updrop").slideToggle("slow");
					$("#upheadup").toggle();
					$("#upheaddown").toggle();
				});
			});
		</script>
<?php 
	if ($trailtitle == ''){?>
		<script>
			$(document).ready(function(){
				$("#trailheadup").hide();
				$("#trailheaddown").show();
				$("#trailhead").click(function(){
					$("#traildrop").slideToggle("slow");
					$("#trailheadup").toggle();
					$("#trailheaddown").toggle();
				});
			});
		</script>
	<?php } else {?>
		<script>
			$(document).ready(function(){
				$("#trailheadup").show();
				$("#trailheaddown").hide();
				$("#trailhead").click(function(){
					$("#traildrop").slideToggle("slow");
					$("#trailheadup").toggle();
					$("#trailheaddown").toggle();
				});
			});
		</script>
	<?php }	
?>

		<script>
			function showForecast(){
				//Open a lightbox
				forewin = window.open("","Daily Forecast","width=400,height=200");
				forewin.document.write("Forecast breakdwon for day selected");
			}
			
			$(document.ready(function(){
				$("#weather-1").hide("#weather-2");
			});
		</script>
	</head>

	<body>
		<div class="container-fluid">
			<?php include "./includes/newheader.php";  //Calls all header sections
				if ($centre['name'] == ''){
					header('Location: ./directory.php');		
					exit();
				}
				if ($context['user']['is_admin']){
			
					echo '<div class="alert alert-danger alert-dismissible" role="alert" style="border:2px solid;margin-bottom:10px;">';
						if ($centre['updating'] != 1){
							echo '<a href="./includes/edit.php?centre='. $centre['link'] .'&action=update1" style="margin:0 5px;" class="btn btn-primary" role="button">Mark centre as UPDATING</a>';
						} else {
							echo '<a href="./includes/edit.php?centre='. $centre['link'] .'&action=update0" style="margin:0 5px;" class="btn btn-primary" role="button">Stop UPDATING centre</a>';
						}
						if ($centre['display_on_map'] != 3){
							echo '<a href="./includes/edit.php?centre='. $centre['link'] .'&action=display1" style="margin:0 5px;" class="btn btn-primary" role="button">Display centre on site</a>';
						} else {
							echo '<a href="./includes/edit.php?centre='. $centre['link'] .'&action=display0" style="margin:0 5px;" class="btn btn-primary" role="button">Remove centre from site</a>';
						}
					echo '</div>';
				
				}
				
				
				if ($centre['updating'] != 1){ //Check if trailcentre is being updated. If not, display as normal.
				?>
					<div class="row">
						<div class="col-xs-3 setup" style="padding-left:15px;">
							<?php include ('./includes/trailhead_sidebar.php');?>
						</div>
						
						<div class="col-xs-9" style="padding:0 15px 0 0;"> <!-- Map stuff -->
							<div id="mapcontainer">
								
								<?php
									if ($trailtitle == ''){ // Show only the trailcentre name if no trails selected
										echo '<div id="mapoverlay">';
											echo $centre['name'];
										echo '</div>';
									} else {
										// Import from mapoverlay.php
										include ("./includes/mapoverlay.php");
									}
								?>
								<div id="mapbox">
									<script>
										var directionsDisplay;
										var directionsService = new google.maps.DirectionsService();
										
										function initialize() {
											directionsDisplay = new google.maps.DirectionsRenderer();
											var mapOptions = {
												zoom: 13,
												center: new google.maps.LatLng(<?php echo $centre['location'];?>),
												disableDefaultUI:true,
												mapTypeId:google.maps.MapTypeId.TERRAIN
											};
											var map = new google.maps.Map(document.getElementById('mapbox'),
											mapOptions);
											
											var homemarker=new google.maps.Marker({
												position:new google.maps.LatLng(<?php echo $centre['location'];?>),
												icon: './assets/icons/maps/home.png',
											});
											
											homemarker.setMap(map);
											
											//Google Directions setup
											directionsDisplay.setMap(map);
											directionsDisplay.setPanel(document.getElementById('dirdrop'));
											
											//kml overlays
											
											var currentMap = new google.maps.KmlLayer({
												url: 'http://www.trail-dog.co.uk/trails/<?php echo $trailtitle;?>.kml',
												suppressInfoWindows: true
											});								
											currentMap.setMap(map)
										}
										
										//set directions
										function calcRoute() {
											var start = new google.maps.LatLng(<?php echo $homecord;?>);
											var end = new google.maps.LatLng(<?php echo $centre['location'];?>);
											var request = {
												origin: start,
												destination: end,
												travelMode: google.maps.TravelMode.DRIVING
											};
											directionsService.route(request, function(response, status) {
												if (status == google.maps.DirectionsStatus.OK) {
													directionsDisplay.setDirections(response);
												}
											});
										}
										
										google.maps.event.addDomListener(window, 'load', initialize);
									</script>
								</div>
								<!--
								Map<br>
									GPX overlays<br>
									Google Directions (on load) -->
							</div>
						</div>
					</div>
					<?php
						if ($centre['weather'] != ''){?>
							<div class="row" style="padding:0 15px; margin-top:10px;">								
								<div class="col-xs-12 padding">
									<?php include ('./includes/weather_widget.php');?>
								</div>
							</div>
							<?php
						} else {
							if ($context['user']['is_admin']){?>
								<button type="button" style="margin:5px auto;" class="btn btn-primary btn-block" data-toggle="modal" data-target="#weatherModal">
								Add Weatherstation Code
								</button>
								<!-- Modal -->
								<div class="modal fade" id="weatherModal" tabindex="-1" role="dialog" aria-labelledby="weatherModalLabel" aria-hidden="true">
									<div class="modal-dialog">
										<div class="modal-content">
											<form action="./includes/edit.php?centre=<?php echo $centre['link'];?>&action=weather" method="post">
												<div class="modal-header">
													<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
													<h4 class="modal-title" id="weatherModalLabel">Add a weather station for <?php echo $centre['name'];?></h4>
												</div>
												<div class="modal-body">
													<input type="number" name="weatherstation" class="form-control" placeholder="Weatherstation code (normally 6 digits)">
												</div>
												<div class="modal-footer">
													<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
													<button type="submit" value="submit" class="btn btn-primary">Save changes</button>
												</div>
											</form>
										</div>
									</div>
								</div><?php
							}
						}
					?>
					<div class="row" style="margin-top:6px;">	
						<div class="col-xs-3">
							<div id="facilities">
								<div id="facility-list"> <!-- Facilities Section -->
									<div id="facility-head">
										<?php echo $centre['name'];?> Facilities
									</div>							
									
									<?php if ($centre['skills'] == 1){echo "<div class='facility_seg'>Skills Area!</div>";}?>
									<?php if ($centre['food'] == 1){echo "<div class='facility_seg'>Food!</div>";}?>
									<?php 
										if ($centre['parking'] == 1){
											echo "<div class='facility_seg'>";
												echo "Parking:<br>";
												if ($centre['parking_charge'] == 'free'){	
													echo "Parking is free";
												} elseif ($centre['parking_charge'] == ''){
													echo "No parking fees added";
												} else {
													$park_hours_array = (explode(";",$centre['parking_charge']));
													$parking_range = count($park_hours_array) - 1;
													$parkingloop = 0;
													
													while ($parkingloop < $parking_range){
														$hours = (explode(",",$park_hours_array[$parkingloop]));
														echo "Up to ". $hours[1] ." hours: &pound;". $hours[0] ."<br>";
														$parkingloop++;
													} 
												}
											echo "</div>";
										}
									?>
									<?php if ($centre['toilet'] == 1){echo "<div class='facility_seg'>Toilets!</div>";}?>
									<?php if ($centre['shower'] == 1){echo "<div class='facility_seg'>Showers!</div>";}?>
									<?php if ($centre['shop'] == 1){echo "<div class='facility_seg'>Shop!</div>";}?>
									<?php 
										if ($centre['uplift'] == 1){
											if ($centre['uplift_logo'] == ''){
												if ($centre['web_uplift'] != ''){
													echo "<div class='facility_seg'><a href='". $centre['web_uplift'] ."' style='color:black;'>". $centre['name'] ." Uplift</a></div>";
												} else {
													echo "<div class='facility_seg'>". $centre['name'] ." Uplift</div>";
												}
											} else {
												echo "<div class='facility_seg' style='padding:0;'><a href='". $centre['web_uplift'] ."'><img style='width:100%;' src='./assets/uplifts/". $centre['uplift_logo'] .".jpg' alt='". $centre['name'] ." Uplift'/></a></div>";
											}
										}
									?>
								</div>
							</div>
						</div>
						<div class="col-xs-9" style="padding-left:0">
							<div id="interactive" style="text-align:center;color:black;background:#cccccc;">	
								<?php
									//if ($centre['gps'] != ''){
										include ('./includes/profilechart.php');
									//}
								?>
							<!--	
								<ul>
									<li>interactive
										<ul>
											<li>Ride Organiser
												<ul>
													<li>Upcoming Rides</li>
													<li>Latest from the forum</li>
													<li>Forum</li>
												</ul>
											</li>
											<li>ratings</li>
											<li>leaderboards</li>
											<li>User videos</li>
											<li>Comments</li>
											<li>Feedback</li>
											<li>User photos</li>
											<li>Report an issue</li>
										</ul>
									</li>
								</ul>
							-->
							
							</div>
						</div>
					</div>
				<?php
					} else { //Trailcentre is being updated, display this ?>
						<div class="row">
							<div class="col-sm-12">
								<div id="update-overlay">
									Centre is being updated. Please check back shortly.
								</div>
								<img src="./assets/updating.jpg" alt="Updating image" class="img-responsive"  style="width:100%;border:2px solid black;"/>
							</div>
						</div>
				<?php
					}				
			?>
			<center><?php include "./includes/newfooter.php"; ?></center>
		</div>
	</body>
</html>