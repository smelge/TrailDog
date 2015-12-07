<?php
	$hostname = "localhost";
	$username = "traildog_smf1";
	$password = "V@SstlhmxF60]@1";
	$database = "traildog_smf1";

	$user_db = mysqli_connect($hostname, $username, $password);
	mysqli_select_db($user_db, $database) or die ("Could not connect to User Database");
		
?>