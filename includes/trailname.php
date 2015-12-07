<?php
	$nameloop = 0;
	while ($nameloop < $trailarrlength){
		$nameset = $trails[$nameloop];
		
		$trailnamer = (explode(",",$nameset));
		
		if ($trailnamer[4] == $trailtitle){
			$route = $trailnamer[0];
			$routegrade = $trailnamer[2];
			$routetype = $trailnamer[3];
			$routestart = $trailnamer[6];
		}
		$nameloop++;
	}
?>