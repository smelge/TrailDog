<div id="tr-sec">
	<a href="./trailhead.php?centre=<?php echo $trailcentre;?>&trail=<?php echo $trailident;?>">
	<div id="tr-sec-back">
		Back to <?php echo $centrename;?>
	</div>
	</a>
	<div id="tr-sec-head">
		<?php echo $trail['trailname'];?>
	</div>
	<?php
		$getsection = $trail['startsection'];
		$section_amount = $trail['no_section'];
		$section_loop = 1;
		$prevdistance = 0;
		$afterdistance = 0;
		$totallong = $trail['traillength'];
		while ($section_loop <= $section_amount){
			$section_setup = mysqli_query($dblink,"SELECT * FROM traildata WHERE trcode = '$getsection'");
			$section = mysqli_fetch_array($section_setup);
			
			echo "<a href='./trailinfo.php?centre=". $trailcentre ."&trail=". $trailident ."&sec=". $section['trcode'] ."'>";
				
				if ($section['trcode'] == $sec){
					echo "<div class='tr-sec-item' style='background:#999966;'>";
					$prevper = $prevdistance;
				} else {
					echo "<div class='tr-sec-item'>";
					$prevdistance=$prevdistance + $section['trlength'];
				}
					
					if ($section['trclimb'] > $section['trdescent']){
						echo $section['trtitle'] ."<img style='float:right;margin-top:-5px;margin-right:10px;' src='./assets/icons/uphill.png' alt='Climb'/>";
					} else {
						echo $section['trtitle'] ."<img style='float:right;margin-top:-5px;margin-right:10px;' src='./assets/icons/downhill.png' alt='Descent'/>";
					}
				echo "</div>";
			echo "</a>";
			//end of printed bit
			
			//Explode next_trail
			$split_options = (explode(";",$section['next_trail']));
			$count_options = count($split_options);
			if ($count_options == 1){
				$getsection = $section['next_trail'];
			} else {
				$splitloop = 0;
				while ($splitloop <= $count_options){
					$ind_options = (explode(",",$split_options[$splitloop]));
					if ($ind_options[1] == $trailident){
						$getsection = $ind_options[0];
					}
					$splitloop++;
				}
			}
			$section_loop++;
		}
	?>
</div>
									