<?php
	require_once("../../forum/SSI.php");
	$_SESSION['login_url']='http://www.trail-dog.co.uk' . $_SERVER['PHP_SELF'];
	$_SESSION['logout_url']='http://www.trail-dog.co.uk' . $_SERVER['PHP_SELF'];
	include_once './database_connect.php';
	include_once ('./user_db.php');
	include_once ('./analyticstracking.php');
	include_once ('./useruploads_connect.php');
?>	
	<!-- Bootstrap -->
	<link href="../css/bootstrap.min.css" rel="stylesheet">
	<!--New css-->
	<link rel="stylesheet" type="text/css" href="../css/styles.css"/>
	<link rel="icon" href="../assets/tdicon.png" type="image/x-icon">
	<link rel="stylesheet" href="../css/font-awesome.min.css">

	<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->

	<script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
<?php
	//Admin Edit for various parts of pages
	
	$centre = filter_input(INPUT_GET, 'centre', FILTER_SANITIZE_STRING);
	$action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_STRING);
	$description = filter_input(INPUT_POST, 'centredesc', FILTER_SANITIZE_STRING);
	$weatherstation = filter_input(INPUT_POST, 'weatherstation', FILTER_SANITIZE_STRING);
	$website = filter_input(INPUT_POST, 'website', FILTER_SANITIZE_STRING);
	
	echo "Trailcentre: ". $centre ."<br>";
	echo "Action: ". $action ."<br>";
	echo "Description: ". $description;
	
	switch ($action){
		case 'description':
			//Do this stuff if the edit is a description
			$sqlpath = "UPDATE maplocations SET description ='$description' WHERE link = '$centre'";
			if (!mysqli_query($dblink,$sqlpath)) {
				die('Error: ' . mysqli_error($dblink));
			}
		break;
		case 'facilities':
			//Do this stuff if facilities are being edited
		break;
		case 'update1':
			//do this stuff to set Update Mode to ON for trailhead
			$sqlpath = "UPDATE maplocations SET updating = 1 WHERE link = '$centre'";
			if (!mysqli_query($dblink,$sqlpath)) {
				die('Error: ' . mysqli_error($dblink));
			}
			echo "Trailhead is in <b>UPDATING</b> Mode<br>";
		break;
		case 'update0':
			//do this stuff to set Update Mode to OFF for trailhead
			$sqlpath = "UPDATE maplocations SET updating = 0 WHERE link = '$centre'";
			if (!mysqli_query($dblink,$sqlpath)) {
				die('Error: ' . mysqli_error($dblink));
			}
			echo "Trailhead is in <b>NORMAL</b> Mode<br>";
		break;
		case 'display1':
			//do this stuff to show trailcentre in Directory
			$sqlpath = "UPDATE maplocations SET display_on_map = 3 WHERE link = '$centre'";
			if (!mysqli_query($dblink,$sqlpath)) {
				die('Error: ' . mysqli_error($dblink));
			}
			echo "Centre has been added to Directory<br>";
		break;
		case 'display0':
			//do this stuff to remove trailcentre from Directory
			$sqlpath = "UPDATE maplocations SET display_on_map = 1 WHERE link = '$centre'";
			if (!mysqli_query($dblink,$sqlpath)) {
				die('Error: ' . mysqli_error($dblink));
			}
			echo "Centre is not available in Directory<br>";
		break;
		case 'weather':
			$sqlpath = "UPDATE maplocations SET weather = $weatherstation WHERE link = '$centre'";
			if (!mysqli_query($dblink,$sqlpath)) {
				die('Error: ' . mysqli_error($dblink));
			}
			echo "Weatherstation has been added.<br>";
		break;
		case 'website':
		$sqlpath = "UPDATE maplocations SET website = '$website' WHERE link = '$centre'";
			if (!mysqli_query($dblink,$sqlpath)) {
				die('Error: ' . mysqli_error($dblink));
			}
			echo "Website has been added.<br>";
		break;
	}
	
	echo '<br><a href="../trailhead.php?centre='. $centre .'" class="btn btn-primary" role="button">Back to Trailhead</a>';	
?>