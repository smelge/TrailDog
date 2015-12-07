<?php 
	require_once ('./includes/essentials.php');
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Traildog Works In Progress</title>
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="description" content="MTB Trail Database Testing Area">
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
	<div class="container-fluid">
		<?php include "./includes/newheader.php"; ?> <!---Calls all header sections-->
		<div class="row" style="padding:0 15px;">
			<div class="col-sm-12 st-box-style" style="margin-bottom:10px;">
				<h3>Currently Playing With</h3>
			</div>
		</div>
		<div class="row" style="padding:0 15px; margin-bottom:5px;">
			<div class="col-sm-12 st-box-style">
				Splitting uploaded KML Files into individual trackpoints to get overall time taken on trail, 
				then rendering as altitude profile and calculating distance for inclusion in a leaderboard 
				and to get essential trailstats to feed into the database.<br><br>
				<a class="btn btn-default" href="./weatherfeed.php">Displaying all data in table</a>
				<a class="btn btn-default" href="./trailinfo.php?centre=innerleithen&trail=innerleithenred&sec=endurotrack">On Page</a>
				<hr>
				Issues: <br>
				Distance calculations longer than predicted length<br>
				Occasional zeroed data from KML<br>
				Current speeds in excess of 100mph occasionally recorded
				<hr>
				Ideas:<br>
				Could be attributed to poor signal on GPS unit causing locational discrepancies. 
				High speeds and extra distance could be caused by position jumping from one location to another. 
				Possibly discard excessive altitude and speed trackpoints and average between the next reliable one.
			</div>
		</div>
		
		<div class="row" style="padding:0 15px; margin-bottom:5px;">
			<div class="col-sm-12 st-box-style">
				Adding user interactivity to trailinfo.php and trailhead.php to allow users to upload their own GPS tracks, videos and reviews.<br><br>
				<a class="btn btn-default" href="./trailinfo.php?centre=innerleithen&trail=innerleithenred&sec=endurotrack">On Page</a>
				<hr>
				Issues: <br>
				Need altitude profile and KML data gathering to work first<br>
				GPS upload needs to convert to KML from .fit or .gpx files<br>
				<hr>
				Ideas:<br>
				Video addition, ratings, comments and reporting functions can still be added for the time being.<br>
				Altitude profile can have distance removed from h-axis until distance fixed.<br>
				Leaderboard and GPS upload can be removed until systems figured out.
			</div>
		</div>
		
		<div class="row" style="padding:0 15px;">
			<div class="col-sm-12 st-box-style">
				<h3>Stuff I'm getting to</h3>
			</div>
		</div>
		<div class="row" style="margin:10px 0;">
			<div class="col-sm-12 st-box-style">
				<ul>
					<li>Redo main pages with includes for functionality parts</li>
					<li>Improve styling on main pages</li>
					<li>Google maps Directions Service not working currently</li>
					<li>User trail Updates</li>
					<li>User ability to add trailcentres</li>
					<li>User ability to add info to trailcentres</li>
					<li>Improve Statistics page</li>
					<li>Improve featured trailcentre section</li>
					<li>AJAX slider in header displaying latest news (new fastest times, etc.)</li>
				</ul>
			</div>
		</div>
		
		<center><?php include "./includes/newfooter.php"; ?></center> <!--- Calls footer stuff-->
	</div>
</body>
</html>