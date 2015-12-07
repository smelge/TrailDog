<?php 
	require_once ('./includes/essentials.php');
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Traildog 2015 Centre testpage</title>
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
	</head>

<body>
	<div class="container=fluid">
		<?php include "./includes/newheader.php"; ?> <!---Calls all header sections-->
		<!--<div class="row">-->
			<?php
				//$location_set = mysqli_query($dblink,"SELECT * FROM maplocations");
				$trails_ridden_set = mysqli_query($dblink,"SELECT * FROM traildata WHERE site_ridden = 1");
				//$unique entries = mysqli_query($dblink, "SELECT DISTINCT country FROM maplocations");
				$centres_on_map_set = mysqli_query($dblink, "SELECT * FROM maplocations WHERE display_on_map = 3");
				$centres_on_map = mysqli_num_rows($centres_on_map_set);
				$centre_xc = 0;
				$centre_dh = 0;
				while ($centretypes_find = mysqli_fetch_array($centres_on_map_set)){
					if ($centretypes_find['xc'] == 1){$centre_xc++;}
					if ($centretypes_find['dh'] == 1){$centre_dh++;}
				}
				$update_set = mysqli_query($dblink,"SELECT * FROM trail_update");
				$updates = mysqli_num_rows($update_set);
				$trailcentres_visited_set = mysqli_query($dblink,"SELECT DISTINCT centre FROM traildata");
				$trailcentres_visited = mysqli_num_rows($trailcentres_visited_set)-1;
				$trails_ridden = mysqli_num_rows($trails_ridden_set);
				$td_distance = 0;
				$td_climb = 0;
				$td_descend = 0;
				while ($distance_ridden = mysqli_fetch_array($trails_ridden_set)){
					$td_distance = $td_distance + $distance_ridden['trlength'];
					$td_climb = $td_climb + $distance_ridden['trclimb'];
					$td_descend = $td_descend + $distance_ridden['trdescent'];
				}
				
				$everest = 8848;
				$nevis = 1344;
				$equator = 40075000;
				$moon = 384000000;
				
			?>
			
			<h1>Statistics</h1>
			
			<h2>Trailcentre Stats</h2>
			
			Trailcentres on map: <?php echo $centres_on_map;?><br>
			XC Centres: <?php echo $centre_xc;?><br>
			DH Centres: <?php echo $centre_dh;?><br>
			Trail Updates in effect: <?php echo $updates;?><br>
				
			<h2>Site Stats</h2>
			
			Trailcentres visited: <?php echo $trailcentres_visited;?><br>
			Trailsections ridden: <?php echo $trails_ridden;?><br>
			Total Distance: <?php echo round($td_distance/1000,2);?>km     (<?php echo round($td_distance/$equator,4);?> Times around the equator)     (<?php echo round($td_distance/$moon,4);?> of the way to the Moon)<br>
			Total Climb: <?php echo $td_climb;?>m     (<?php echo round($td_climb/$everest,1);?> Everests)     (<?php echo round($td_climb/$nevis,1);?> Ben Nevises)<br>
				
			Total Descent: <?php echo $td_descend;?>m     (<?php echo round($td_descend/$everest,1);?> Everests)     (<?php echo round($td_descend/$nevis,1);?> Ben Nevises)<br>
		<!--	
			<h2>User Stats</h2>
			
			Total Users:<br>
			GPS Uploads:<br>
			Total Distance Ridden:<br>
			Total Climb:<br>
			Total Descent:<br>
			Updates Made:<br>
			Videos added:<br>
			Reviews left:<br>
			Ratings given:<br>
			Rides Organised:<br>
		-->
		<!--</div>-->
		
		<center><?php include "./includes/newfooter.php"; ?></center> <!--- Calls footer stuff-->
	</div>
</body>
</html>