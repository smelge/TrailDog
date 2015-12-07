<?php
	$hostname = "localhost";
	$username = "traildog_query";
	$password = "^uRx+TonLfdG";
	$database = "traildog";

	$dblink = mysqli_connect($hostname, $username, $password);
	mysqli_select_db($dblink, "traildog_traildata") or die ("Could not connect to TrailData");
		
?>