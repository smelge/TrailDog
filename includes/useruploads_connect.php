<?php
	$hostname = "localhost";
	$username = "traildog_uploads";
	$password = "S&Z}^d2l~gMX";

	$dbupload = mysqli_connect($hostname, $username, $password);
	mysqli_select_db($dbupload, "traildog_user_uploads") or die ("Could not connect to User Uploads Server");
		
?>