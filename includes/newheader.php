<div id="pageheader">
	<?php 
		include('./includes/useruploads_connect.php');
	?>	
	<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?key=AIzaSyC7rGhA15IDXd0M0bAae2YDgxUBqQ6szUM&sensor=false"></script>
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.min.js" type="text/javascript"></script>
	<script src="js/bootstrap.min.js"></script>
	<link rel="icon" type="image/png" href="../assets/tdicon.png">
			
				
			<?php 
				date_default_timezone_set("Europe/London");
				$timer =  date("Y-m-d") . " " . date("H:i:s");
				$today_date = date("Y-m-d");
			?>	
				<script type="text/javascript">
				function show_alert()
				{
				alert("This feature is being worked on!\nThanks for your patience.");
				}
				</script>	
					
	<div class="container-fluid" style="margin-bottom:0;">
		<div id="header">			
			<div class="row">
				<div class="col-xs-8">
					<a href="index.php"><img src="assets/sitelogo2014.png" class="img-responsive" alt="Traildog Logo"/></a>
				</div>
				<div class="col-xs-4">
					<!--blank area-->
				</div>
			</div>
		</div>
	</div>	
	<div class="row">
		<div class="col-xs-12">
			<?php include ("./includes/mainmenu.php"); ?>
		</div>
	</div>
</div>
	
		