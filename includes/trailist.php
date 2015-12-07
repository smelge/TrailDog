<?php
	$trail_list_set = mysqli_query($dblink,"SELECT * FROM trails WHERE trailcentre = '$trailcentre' ORDER BY grade ASC,traillength ASC ");
	
	//count number of trails, and if 0 display "No Trails message"
	
	$trail_count = mysqli_num_rows($trail_list_set); 
	
	if ($trail_count == 0){
			echo '<div class="traillist-null" >No Trails for this centre</div>';
		if ($context['user']['is_guest']){
		} else {
			echo '<a style="overflow:visible" href="./contribute.php?centre='. $trailcentre .'&type=trail">';
				echo '<div class="traillist" style="background:#cccccc;text-align:center;">Add or Edit a Trail!</div>';
			echo '</a>';
		}
	} else {
		while ($trail_list = mysqli_fetch_array($trail_list_set)){
			switch($trail_list['grade']){ //Assign styling dependant on trail grade
				case 1:
					$trail_colour = "background:#66cc99;";
					break;
				case 2:
					$trail_colour = "background:#6699ff;";
					break;
				case 3:
					$trail_colour = "background:#cc6666;";
					break;
				case 4:
					$trail_colour = "background:#484848; color:white;";
					break;
				case 5:
					$trail_colour = "background:#cc9933;";
					break;
				case 6:
					$trail_colour = "background:#66cc99;";
					break;
			}
			
			switch ($trail_list['trailtype']){
				case 1:
					$trail_type = "Cross-Country";
					break;
				case 2:
					$trail_type = "Freeride";
					break;
				case 3:
					$trail_type = "Downhill";
					break;
				case 4:
					$trail_type = "Dirt Jumps";
					break;
				case 5:
					$trail_type = "Pumptrack";
					break;
				case 6:
					$trail_type = "Four-Cross";
					break;
			}
			
			if ($trail_list['trailname'] != ''){
				echo '<a style="overflow:visible" title="'. $trail_type .'" href="?centre='. $trailcentre .'&trail='. $trail_list['trailcode'] .'">';
					echo '<div class="traillist" style="'. $trail_colour .'" id="'. $trail_list['kml'] .'">
						<div class="trailname">'. $trail_list['trailname'] .'</div>
						<div class="traillength">'. round($trail_list['traillength']/1000,1) .' km</div></div>';
				echo "</a>";
				//Display KML code
				//if ($trailtitle == ''){//only displays KML if no specific trail has been chosen?>
					<script>
						var glencoe1 = new google.maps.KmlLayer({
							url: 'http://www.trail-dog.co.uk/trails/glencoered.kml',
							suppressInfoWindows: true
						});								
						glencoe1.setMap(map)
					</script><?php
				//}
			}
		}
		if ($context['user']['is_guest']){
			//User can't add or edit trails
		} elseif ($context['user']['is_admin']){ //if Admin, allow to test
			echo '<a style="overflow:visible" href="./contribute.php?centre='. $trailcentre .'&type=trail">';
				echo '<div class="traillist" style="background:#cccccc;text-align:center;">Add or Edit a Trail!</div>';
			echo '</a>';
		} else {
			/*echo '<a style="overflow:visible" href="./contribute.php?centre='. $trailcentre .'&type=trail">';*/
			echo '<a style="overflow:visible" href="#" title="Hold on, still bugfixing this feature!">';
				echo '<div class="traillist" style="background:#cccccc;text-align:center;">Add or Edit a Trail!</div>';
			echo '</a>';
		}
	}
?>

