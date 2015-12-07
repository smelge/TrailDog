<?php 
	require_once ('./includes/essentials.php');
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Traildog Add a Trail</title>
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
	<div class="container-fluid">
		<?php include "./includes/newheader.php"; ?> <!---Calls all header sections-->
		<div class="row">
			<?php
				//Adding a trail Process
				
				$trailname = filter_input(INPUT_POST, 'trailname', FILTER_SANITIZE_STRING);
				$trailcode_set = strtolower($trailname);
				$trailcode = str_ireplace(" ","_",$trailcode_set);
				$trailcentre = filter_input(INPUT_POST, 'trailcentre', FILTER_SANITIZE_STRING);
				$traillength = filter_input(INPUT_POST, 'traillength', FILTER_SANITIZE_STRING);
				$trailclimb = filter_input(INPUT_POST, 'trailclimb', FILTER_SANITIZE_STRING);
				if ($trailclimb == ''){$trailclimb = 0;}
				$traildescent = filter_input(INPUT_POST, 'traildescent', FILTER_SANITIZE_STRING);
				if ($traildescent == ''){$traildescent = 0;}
				$trailgrade = filter_input(INPUT_POST, 'trailgrade', FILTER_SANITIZE_STRING);
				$trailtype = filter_input(INPUT_POST, 'trailtype', FILTER_SANITIZE_STRING);
				$routekml = $_FILES['routekml'];
				$firstsection = filter_input(INPUT_POST, 'firstsection', FILTER_SANITIZE_STRING);
				$user = filter_input(INPUT_POST, 'user', FILTER_SANITIZE_STRING);
				$user_con_lower = strtolower($user);
				$user_con = str_ireplace(" ","_",$user_con_lower);
				$date = date("d-m-Y-h-i-s");
				$section = "trail";
				
				$startsection_set = filter_input(INPUT_POST, 'firstsection', FILTER_SANITIZE_STRING);
				if ($startsection_set == 'none'){
					$startsection = '';
				} else {
					$startsection = $startsection_set;
				}
	
				if ($routekml != ''){
					echo "KML FILE UPLOADED<br>";
					
					$route_kml_set = explode(".",$_FILES['routekml'] ['name']);					
					if ($route_kml_set[1] != 'kml'){
						echo "Invalid KML File<br><br>";
					} else { 
						$routekml = $route_kml_set[0] . $user_con . $date;
						echo "KML is: ". $_FILES['routekml'] ['name'] ."<br>";	
						//If admin, allow instant upload
							
						if ($context['user']['is_admin']){
							if (move_uploaded_file($_FILES['routekml'] ['tmp_name'], "./usertrails/". $routekml .".kml")){
								echo "KML File has been uploaded<br>";
							} else {
								echo "There was a problem uploading your file...<br>";
							}
							
							/*$sqlpath = "INSERT INTO user_gps_upload (username,trailcentre,trail_name,section_name,gps_path) VALUES ('$user','$trailcentre','$trailname','$section','$routekml')";
							if (!mysqli_query($dbupload,$sqlpath)) {
								die('Error: ' . mysqli_error($dbupload));
							}*/
							echo "User is admin, uploads KML direct<br>";
						} else { //Regular User, send files to temp folder for review
							if (move_uploaded_file($_FILES['routekml'] ['tmp_name'], "./usertrails/review/". $routekml .".kml")){
								echo "KML File has been uploaded<br>";
							} else {
								echo "There was a problem uploading your file...<br>";
							}
							
							/*$sqlpath = "INSERT INTO user_gps_upload_temp (username,trailcentre,trail_name,section_name,gps_path) VALUES ('$user','$trailcentre','$trailname','$section','$routekml')";
							if (!mysqli_query($dbupload,$sqlpath)) {
								die('Error: ' . mysqli_error($dbupload));
							}*/
							echo "User is standard, uploads KML to temp folder<br>";
						}
					}
				} else {
					echo "KML FILE DIDN'T UPLOAD<br>";
				}
				if ($context['user']['is_admin']){ // Admin account, add direct to database
					/*$routeupload = "INSERT INTO trails (trailname,trailcode,trailcentre,traillength,trailclimb,traildescent,grade,trailtype,kml,startsection,submittedby) VALUES ('$trailname','$trailcode','$trailcentre','$traillength','$trailclimb','$traildescent','$trailgrade','$trailtype','$routekml','$startsection','$user')";
					if (!mysqli_query($dblink,$routeupload)) {
						die('Error: ' . mysqli_error($dblink));
					}*/
					echo "User is admin, uploads data direct<br>";
				} else { // Regular user, send data to temp table for review
					/*$routeupload = "INSERT INTO trails_temp (trailname,trailcode,trailcentre,traillength,trailclimb,traildescent,grade,trailtype,kml,startsection,submittedby) VALUES ('$trailname','$trailcode','$trailcentre','$traillength','$trailclimb','$traildescent','$trailgrade','$trailtype','$routekml','$startsection','$user')";
					if (!mysqli_query($dblink,$routeupload)) {
						die('Error: ' . mysqli_error($dblink));
					}*/
					echo "User is standard, uploads data to temp folder<br>";
				}
				
				echo "Trail Name: ". $trailname ."<br>";
				echo "Trail Code: ". $trailcode ."<br>";
				echo "Trail Centre: ". $trailcentre ."<br>";
				echo "Length: ". $traillength ."<br>";
				echo "Climb: ". $trailclimb ."<br>";
				echo "Descent: ". $traildescent ."<br>";
				echo "Grade: ". $trailgrade ."<br>";
				echo "Type: ". $trailtype ."<br>";
				echo "KML: ". $routekml ."<br>";
				echo "First Section: ". $firstsection ."<br>";
				echo "User: ". $user ."<br>";
			?>
			<?php
				$trail_centre_find = mysqli_query($dblink,"SELECT * FROM maplocations WHERE link = '$trailcentre'");
				$name_centre = mysqli_fetch_array($trail_centre_find);
			?>
			<br>
			<?php
				if ($context['user']['is_admin']){
					echo '<a href="./trailhead.php?centre='. $trailcentre .'&trail='. $trailcode .'" class="btn btn-primary" role="button">Back to '. $name_centre['name'] .'</a>';
				} else {
					echo '<a href="./trailhead.php?centre='. $trailcentre .'" class="btn btn-primary" role="button">Back to '. $name_centre['name'] .'</a>';
				}
			?>
			<a href="./contribute.php?centre=<?php echo $trailcentre;?>&type=trail&filter=add" style="margin-left:10px;" class="btn btn-primary" role="button">Add another trail</a>
		</div>
		
		<center><?php include "./includes/newfooter.php"; ?></center> <!--- Calls footer stuff-->
	</div>
</body>
</html>