<?php
	$overlay_setup = mysqli_query($dblink, "SELECT * FROM trails WHERE trailcentre = '$trailcentre' AND trailcode = '$trailtitle'");
	$overlay = mysqli_fetch_array($overlay_setup);
	
	switch($overlay['grade']){ //Assign styling dependant on trail grade
		case 1:
			$overlay_colour = "background:#66cc99;";
			$overlay_hr = "color:black;background-color:black";
			break;
		case 2:
			$overlay_colour = "background:#6699ff;";
			$overlay_hr = "color:black;background-color:black";
			break;
		case 3:
			$overlay_colour = "background:#cc6666;";
			$overlay_hr = "color:black;background-color:black";
			break;
		case 4:
			$overlay_colour = "background:#484848; color:white;";
			$overlay_hr = "color:white;background-color:white";
			break;
		case 5:
			$overlay_colour = "background:#cc9933;";
			$overlay_hr = "color:black;background-color:black";
			break;
		case 6:
			$overlay_colour = "background:#66cc99;";
			$overlay_hr = "color:black;background-color:black";
			break;
	}
	switch ($overlay['trailtype']){
		case 1:
			$overlay_type = "Cross-Country";
			break;
		case 2:
			$overlay_type = "Freeride";
			break;
		case 3:
			$overlay_type = "Downhill";
			break;
		case 4:
			$overlay_type = "Dirt Jumps";
			break;
		case 5:
			$overlay_type = "Pumptrack";
			break;
		case 6:
			$overlay_type = "Four-Cross";
			break;
	}
	
	if ($overlay['no_section'] == 0){
		//No sections added, if logged in, allow user to add data
		echo '<a href="#" style="color:black;">';
	} elseif ($overlay['no_section'] == 1) {
		//One section added, links straight to section
		echo '<a href="./trailinfo.php?centre='. $trailcentre .'&trail='. $overlay['trailcode'] .'&sec='. $overlay['startsection'] .'">';
	} else {
		//Multiple sections added, go to normal page
		echo '<a href="./trailinfo.php?centre='. $trailcentre .'&trail='. $overlay['trailcode'] .'">';
	}
	
		echo '<div id="mapoverlay" style="'. $overlay_colour .'">';
			echo $overlay['trailname'];
			echo '<hr style="height:2px;border-width:0;width:100%;'. $overlay_hr .';margin:5px 0;">';
			echo $overlay['traillength'] ."m (". round($overlay['traillength']/1000,1) ."km)<br>";
			if($overlay['trailclimb'] == 0 && $overlay['traildescent'] == 0){
				echo "No altitude data<br>";
			} else {
				echo "Climb: ". $overlay['trailclimb'] ."m Descent: ". $overlay['traildescent'] ."m<br>";
			}
			echo $overlay_type ."<br>";
			if ($overlay['no_section'] != 0){
				echo "Number of Sections: ". $overlay['no_section'] ."<br>";
				echo '<hr style="height:2px;border-width:0;width:100%;'. $overlay_hr .';margin:5px 0;">';
				echo "View This Trail";
			} else {
				echo "No section data yet<br>";
				echo '<hr style="height:2px;border-width:0;width:100%;'. $overlay_hr .';margin:5px 0;">';
				echo "Add info for this trail?";
			}
		echo "</div>";
	echo "</a>";
	
	/*$segmentcount = 0;
	$totaltraildistance = 0;
	include ('./includes/trailname.php');	
	while ($idents = mysqli_fetch_array($sectotal)){
		if (strpos($idents['trail_idents'], $trailtitle) !== false) {
			$segmentcount++;
			$totaltraildistance = $totaltraildistance + $idents['trlength'];
		}
	}

	switch ($segmentcount){
		case 0:
			//Does not link if no sections
			echo '<div id="mapoverlay">';
				echo $route;
				echo '<hr style="height:2px;border-width:0;width:100%;color:#353b56;background-color:#353b56;margin:5px 0;">';
				echo round($totaltraildistance/1000,1) ." km<br>";
				echo $routegrade .' graded <br>';
				echo $routetype ."<br>";
				echo "No Sections added<br>";
				echo '<hr style="height:2px;border-width:0;width:100%;color:#353b56;background-color:#353b56;margin:5px 0;">';
				//Eventually add user ability to add sections
				echo '<a href="#" style="color:black;">Add info for this trail?</a>';
			echo '</div>';
			break;
		case 1:
			//Single section, add the section name to url to go direct to it
			echo '<a href="./trailinfo.php?centre='. $trailcentre .'&trail='. $trailtitle .'&sec='. $routestart .'">';
				echo '<div id="mapoverlay">';
					echo $route;
					echo '<hr style="height:2px;border-width:0;width:100%;color:#353b56;background-color:#353b56;margin:5px 0;">';
					echo round($totaltraildistance/1000,1) ." km<br>";
					echo $routegrade .' graded <br>';
					echo $routetype ."<br>";
					echo $segmentcount ." Sections<br>";
					echo '<hr style="height:2px;border-width:0;width:100%;color:#353b56;background-color:#353b56;margin:5px 0;">';
					echo 'View this Trail';
				echo '</div>';
			echo '</a>';
			break;
		default:
			//Standard layout
			echo '<a href="./trailinfo.php?centre='. $trailcentre .'&trail='. $trailtitle .'">';
				echo '<div id="mapoverlay">';
					echo $route;
					echo '<hr style="height:2px;border-width:0;width:100%;color:#353b56;background-color:#353b56;margin:5px 0;">';
					echo round($totaltraildistance/1000,1) ." km<br>";
					echo $routegrade .' graded <br>';
					echo $routetype ."<br>";
					echo $segmentcount ." Sections<br>";
					echo '<hr style="height:2px;border-width:0;width:100%;color:#353b56;background-color:#353b56;margin:5px 0;">';
					echo 'View this Trail';
				echo '</div>';
			echo '</a>';
			break;
	}*/
?>