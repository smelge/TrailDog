<div id="pageheader">
	<?php 
	include ('../includes/database_connect.php');
	//include_once ('../includes/news_connect.php');
	include_once ('../includes/analyticstracking.php');
	include_once ('../includes/permissions.php');
	?>	
	<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?key=AIzaSyC7rGhA15IDXd0M0bAae2YDgxUBqQ6szUM&sensor=false"></script>
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.min.js" type="text/javascript"></script>
	<script src="../js/bootstrap.min.js"></script>
			
				
			<?php 
				date_default_timezone_set("Europe/London");
				$timer =  date("Y-m-d") . " " . date("H:i:s");
				$today_date = date("d/m/Y");
			?>	
				<script type="text/javascript">
				function show_alert()
				{
				alert("This feature is being worked on!\nThanks for your patience.");
				}
				</script>	
					
	<div class="container-fluid" style="margin-bottom:10px;">
		<div id="header">			
			<div class="row">
				<div class="col-xs-8">
					<a href="index.php"><img src="../assets/sitelogo2014.png" class="img-responsive" alt="Traildog Logo"/></a>
				</div>
				<div class="col-xs-4">
					<div class="row">
						<div class="col-xs-6" style="margin-top:30px;">
							<?php
								if ($context['user']['is_guest']){
									//Logged Out, no HUD
								} else {
									if ($context['user']['is_admin']){?>
										<!-- Display Admin HUD -->
										<div class="row" style="text-align:center;margin-bottom:5px;font-weight:bold;">
											<a href="#">
												<div class="col-xs-5" style="color:#353b56;padding-top:8px;height:40px;background:#b6cee4;border-top-left-radius:10px;margin-right:5px;">
													Profile
												</div>
											</a>
											<a href="./adminindex.php">
												<div class="col-xs-5" style="color:#353b56;padding-top:8px;height:40px;background:#b6cee4;border-top-right-radius:10px;">
													Admin
												</div>
											</a>
										</div>
										<div class="row" style="text-align:center;font-weight:bold;">
											<a href="#">
												<div class="col-xs-5" style="color:#353b56;padding-top:8px;height:40px;background:#b6cee4;border-bottom-left-radius:10px;margin-right:5px;">
													Uploads
												</div>
											</a>
											<a href="#">
												<div class="col-xs-5" style="color:#353b56;padding:8px 2px 0 0;height:40px;background:#b6cee4;border-bottom-right-radius:10px;">
													Messages
												</div>
											</a>
										</div><?php
									} else {?>
										<!-- Display User HUD -->
										<div class="row" style="text-align:center;margin-bottom:5px;font-weight:bold;">
											<a href="#">
											<div class="col-xs-5" style="color:#353b56;padding-top:8px;height:40px;background:#b6cee4;border-top-left-radius:10px;margin-right:5px;">
												Profile
											</div>
											</a>
											<a href="#">
											<div class="col-xs-5" style="color:#353b56;padding-top:8px;height:40px;background:#b6cee4;border-top-right-radius:10px;">
												Alerts
											</div>
											</a>
										</div>
										<div class="row" style="text-align:center;font-weight:bold;">
											<a href="#">
											<div class="col-xs-5" style="color:#353b56;padding-top:8px;height:40px;background:#b6cee4;border-bottom-left-radius:10px;margin-right:5px;">
												Uploads
											</div>
											</a>
											<a href="#">
											<div class="col-xs-5" style="color:#353b56;padding:8px 2px 0 0;height:40px;background:#b6cee4;border-bottom-right-radius:10px;">
												Messages
											</div>
											</a>
										</div>
										<?php 
									}
								}
							?>
						</div>
						<div class="col-xs-6" style="margin-top:30px;background:#b6cee4;height:85px;text-align:center;padding-top:8px;border-radius:10px;">
							<?php
								if ($context['user']['is_guest'])
								{
									ssi_login();
								}
								else
								{
									//You can show other stuff here.  Like ssi_welcome().  That will show a welcome message like.
									//Hey, username, you have 552 messages, 0 are new.
									echo "Logged in as:";
									echo '<hr style="height:2px;border-width:0;width:100%;color:#99b6d1;background-color:#99b6d1;margin: 5px;">';
									echo $context['user']['name'] ."<br>";
									ssi_logout();
								}
							?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>	
	<div class="row">
		<div class="col-xs-12">
			<?php include ("../includes/mainmenu.php"); ?>
		</div>
	</div>
</div>
	
		