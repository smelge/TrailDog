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
			$trailident = filter_input(INPUT_GET, 'trail', FILTER_SANITIZE_SPECIAL_CHARS);
			$sec = filter_input(INPUT_GET, 'sec', FILTER_SANITIZE_SPECIAL_CHARS);
			
			$default_set = mysqli_query($dblink,"SELECT * FROM traildata WHERE centre = 'default'");
			$default_array = mysqli_fetch_array($default_set);
			$default = $default_array['tryoutube'];
			
			$centrefind = mysqli_query($dblink,"SELECT * FROM maplocations WHERE link ='$trailcentre'");
			$centreset = mysqli_fetch_array($centrefind);
			$centrename = $centreset['name'];
			
			$trail_setup = mysqli_query($dblink,"SELECT * FROM trails WHERE trailcentre = '$trailcentre' AND trailcode = '$trailident'");
			$trail = mysqli_fetch_array($trail_setup);
			
			$section_data_setup = mysqli_query($dblink,"SELECT * FROM traildata WHERE trcode = '$sec'");
			$data = mysqli_fetch_array($section_data_setup);
			
			$update_set = mysqli_query($dblink,"SELECT * FROM trail_update WHERE centre = '$trailcentre'");			
			
			$centreident = $centreset['name'];
			
			if ($context['user']['is_admin']){
				//Nothing added to viewcount
			} else {
				$viewupdate = mysqli_query($dblink,"UPDATE traildata SET viewcount = viewcount + 1 WHERE trcode = '$sec'");
			}
		?>
		<title>Traildog: <?php echo $centrename ." - ". $data['trtitle'];?></title>
	</head>

	<body>
		<div class="container-fluid">
			<?php include "./includes/newheader.php"; ?> <!---Calls all header sections-->
				<div class="row">
					<div class="col-sm-12">
						<?php
							if ($sec == ''){
						?>
							<div class="row">
								<div class="col-sm-3" id="tr-sec-box">
									<?php include ('./includes/section_list.php');?>
								</div>
								<div class="col-sm-9" style="padding-left:0;">
									<div id="tr-map" class="st-box-style">
										<script>
											function initialize() {
												var mapOptions = {
													zoom: 13,
													center: new google.maps.LatLng(<?php echo $centreset['location'];?>),
													disableDefaultUI:true,
													mapTypeId:google.maps.MapTypeId.TERRAIN
												};
												var map = new google.maps.Map(document.getElementById('tr-map'),
													mapOptions);
													
												
											}
												
											google.maps.event.addDomListener(window, 'load', initialize);
										</script>
									</div>
								</div>
								<script>
									$("#tr-map").height($("#tr-sec").outerHeight());
								</script>
							</div>
							<div class="row">
								<div class="col-sm-12">
									<div id="tr-profile" class="st-box-style" style="line-height:200px;background:#cccccc;text-align:center;">
										Trail Profile Coming Soon
									</div>
								</div>
							</div>
						<?php
							} else { //if sec returns a trail name
							?>
							<div class="row">
								<!-- This section is only for trail alerts -->
								
								<?php
									$alert_show = 0;
									while ($update = mysqli_fetch_array($update_set)){
										$section_codes = $update['section_codes'];
										
										if (strpos($section_codes,$sec) !== false){
											if ($alert_show == 0){
												echo '<div class="col-sm-12" style="margin-bottom:-10px;">';
													echo '<div class="alert alert-danger alert-dismissible" role="alert" style="border:2px solid;">';
														echo '<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>';
														if ($update['type'] == 'closure'){
															if ($update['date_effective_to'] != '0000-00-00'){
																echo '<strong>This trail section is closed until: '. date_format((date_create($update['date_effective_to'])),'d/m/Y') .'</strong>';
															} else {
																echo '<strong>This trail section is closed. A Reopening date has not yet been released.</strong>';
															}
														} else {
															echo "This trail is under maintainance. Please ride with caution.";
														}		
													echo '</div>';
												echo '</div>';
												$alert_show = 1;
											}
										}
									}									
								?>
								
								<!-- End of trail Alerts -->
								
								<div class="col-sm-3" id="tr-sec-box">
									<?php include('./includes/section_list.php');?>
								</div>
								<div class="col-sm-9" style="padding-left:0;">
									<div id="tr-map-overlay" style="text-align:center;">
										<?php
											$startper = round($prevper / $totallong * 100,1);
											$sectionper = round($data['trlength'] / $totallong * 100,1);
											$endper = $startper + $sectionper;
										?>
										<ul style="list-style:none;margin-left:-30px;">
											<li style="display:inline-block;margin:0 10px;">Length<hr style="border:1px solid black;margin:3px;"> <?php echo $data['trlength'];?>m</li>
											<li style="display:inline-block;margin:0 10px;">Climb<hr style="border:1px solid black;margin:3px;"> <?php echo $data['trclimb'];?>m</li>
											<li style="display:inline-block;margin:0 10px;">Descent<hr style="border:1px solid black;margin:3px;"> <?php echo $data['trdescent'];?>m</li>
											<li style="display:inline-block;margin:0 10px;">Trail Complete at Start<hr style="border:1px solid black;margin:3px;"><?php echo $startper;?>%</li>
											<li style="display:inline-block;margin:0 10px;">Trail complete at end<hr style="border:1px solid black;margin:3px;"><?php echo $endper;?>%</li>
											<li style="display:inline-block;margin:0 10px;">Percentage of total trail length<hr style="border:1px solid black;margin:3px;"><?php echo $sectionper;?>%</li>
										</ul>
										<?php
											if ($data['site_ridden'] == 0 && $data['users_ridden'] == 0){
												echo '<hr style="border:1px solid black;margin:0px;">';
												echo '<span style="font: normal bold 9px/1em Verdana, Geneva, sans-serif;">This GPS track and data is estimated. Users can upload their gpx files below.</span>';
											}
										?>
									</div>
									<div id="tr-map" class="st-box-style"> <!--Mapping script and KML -->
										<script>
											function initialize() {
												var mapOptions = {
													zoom: 13,
													center: new google.maps.LatLng(<?php echo $centreset['location'];?>),
													disableDefaultUI:true,
													mapTypeId:google.maps.MapTypeId.TERRAIN
												};
												var map = new google.maps.Map(document.getElementById('tr-map'),
												mapOptions);
												
												//kml overlays
												
												var kmlLayer = new google.maps.KmlLayer({
													url: 'http://www.trail-dog.co.uk/trails/<?php echo $data['gps'];?>.kml'
												});								
												kmlLayer.setMap(map)
											}
											
											google.maps.event.addDomListener(window, 'load', initialize);
										</script>
									</div>
								</div>
								<script>
									$("#tr-map").height($("#tr-sec").outerHeight());
								</script>
							</div>
							<div class="row">
								<div class="col-sm-12" id="tr-sec-box">
									<?php include('./includes/section_nav.php');?>
								</div>
							</div>
							
							<?php //linking trails
								/*if ($sec['link_trails'] != ''){
									echo $sec['link_trails'];
								} */
							?>
							
							<div class="row" style="margin-bottom:10px; padding:0 15px;">
								<div class="col-sm-12 tr-sec">
									<div role="tabpanel">
										
										<!-- Nav tabs -->
										<ul class="nav nav-tabs" role="tablist">
											<li role="presentation" class="active"><a href="#altitude" class="tab-head" aria-controls="altitude" role="tab" data-toggle="tab">Altitude Profile</a></li>
											<li role="presentation"><a href="#features" class="tab-head" aria-controls="features" role="tab" data-toggle="tab">Trail Features</a></li>
											<li role="presentation"><a href="#videos" class="tab-head" aria-controls="videos" role="tab" data-toggle="tab">User Videos</a></li>
											<li role="presentation"><a href="#leaderboard" class="tab-head" aria-controls="leaderboard" role="tab" data-toggle="tab">Leaderboard</a></li>
											<li role="presentation"><a href="#gps" class="tab-head" aria-controls="gps" role="tab" data-toggle="tab">User GPS</a></li>
											<li role="presentation"><a href="#rating" class="tab-head" aria-controls="rating" role="tab" data-toggle="tab">Ratings</a></li>
											<li role="presentation"><a href="#report" class="tab-head" aria-controls="report" role="tab" data-toggle="tab">Report Trail Issue</a></li>
										</ul>
										
										<!-- Tab panes -->
										<div class="tab-content">
											<div role="tabpanel" class="tab-pane fade in active" id="altitude">
												<!--Altitude Profile[?] - Modal-->
												<?php include ('./includes/profilechart.php');?>
											</div>
											<div role="tabpanel" class="tab-pane fade" id="features">
												<ul>
													<li>Features on this trail
														<ul>
															<li>from Database</li>
														</ul>
													</li>
													<li>Edit Features
														<ul>
															<li>Rock Step</li>
															<li>Tabletop</li>
															<li>Double</li>
															<li>Rock Garden</li>
															<li>Cattlegrid</li>
															<li>Loose surface</li>
															<li>Natural Trail</li>
															<li>Step-up</li>
															<li>Step-down</li>
															<li>Roots</li>
															<li>Water Crossing</li>
															<li>Public Road</li>
															<li>Shared path</li>
															<li>Timber Trail (gripped)</li>
															<li>Timber Trail (ungripped)</li>
															<li>Skinny</li>
															<li>Drop</li>
															<li>Steep Descent</li>
															<li>Steep Ascent</li>
															<li>Fireroad</li>
															<li>Singletrack</li>
														</ul>
													</li>
												</ul>
											</div>
											<div role="tabpanel" class="tab-pane fade" id="videos">
												<?php include ('./includes/user_video.php');?>
											</div>
											<div role="tabpanel" class="tab-pane fade" id="leaderboard">Best Times from GPS</div>
											<div role="tabpanel" class="tab-pane fade" id="gps">GPS Uploader</div>
											<div role="tabpanel" class="tab-pane fade" id="rating">Trail Rating ['section_rating']</div>
											<div role="tabpanel" class="tab-pane fade" id="report">
												<ul>
													<li>Report a new Problem
														<ul>
															<li>User_id</li>
															<li>Section</li>
															<li>Type of problem
																<ul>
																	<li>Surface damage</li>
																	<li>Fallen tree</li>
																	<li>Ice or snow</li>
																	<li>Trail Blocked</li>
																	<li>Repairs being done</li>
																	<li>Trail Closed</li>
																	<li>Potholes</li>
																	<li>Flooding</li>
																	<li>Severe Ruts</li>
																</ul>
															</li>
															<li>Reportee Comments</li>
															<li>Date Reported</li>
															<li>Current Status</li>
														</ul>
													<li>Update Existing Problem
														<ul>
															<li>Select problem from list
																<ul>
																	<li>User_id</li>
																	<li>Report_id</li>
																	<li>Update</li>
																	<li>Editors comment</li>
																	<li>Date Updated</li>
																</ul>
															</li>
														</ul>
													</li>
												</ul>	
											</div>
										</div>										
									</div>						
								</div>
							</div>
						</div>
							
								<?php
							}
						?>
					</div>
				</div>
			<center><?php include "./includes/newfooter.php"; ?></center>
		</div>
	</body>
</html>