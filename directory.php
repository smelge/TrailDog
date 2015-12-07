<?php 
	require_once ('./includes/essentials.php');
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Traildog Trail Directory</title>
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
		<?php
			$randomtrail = 7;
			$randomvideo = 8;
			
			$rnd_trail_set = mysqli_query($dblink,"SELECT * FROM maplocations WHERE id = $randomtrail"); //assume $randomtrail has been checked to exist
			$rnd_trail = mysqli_fetch_array($rnd_trail_set);
			
			$rnd_vid_set = mysqli_query($dblink,"SELECT * FROM traildata WHERE id = $randomvideo");
			$rnd_vid = mysqli_fetch_array($rnd_vid_set);
			
			$country = filter_input(INPUT_GET, 'c', FILTER_SANITIZE_SPECIAL_CHARS);
			
			switch ($country){
				case 'eng':
					$zoom = 6;
					$coord = "52.8382004,-2.3278149";
					break;
				case 'nire':
					$zoom = 8;
					$coord = "54.6697563,-6.4571856";
					break;
				case 'scot':
					$zoom = 7;
					$coord = "56.7533771,-4.2818927";
					break;
				case 'wal':
					$zoom = 8;
					$coord = "52.4316245,-3.8149738";
					break;
				case 'yurp':
					$zoom = 5;
					$coord = "44.8218411,4.781478";
					break;
				default:
					$zoom = 6;
					$coord = "54.4530377,-2.833186";
					break;
			}
		?>
		
		<script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
	</head>
	
	<body>
		<div class="container-fluid">
			<?php include "./includes/newheader.php"; ?> <!---Calls all header sections-->
			<div class="row">	
				<div class="col-sm-12">
					<?php
						$filter = filter_input(INPUT_GET, 'filter', FILTER_SANITIZE_SPECIAL_CHARS);
					?>
					<div class="col-sm-12" style="margin-bottom:10px;"> 
						<span style="margin-right:10px;">Filter By</span>
						<a href="?c=<?php echo $country;?>" class="btn btn-primary" role="button">All Trails</a>
						<a href="?c=<?php echo $country;?>&filter=xc" class="btn btn-primary" role="button">Cross-Country</a>
						<a href="?c=<?php echo $country;?>&filter=dh" class="btn btn-primary" role="button">Downhill</a>
						<a href="?c=<?php echo $country;?>&filter=fr" class="btn btn-primary" role="button">Freeride</a>
						<a href="?c=<?php echo $country;?>&filter=dtrails" class="btn btn-info" disabled="disabled" style="opacity:0.5;" role="button">Disabled Accessible Trails</a>
						<a href="?c=<?php echo $country;?>&filter=uplift" class="btn btn-primary" role="button">Uplifts</a>
						<a href="?c=<?php echo $country;?>&filter=skills" class="btn btn-primary" role="button">Skills</a>
						<br>
						<form style="margin-top:5px;margin-right:20px;display:inline-block;" action="./includes/directorydrop.php">
							Or Select from list:
							<select name="directorydropper">
								<?php
									$set_centrelist = mysqli_query($dblink,"SELECT * FROM maplocations WHERE display_on_map = 3 ORDER BY name ASC");
									while ($centrelist = mysqli_fetch_array($set_centrelist)){
										echo '<option value="'. $centrelist['link'] .'">';
											echo '<a href="./trailhead.php?centre='. $centrelist['link'] .'">'. $centrelist['name'] .'</a>';
										echo '</option>';
									}
								?>
							</select>
							<input type="submit" value="Go!">
						</form>
						<?php
							if ($context['user']['is_admin']){
								$set_centrelist = mysqli_query($dblink,"SELECT * FROM maplocations WHERE display_on_map = 1 ORDER BY name ASC");
								//$set_centrelist = mysqli_query($dblink,"SELECT * FROM maplocations WHERE weather = '' AND display_on_map = 3 ORDER BY name ASC");
								$no_unlisted = mysqli_num_rows($set_centrelist);?>
								<form style="margin-top:5px; display:inline-block;" action="./includes/directorydrop.php?hidden=yes">
									<?php echo $no_unlisted;?> Unlisted Trails:
									<select name="directorydropper">
										<?php
											
											while ($centrelist = mysqli_fetch_array($set_centrelist)){
												echo '<option value="'. $centrelist['link'] .'">';
												echo '<a href="./trailhead.php?centre='. $centrelist['link'] .'">'. $centrelist['name'] .'</a>';
												echo '</option>';
											}
										?>
									</select>
									<input type="submit" value="Go!">
								</form><?php 
							} 
						?>
					</div>
					<div id ="mapbox" style="border:2px solid black; height:600px;">
						<?php
							$maploop = mysqli_query($dblink, "SELECT * FROM maplocations WHERE display_on_map = 3");
						?>
						<script type="text/javascript">
							
							var infoStyle = '<div class="infoboxcontainer">'+
							'<div class="trailtypecontainer">'+
							'<div class="trailtype" style="background:#6699ff;color:black;">'+
							'XC'+
							'</div>'+
							'<div class="trailtype" style="background:#cc6666;color:black;">'+
							'FR'+
							'</div>'+
							'<div class="trailtype" style="background:#484848;color:white;">'+
							'DH'+
							'</div>'+
							'</div>'+
							'<div class="trailnamecontainer">'+
							'<?php print $currentName;?>'+
							'</div>'+
							'</div>';
							
							var locations = [
							<?php while ($mfind = mysqli_fetch_array($maploop)){ 
								
								if ($filter != ''){	
									if ($mfind[$filter] == 1){
										$currentName = str_ireplace("'","\'",$mfind['name']);
										?>
										['<a href="./trailhead.php?centre=<?php echo $mfind['link'];?>">' + 
										'<div class="infoboxcontainer">'+
										'<div class="trailtypecontainer">'+
										'<?php if ($mfind['xc'] == 1){echo '<div class="trailtype" style="background:#6699ff;color:black;">XC</div>';}?>'+
										'<?php if ($mfind['fr'] == 1){echo '<div class="trailtype" style="background:#cc6666;color:black;">FR</div>';}?>'+
										'<?php if ($mfind['dh'] == 1){echo '<div class="trailtype" style="background:#484848;color:white;">DH</div>';}?>'+
										'</div>'+
										'<div class="trailnamecontainer">'+
										'<?php print $currentName;?>'+
										'</div>'+
										'</div>'+ 
										'</a>',<?php echo $mfind['location'];?>],
										<?php
									}
								} else {
									$currentName = str_ireplace("'","\'",$mfind['name']);
									?>
									['<a href="./trailhead.php?centre=<?php echo $mfind['link'];?>">' + 
									'<div class="infoboxcontainer">'+
									'<div class="trailtypecontainer">'+
									'<?php if ($mfind['xc'] == 1){echo '<div class="trailtype" style="background:#6699ff;color:black;">XC</div>';}?>'+
									'<?php if ($mfind['fr'] == 1){echo '<div class="trailtype" style="background:#cc6666;color:black;">FR</div>';}?>'+
									'<?php if ($mfind['dh'] == 1){echo '<div class="trailtype" style="background:#484848;color:white;">DH</div>';}?>'+
									'</div>'+
									'<div class="trailnamecontainer">'+
									'<?php print $currentName;?>'+
									'</div>'+
									'</div>'+ 
									'</a>',<?php echo $mfind['location'];?>],
									<?php
								}								
							} ?>
							]
							
							var map = new google.maps.Map(document.getElementById('mapbox'), {
								zoom: <?php echo $zoom;?>,
								center: new google.maps.LatLng(<?php echo $coord;?>),
								mapTypeId: google.maps.MapTypeId.TERRAIN
							});
							
							
							var infowindow = new google.maps.InfoWindow();
							
							var marker, i;
							
							for (i = 0; i < locations.length; i++) {  
								marker = new google.maps.Marker({
									position: new google.maps.LatLng(locations[i][1], locations[i][2]),
									icon: './assets/icons/maps/cycling.png',
									map: map
								});
								
								google.maps.event.addListener(marker, 'click', (function(marker, i) {
									return function() {
										infowindow.setContent(locations[i][0]);
										infowindow.open(map, marker);
									}
								})(marker, i));
							}
							google.maps.event.addDomListener(window, 'load', initialize);
						</script>
					</div>
				</div>
			</div>
			<center><?php include "./includes/newfooter.php"; ?></center>
		</div>		
	</body>
</html>













































