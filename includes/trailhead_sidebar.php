<!--
	Description
	Directions
	Trails
	Updates
	Website
-->

<div id="trailslist" style="width:100%;">
	<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
		<div class="panel panel-default acc-body" style="margin-bottom:0;border:1px solid black;">
			<a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
				<div class="panel-heading sliderhead" role="tab" id="headingOne">
					<div class="slider-title">
						<?php echo $centre['name'];?>
					</div>
				</div>
			</a>
			<div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
				<div class="panel-body sliderbody">
					<?php 
						if ($context['user']['is_admin']){
							// button to add description
							echo nl2br($centre['description']);
						echo "<hr style='margin:5px 0;'>";?>
						<button type="button" style="margin:0 auto;" class="btn btn-primary btn-block" data-toggle="modal" data-target="#myModal">
							Edit Description
						</button>
						<!-- Modal -->
						<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
							<div class="modal-dialog">
								<div class="modal-content">
									<form action="./includes/edit.php?centre=<?php echo $centre['link'];?>&action=description" method="post">
										<div class="modal-header">
											<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
											<h4 class="modal-title" id="myModalLabel">Modify Description for <?php echo $centre['name'];?></h4>
										</div>
										<div class="modal-body">
											<textarea name="centredesc" class="form-control" rows="3"><?php echo (nl2br($centre['description']));?></textarea>
										</div>
										<div class="modal-footer">
											<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
											<button type="submit" value="submit" class="btn btn-primary">Save changes</button>
										</div>
									</form>
								</div>
							</div>
							</div><?php
						} else {
							if ($centre['description'] == ''){
								echo "We haven't got a description for this centre yet!<br>";
							} else {
								echo nl2br($centre['description']);
							}
						}
					?>
				</div>
			</div>
		</div>
		<div class="panel panel-default acc-body" style="margin-bottom:0;border:1px solid black;">
			<a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
				<div class="panel-heading sliderhead" role="tab" id="headingTwo">
					<div class="slider-title">
						Directions
					</div>
				</div>
			</a>
			<div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
				<div class="panel-body sliderbody">
					<?php
						echo "This seems to have broken. We're working on it.";
						//check if logged in
						if ($context['user']['is_guest']){
							// User is logged out, enable Geolocation
						} else {
							// User is logged in
							// Gather users co-ordinates from database
							//Set Geolocation Data as SESSION variable
							
							$username = $context['user']['name'];
							
							$set_user_id = mysqli_query($user_db, "SELECT id_member FROM smf_members WHERE real_name = '$username'");
							$get_user_id = mysqli_fetch_array($set_user_id);
							$user_id = $get_user_id['id_member'];
							
							$set_user_coord = mysqli_query($user_db, "SELECT value FROM smf_themes WHERE id_member = $user_id AND variable = 'cust_home'");
							$get_user_coord = mysqli_fetch_array($set_user_coord);
							$user_coord = $get_user_coord['value'];								
							
							
							// Check if user has added co-ordinates
							if ($user_coord != ''){
								// User has co-ordinates, set them as home
								$homecord = $user_coord;
							} else {
							// User has no co-ordinates logged, enable Geolocation?>											
							<?php echo 'You have not set your Home Location.<br>';
								echo 'Either Set it <a href="http://www.trail-dog.co.uk/forum/index.php?action=profile;area=account">here</a><br>';
								echo 'or Auto-Locate (Please note: This feature uses your IP address, so may not be accurate.)<br>';
								
								echo '<button onclick="getLocation()">Auto-Locate</button>';
								
								echo '<p id="demo"></p>';
								
								echo '<script>';
								echo 'var x = document.getElementById("demo");';
								
								echo 'function getLocation() {';
								echo 'if (navigator.geolocation) {';
								echo 'navigator.geolocation.getCurrentPosition(showPosition);';
								echo '} else { ';
								echo 'x.innerHTML = "Geolocation is not supported by this browser.";';
								echo '}';
								echo '}';
								
								echo 'function showPosition(position) {';
								echo 'x.innerHTML = "Latitude: " + position.coords.latitude + ';
								echo '"<br>Longitude: " + position.coords.longitude;';
								echo '"User-Co-ordinates:<br>" + position.coords.latitude + position.coords.longitude';
								echo '}';
								echo '</script>';
							}
						}
					?>
				</div>
			</div>
		</div>
		<div class="panel panel-default acc-body" style="margin-bottom:0;border:1px solid black;">
			<a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
			<div class="panel-heading sliderhead" role="tab" id="headingThree">
				<div class="slider-title">
					Trails
				</div>
			</div>
			</a>
			<div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
				<div class="panel-body sliderbody" style="padding:0;">
					<?php include './includes/trailist.php';?>
				</div>
			</div>
		</div>
		<div class="panel panel-default acc-body" style="margin-bottom:0;border:1px solid black;">
			<a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
			<div class="panel-heading sliderhead" role="tab" id="headingFour">
				<div class="slider-title">
					<?php
						$centrename = $centre['link'];
						$update_set = mysqli_query($dblink,"SELECT * FROM trail_update WHERE centre = '$centrename'");
						$update_finder = mysqli_query($dblink,"SELECT * FROM trail_update WHERE centre = '$centrename'");
						$update_count = 0;
						
						while ($update_count_set = mysqli_fetch_array($update_finder)){
							if ($update_count_set['date_effective_to'] > $today_date || $update_count_set['date_effective_to'] == '0000-00-00'){
								$update_count++;
							}
						}									
						echo $update_count." Trail Updates";
					?>
				</div>
			</div>
			</a>
			<div id="collapseFour" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFour">
				<div class="panel-body sliderbody">
					<?php
						while ($updates = mysqli_fetch_array($update_set)){
							if ($updates['date_effective_to'] > $today_date || $updates['date_effective_to'] == '0000-00-00'){
								echo "<div class='update_cont'>";
								echo "<div class='update_seg' style='background:#cebd95;'>". $updates['trail'] ." - ". $updates['section'] ."</div>";
								if ($updates['type'] == "closure"){
									echo "<div class='update_seg'>Section Closed from<br>";
									echo date_format((date_create($updates['date_effective_from'])),'d/m/Y');
									echo " until ";
									if ($updates['date_effective_to'] == '0000-00-00'){
										echo "tbc";
									} else {
										echo date_format((date_create($updates['date_effective_to'])),'d/m/Y');
									}
									echo "</div>";
									echo "<div class='update_seg'>Diversion: ". nl2br($updates['diversion']) ."</div>";
								} elseif ($updates['type'] == 'warning'){
									echo "<div class='update_seg bg-danger'>". $updates['diversion'] ."</div>";
								} else {
									echo "<div class='update_seg'>Section under repair, use caution when riding.</div>";
								}
								echo "</div>";
							}
						}
						if ($context['user']['is_guest']){
							echo "<div class='update_seg' style='background:#cebd95;'>Do you know something we don't? If you're logged in, you can submit an update if you do!</div>";
						} else {
							echo "<div class='update_seg' style='background:#cebd95;'>Do you know something we don't? As a member, you can add your own updates! Just click <b>HERE!</b><br><br>Is what it would say if this feature was complete. It's coming soon though...</div>";
						}									
					?>
				</div>
			</div>
		</div>
		
		<?php
			if ($centre['website'] == ''){
				// if no site added, do not show except for admins
				if ($context['user']['is_admin']){
					//add site button
					echo '<div class="trailsliderhead-deactivated">';
					echo '<button type="button" style="margin:0 auto;" class="btn btn-primary btn-block" data-toggle="modal" data-target="#webModal">';
					echo 'Add a Website';
					echo '</button>';
					// Modal
					echo '<div class="modal fade" id="webModal" tabindex="-1" role="dialog" aria-labelledby="webModalLabel" aria-hidden="true">';
					echo '<div class="modal-dialog">';
					echo '<div class="modal-content">';
					echo '<form action="./includes/edit.php?centre='. $centre['link'] .'&action=website" method="post">';
					echo '<div class="modal-header">';
					echo '<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>';
					echo '<h4 class="modal-title" id="webModalLabel">Add a website for '. $centre['name'] .'</h4>';
					echo '</div>';
					echo '<div class="modal-body">';
					echo '<input type="url" name="website" class="form-control" placeholder="Add a URL">';
					echo '</div>';
					echo '<div class="modal-footer">';
					echo '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>';
					echo '<button type="submit" value="submit" class="btn btn-primary">Save changes</button>';
					echo '</div>';
					echo '</form>';
					echo '</div>';
					echo '</div>';
					echo '</div>';
					echo '</div>';
				}
			} else {
				// if website added, link to it
				echo '<div class="panel panel-default acc-body" style="margin-bottom:0;border:1px solid black;">';
					echo '<a href="'. $centre['website'] .'" target="_blank">';
						echo '<div class="panel-heading sliderhead" role="tab" id="headingFive">';
							echo '<div class="slider-title">';
								echo 'Official Site';
							echo '</div>';
						echo '</div>';
					echo '</a>';
				echo '</div>';
			}
		?>
		
		
	</div>
</div>