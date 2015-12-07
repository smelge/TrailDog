<script type="text/javascript">
	$(function(){
		$('#content').load('pages/home.html');
		$('ul.nav li a').click(function(){
		var page = $(this).attr('href');
		$('#content').load('pages/' page '.html');
		return false;
	})
});
</script>

<?php
//set up database links for countries in menu
	$scotlandset = mysqli_query($dblink, "SELECT DISTINCT * FROM maplocations WHERE country = 'Scotland' ORDER BY pageviews ASC,centre ASC");
	$englandset = mysqli_query($dblink, "SELECT DISTINCT * FROM maplocations WHERE country = 'England' ORDER BY pageviews ASC,centre ASC");
	$walesset = mysqli_query($dblink, "SELECT DISTINCT * FROM maplocations WHERE country = 'Wales' ORDER BY pageviews ASC,centre ASC");
	$nirelandset = mysqli_query($dblink, "SELECT DISTINCT * FROM maplocations WHERE country = 'NIreland' ORDER BY pageviews ASC,centre ASC");
//Set variables for counting trails in each country	
	$scot = 0;
	$scotdone = 0;
	$eng = 0;
	$engdone = 0;
	$wales = 0;
	$walesdone = 0;
	$ni = 0;
	$nidone = 0;
	$yurp = 0;
	$yurpdone = 0;
//Count trails in each country	
	$trailcountset = mysqli_query($dblink, "SELECT * FROM maplocations");
	while ($trailcount = mysqli_fetch_array($trailcountset)){
		switch ($trailcount['country']){
			case 'scotland':
				$scot++;
				if ($trailcount['display_on_map'] == 3){
					$scotdone++;
				}
				break;
			case 'england':
				$eng++;
				if ($trailcount['display_on_map'] == 3){
					$engdone++;
				}
				break;
			case 'wales':
				$wales++;
				if ($trailcount['display_on_map'] == 3){
					$walesdone++;
				}
				break;
			case 'nireland':
				$ni++;
				if ($trailcount['display_on_map'] == 3){
					$nidone++;
				}
				break;
			default:
				$yurp++;
				if ($trailcount['display_on_map'] == 3){
					$yurpdone++;
				}
				break;
		}
	}
	
//set variables for more trails
	$englist = 0;
	$scotlist = 0;
	$waleslist = 0;
	$nilist = 0;
	$europelist = 0;
