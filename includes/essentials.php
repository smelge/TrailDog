<?php
	require_once("../forum/SSI.php");
	$_SESSION['login_url']='http://www.trail-dog.co.uk' . $_SERVER['PHP_SELF'];
	$_SESSION['logout_url']='http://www.trail-dog.co.uk' . $_SERVER['PHP_SELF'];
	include_once './includes/database_connect.php';
	include_once ('./includes/user_db.php');
	include_once ('./includes/analyticstracking.php');
	include_once ('./includes/useruploads_connect.php');
	
?>