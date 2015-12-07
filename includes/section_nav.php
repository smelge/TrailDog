<div id="tr-next">	
	<?php //Next section
		$next_split = (explode(";",$data['next_trail']));
		$next_split_no = count($next_split)-1;
		$next_trail_loop = 0;
		if ($next_split_no == 0){ // do this if only one next section
			$next_find = $data['next_trail'];
			$next_section_set = mysqli_query($dblink,"SELECT * FROM traildata WHERE trcode = '$next_find'");			
			$next_section = mysqli_fetch_array($next_section_set);
			
			if ($next_section['trtitle'] == ''){	
				echo '<a href="./trailhead.php?centre='. $trailcentre .'">';
			} else {
				echo '<a href="./trailinfo.php?centre='. $trailcentre .'&trail='. $trail['trailcode'] .'&sec='. $next_section['trcode'] .'">';
			}
				echo '<div class="tr-linkbox">';
					echo '<span style="font: normal bold 18px/1em Arial, Verdana, Helvetica;">Next Section</span>';
					echo '<hr style="height:2px;border-width:0;width:100%;color:#999966;background-color:#999966;margin:5px 0;">';
					if ($next_section['trtitle'] == ''){
						echo "End of Trail!";
					} else {
						echo $next_section['trtitle'];
					}
					echo '<hr style="height:2px;border-width:0;width:100%;color:#999966;background-color:#999966;margin:5px 0;">';
					echo '<span style="font: normal bold 9px/1em Arial, Verdana, Helvetica;">'. $centreident .' - '. $trail['trailname'] .'</span>';
				echo '</div>';
			echo '</a>';
			
		} else {
			while ($next_trail_loop <= $next_split_no){ //Do this if more than one Next Trail option
				$next_trail_split = (explode(",",$next_split[$next_trail_loop]));
				if ($next_trail_split[1] == $trailident){
					$next_find = $next_trail_split[0];
					$next_trail_find = $next_trail_split[1];
					$next_section_set = mysqli_query($dblink,"SELECT * FROM traildata WHERE trcode = '$next_find'");			
					$next_section = mysqli_fetch_array($next_section_set);
					$next_trail_set = mysqli_query($dblink,"SELECT * FROM trails WHERE trailcode = '$next_trail_find'");
					$next_trail = mysqli_fetch_array($next_trail_set);
				
					if ($next_section['trtitle'] == ''){	
						echo '<a href="./trailhead.php?centre='. $trailcentre .'">';
					} else {
						echo '<a href="./trailinfo.php?centre='. $trailcentre .'&trail='. $trail['trailcode'] .'&sec='. $next_section['trcode'] .'">';
					}
						echo '<div class="tr-linkbox">';
							echo '<span style="font: normal bold 18px/1em Arial, Verdana, Helvetica;">Next Section</span>';
							echo '<hr style="height:2px;border-width:0;width:100%;color:#999966;background-color:#999966;margin:5px 0;">';
							if ($next_section['trtitle'] == ''){
								echo "End of Trail!";
							} else {
								echo $next_section['trtitle'];
							}
							echo '<hr style="height:2px;border-width:0;width:100%;color:#999966;background-color:#999966;margin:5px 0;">';
							echo '<span style="font: normal bold 9px/1em Arial, Verdana, Helvetica;">'. $centreident .' - '. $trail['trailname'] .'</span>';
						echo '</div>';
					echo '</a>';
				}		
				$next_trail_loop++;
			}
		}
		//Display Other trails starting from this one
			$other_trail_loop = 0;
			
			while ($other_trail_loop < $next_split_no){ //Do this if more than one Next Trail option
				$other_trail_split = (explode(",",$next_split[$other_trail_loop]));
				if ($other_trail_split[1] != $trailident){
					$other_find = $other_trail_split[0];
					$other_trail_find = $other_trail_split[1];
					$other_section_set = mysqli_query($dblink,"SELECT * FROM traildata WHERE trcode = '$other_find'");			
					$other_section = mysqli_fetch_array($other_section_set);
					$other_trail_set = mysqli_query($dblink,"SELECT * FROM trails WHERE trailcode = '$other_trail_find'");
					$other_trail = mysqli_fetch_array($other_trail_set);
					
					if ($other_section['trtitle'] != $next_section['trtitle']){ //Ignore duplicate boxes
						echo '<a href="./trailinfo.php?centre='. $trailcentre .'&trail='. $trail['trailcode'] .'&sec='. $next_section['trcode'] .'">';
							echo '<div class="tr-linkbox">';
								echo '<span style="font: normal bold 18px/1em Arial, Verdana, Helvetica;">Other Sections</span>';
								echo '<hr style="height:2px;border-width:0;width:100%;color:#999966;background-color:#999966;margin:5px 0;">';
								if ($next_section['trtitle'] == ''){
echo "End of Trail!";
								} else {
echo $other_section['trtitle'];
								}
								echo '<hr style="height:2px;border-width:0;width:100%;color:#999966;background-color:#999966;margin:5px 0;">';
								echo '<span style="font: normal bold 9px/1em Arial, Verdana, Helvetica;">'. $centreident .' - '. $other_trail['trailname'] .'</span>';
							echo '</div>';
						echo '</a>';
					}
				}		
				$other_trail_loop++;
			}
		// Display Linking Trails
		if ($data['link_trails'] != ''){
			$link_section_setup = $data['link_trails'];
			$link_trails = (explode(";",$link_section_setup));
			$link_count = count($link_trails);
			
			if ($link_count == 1){ //if single link trail
				$link_set = mysqli_query($dblink,"SELECT * FROM traildata WHERE trcode = '$link_section_setup'");
				$link = mysqli_fetch_array($link_set);
				
				echo '<a href="./trailinfo.php?centre='. $trailcentre .'&trail='. $trail['trailcode'] .'&sec='. $link['trcode'] .'">';
					echo '<div class="tr-linkbox">';
						echo '<span style="font: normal bold 18px/1em Arial, Verdana, Helvetica;">Linking Sections</span>';
						echo '<hr style="height:2px;border-width:0;width:100%;color:#999966;background-color:#999966;margin:5px 0;">';
						echo $link['trtitle'];
						echo '<hr style="height:2px;border-width:0;width:100%;color:#999966;background-color:#999966;margin:5px 0;">';
						echo '<span style="font: normal bold 9px/1em Arial, Verdana, Helvetica;">'. $centreident .'</span>';
					echo '</div>';
				echo '</a>';
			} else { //if multiple link trails
				$linkloop = 0;
				while ($linkloop < $link_count-1){
					$link_set = mysqli_query($dblink,"SELECT * FROM traildata WHERE trcode = '$link_trails[$linkloop]'");
					$link = mysqli_fetch_array($link_set);
					
					echo '<a href="./trailinfo.php?centre='. $trailcentre .'&trail='. $trail['trailcode'] .'&sec='. $link['trcode'] .'">';
						echo '<div class="tr-linkbox">';
							echo '<span style="font: normal bold 18px/1em Arial, Verdana, Helvetica;">Linking Sections</span>';
							echo '<hr style="height:2px;border-width:0;width:100%;color:#999966;background-color:#999966;margin:5px 0;">';
							echo $link['trtitle'];
							echo '<hr style="height:2px;border-width:0;width:100%;color:#999966;background-color:#999966;margin:5px 0;">';
							echo '<span style="font: normal bold 9px/1em Arial, Verdana, Helvetica;">'. $centreident .'</span>';
						echo '</div>';
					echo '</a>';
					$linkloop++;
				}
			}
		}
	?>
	

</div>