<?php
	$hostname = "";
	$username = "";
	$password = "";
	$database = "";

	$user_db = mysqli_connect($hostname, $username, $password);
	mysqli_select_db($user_db, $database) or die ("Could not connect to User Database");
		
?>