?>
<div class="container-fluid" style="margin-bottom:10px;">
	<div class="row">
		<div class="col-xs-12" id="navigation" style="height:43px;font: normal bold 16px/1em Arial, Verdana, Helvetica;border:2px solid #353b56;background:#b6cee4;"> <!-- Header navbar -->
			<ul class="nav nav-pills" role="tablist" style="height:43px;">
				<li id="home"><a href="./index.php" id="home" style="color:black;height:39px;">Home</a></li>
				<li role="presentation" class="dropdown">
					<a class="dropdown-toggle" data-toggle="dropdown" href="#" style="color:black;height:39px;">
						Trail Directory <span class="caret"></span>
					</a>
					<ul class="dropdown-menu" role="menu">
						<li id="directory"><a href="./directory.php?c=eng" id="home">England (<?php echo $engdone; if ($engdone == 1){echo " Trail";} else {echo " Trails";}?>)</a></li>
						<li id="directory"><a href="./directory.php?c=nire" id="home">Northern Ireland (<?php echo $nidone; if ($nidone == 1){echo " Trail";} else {echo " Trails";}?>)</a></li>
						<li id="directory"><a href="./directory.php?c=scot" id="home">Scotland (<?php echo $scotdone; if ($scotdone == 1){echo " Trail";} else {echo " Trails";}?>)</a></li>
						<li id="directory"><a href="./directory.php?c=wal" id="home">Wales (<?php echo $walesdone; if ($walesdone == 1){echo " Trail";} else {echo " Trails";}?>)</a></li>
						<li id="directory"><a href="./directory.php?c=yurp" id="home">Europe (<?php echo $yurpdone; if ($yurpdone == 1){echo " Trail";} else {echo " Trails";}?>)</a></li>
					</ul>
				</li>
				<li id="news"><a href="./forum/index.php?board=1.0" style="color:black;height:39px;">News</a></li>
				<li id="stats"><a href="./stats.php" style="color:black;height:39px;">Statistics</a></li>
				<li id="forum"><a href="./forum" style="color:black;height:39px;">Forum</a></li>
				<li id="contact"><a href="mailto:traildogfilms@gmail.com" style="color:black;height:39px;">Contact Us</a></li>
				<?php
					if ($context['user']['is_guest']){
						echo '<li id="home" style="float:right;"><a href="./forum/index.php?action=register" id="register" style="color:black;">Register</a></li>';
						echo '<li id="home" style="float:right;"><a href="#" id="login" style="color:black;" data-toggle="modal" data-target="#loginModal">Login</a></li>';
					} else {
						echo '<li id="logout" style="float:right;"><a href="#" style="color:black;height:39px;" data-toggle="modal" data-target="#logoutModal">Log Out</a></li>';
					}
				?>
				<!-- Modal -->
					<div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="loginModalLabel" aria-hidden="true">
						<div class="modal-dialog">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
									<h4 class="modal-title" id="loginModalLabel">Login!</h4>
								</div>
								<div class="modal-body">
									<?php ssi_login();?>
								</div>
							</div>
						</div>
					</div>
					<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="logoutModalLabel" aria-hidden="true">
						<div class="modal-dialog">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
									<h4 class="modal-title" id="logoutModalLabel">Where do you think you're going?</h4>
								</div>
								<div class="modal-body">
									<a class="btn btn-danger" href="<?php echo $scripturl;?>?action=logout;<?php echo $context['session_var'];?>=<?php echo $context['session_id'];?>">I'm Leaving!</a>
									<button type="button" class="btn btn-success" data-dismiss="modal">Actually, I might stay a bit longer...</button>
								</div>
							</div>
						</div>
					</div>
				<?php
					if ($context['user']['is_guest']){
					} else {
						
						//Get users messages and alerts
						$main_id = $context['user']['id'];
						$messages = $context['user']['messages'];
						$alerts_set = mysqli_query($dbupload,"SELECT * FROM user_alerts WHERE user_id = $main_id");
						$alerts = mysqli_num_rows($alerts_set);
						$total_alert = $alerts + $messages;
						
						if($context['user']['is_admin']){ //Admin menu
							echo '<li role="presentation" class="dropdown" style="float:right;">';
								if ($total_alert == 0){
									echo '<a class="dropdown-toggle" data-toggle="dropdown" href="#" style="color:black;height:39px;">';
								} else {
							echo '<a class="dropdown-toggle btn-danger" data-toggle="dropdown" href="#" style="color:black;height:39px;">';
								}
							echo $context['user']['name'].' <span class="caret"></span>';
							echo '</a>';
								echo '<ul class="dropdown-menu" role="menu">';
									if ($alerts != 0){
										echo '<li id="user-menu"><a href="#" id="home"><span class="badge">'. $alerts .'</span> Alerts</a></li>';
									}
									if ($messages == 0){
										echo '<li id="user-menu"><a href="./forum/index.php?action=pm" id="home">No New Messages</a></li>';
									} else {
										echo '<li id="user-menu"><a href="./forum/index.php?action=pm" id="home"><span class="badge">'. $messages .'</span> Messages </a></li>';
									}
									//echo '<li id="user-menu"><a href="#" id="home">Admin</a></li>';
									echo '<li id="user-menu"><a href="./forum/index.php?action=admin" id="home">Forum Admin</a></li>';
									//echo '<li id="user-menu"><a href="#" id="home">Uploads</a></li>';
									echo '<li id="user-menu"><a href="./forum/index.php?action=profile" id="home">Profile</a></li>';
								echo '</ul>';
							echo '</li>';
						} else { // User Menu
							echo '<li role="presentation" class="dropdown" style="float:right;">';
								if ($total_alert == 0){
									echo '<a class="dropdown-toggle" data-toggle="dropdown" href="#" style="color:black;height:39px;">';
								} else {
									echo '<a class="dropdown-toggle btn-danger" data-toggle="dropdown" href="#" style="color:black;height:39px;">';
								}
									echo $context['user']['name'].' <span class="caret"></span>';
								echo '</a>';
								echo '<ul class="dropdown-menu" role="menu">';
									if ($alerts != 0){
										echo '<li id="user-menu"><a href="#" id="home"><span class="badge">'. $alerts .'</span> Alerts</a></li>';
									}
									if ($messages == 0){
										echo '<li id="user-menu"><a href="./forum/index.php?action=pm" id="home">No New Messages</a></li>';
									} else {
										echo '<li id="user-menu"><a href="./forum/index.php?action=pm" id="home"><span class="badge">'. $messages .'</span> Messages </a></li>';
									}
									//echo '<li id="user-menu"><a href="#" id="home">My Uploads</a></li>';
									echo '<li id="user-menu"><a href="./forum/index.php?action=profile" id="home">Profile</a></li>';
								echo '</ul>';
							echo '</li>';
						}
					}					
				?>
			</ul>
		</div>		
	</div>
</div>