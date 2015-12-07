<?php 
	require("../forum/SSI.php");
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Traildog 2015 Centre testpage</title>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="description" content="MTB Trail Database">
		<meta name="keywords" content="mtb,mountain,bike,cycling,cross,country,xc,downhill,dh,freeride,united,kingdom,uk,ae,forest,scotland">
		<meta name="author" content="Tavy Fraser">
					
		<!-- Bootstrap -->
		<link href="../css/bootstrap.min.css" rel="stylesheet">
		<!--New css-->
		<link rel="stylesheet" type="text/css" href="../css/styles.css"/>
		
		<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
			<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
			<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->
		
		<script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
	</head>

	<body>
		<div id="adminmain" style="border:2px solid black;margin:10px auto;height:auto;width:95%;">
			<?php
				if ($context['user']['is_admin']){?>
					Logged in as: <?php echo $context['user']['name'];?>
					<?php echo ssi_logout();?>
					<br><br>
					Main menu<br>
					<br>
					Add Trailcentre<br>
					Update Trailcentre<br>
						add trail<br>
						update existing trails<br>
				
				
					
				<?php
				} else {
					echo "You shouldn't be here...";
				}
				?>
			<center><?php include "../includes/newfooter.php"; ?></center> <!--- Calls footer stuff-->
		</div>
	</body>
</html>