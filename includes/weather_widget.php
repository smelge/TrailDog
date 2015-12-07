<?php //Weather Widget
	$json_array = json_decode(file_get_contents("http://datapoint.metoffice.gov.uk/public/data/val/wxfcs/all/json/".$centre['weather']."?res=3hourly&key=012840cc-4116-4d0c-afc5-e8019b0bc70e"), true);
	$json_daily = json_decode(file_get_contents("http://datapoint.metoffice.gov.uk/public/data/val/wxfcs/all/json/".$centre['weather']."?res=daily&key=012840cc-4116-4d0c-afc5-e8019b0bc70e"), true);
	
		$daily_forecast = $json_daily['SiteRep']['DV']['Location']['Period'];
		$hourly = $json_array['SiteRep']['DV']['Location']['Period'];
		$weather_location = $json_daily['SiteRep']['DV']['Location']['name'];
		$curr_time = date("G");
				
	echo "<div class='row' style='padding:0 15px;'>";
		echo "<div class='col-sm-12 weather-modal' style='padding:0;border:1px solid black;height:130px;'>";
			$day_loop = 0;
			while ($day_loop <5){
				//Set day
				$today_date = $hourly[$day_loop]['value'];
				$setdate = (explode("Z",$today_date)); // YYYY-MM-DDZ
				$dayset = $setdate[0];				
				$current_day = date('l', strtotime($dayset));
				// End set day
					
				// Today Weather Content
				$curr_weather = $daily_forecast[$day_loop]['Rep']['0']['W'];
				$curr_temp = $daily_forecast[$day_loop]['Rep']['0']['Dm'];
				$curr_wind = $daily_forecast[$day_loop]['Rep']['0']['S'];
				$curr_wind_direction = $daily_forecast[$day_loop]['Rep']['0']['D'];
						
				echo "<a data-toggle='modal' data-target='#HourlyModal-".$day_loop."'>";
					echo "<div class='col-sm-2 padding weather-block'>";
						echo "<div class='col-sm-12 padding' style='height:100%;'>"; //container for weather stuff
							echo "<div class='col-sm-12 padding' style='border-bottom:2px solid black;padding:5px;'>"; //Header
							if ($day_loop == 0){
								if ($curr_wind >= 20 || $curr_weather == 13 || $curr_temp < 0 || $curr_weather == 14 || $curr_weather == 15 || $curr_weather == 25 || $curr_weather == 26 || $curr_weather == 27 || $curr_weather == 28 || $curr_weather == 29 || $curr_weather == 30){
									echo "<i class='fa fa-exclamation-triangle fa-2x' style='position:absolute;margin:-3px;'></i>";
								}
								echo "<center><b>Today</b></center>";
							} else {
								if ($curr_wind >= 20 || $curr_weather == 13 || $curr_temp < 0 || $curr_weather == 14 || $curr_weather == 15 || $curr_weather == 25 || $curr_weather == 26 || $curr_weather == 27 || $curr_weather == 28 || $curr_weather == 29 || $curr_weather == 30){
									echo "<i class='fa fa-exclamation-triangle fa-2x' style='position:absolute;margin:-3px;'></i>";
								}
								echo "<center><b>".$current_day."</b></center>";
							}
							echo "</div>";
							echo "<div class='col-sm-12 padding' style='height:auto;text-align:center;'>";	
								echo "<div class='col-sm-6 padding' style='height:auto;'>"; //Left hand column
									echo "<div class='col-sm-12 padding' style='height:50%;margin-bottom:5px;'>";//Upper box
										include ('./includes/weathericon.php');
									echo "</div>";
									echo "<div class='col-sm-12 weather-head'>";//Lower box
										echo $curr_temp."&degc";
									echo "</div>";
								echo "</div>";
								echo "<div class='col-sm-6 padding' style='height:auto;'>"; //Right hand column
									echo "<div class='col-sm-12' style='height:50%;margin-bottom:5px;'>";//Upper box
										include ('./includes/wind_direction.php');
									echo "</div>";
									echo "<div class='col-sm-12 weather-head'>";//Lower box
										echo $curr_wind." mph";
									echo "</div>";
								echo "</div>";
							echo "</div>";	
						echo "</div>";
						// End Today Weather content								
					echo "</div>";
				echo "</a>";
				// Hourly modal
				echo "<div class='modal fade' id='HourlyModal-".$day_loop."' tabindex='-1' role='dialog' aria-labelledby='HourlyModal-".$day_loop."Label' aria-hidden='true'>";
					echo "<div class='modal-dialog'>";
						echo "<div class='modal-content'>";
							echo "<div class='modal-header'>";
								echo "<button type='button' class='close' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>&times;</span></button>";
								if ($day_loop == 0){
									echo "<h4 class='modal-title' id='HourlyModal-".$day_loop."Label'>Today</h4>";				
								} else {
									echo "<h4 class='modal-title' id='HourlyModal-".$day_loop."Label'>".$current_day."</h4>";
								}
							echo "</div>";
							echo "<div class='modal-footer'>";		
								//Hourly forecast
																					
								// 3 Hourly Loop
								echo "<div class='col-sm-12'>";				
									$hr_loop = 0;
									$hr_cond = $hourly[$day_loop]/*This is day*/['Rep'][$hr_loop]/*This corresponds to 3hr increment*/['W'];
									
									if ($curr_time == 0 || $curr_time == 1 || $curr_time == 2){$first_hr_loop = 0;}
									elseif ($curr_time == 3 || $curr_time == 4 || $curr_time == 5){$first_hr_loop = 1;}
									elseif ($curr_time == 6 || $curr_time == 7 || $curr_time == 8){$first_hr_loop = 2;}
									elseif ($curr_time == 9 || $curr_time == 10 || $curr_time == 11){$first_hr_loop = 3;}
									elseif ($curr_time == 12 || $curr_time == 13 || $curr_time == 14){$first_hr_loop = 4;}
									elseif ($curr_time == 15 || $curr_time == 15 || $curr_time == 17){$first_hr_loop = 5;}
									elseif ($curr_time == 18 || $curr_time == 19 || $curr_time == 20){$first_hr_loop = 6;}
									elseif ($curr_time == 21 || $curr_time == 22 || $curr_time == 23){$first_hr_loop = 7;}
											
									echo "<div class='table-responsive'>";
										echo "<table class='table table-bordered'>";
											echo "<tr>";
												echo "<th><center>Time</center></th>";
												echo "<th><center>Weather</center></th>";
												echo "<th><center>Temp.</center></th>";
												echo "<th><center>Wind Dir.</center></th>";
												echo "<th><center>Wind Speed</center></th>";
											echo "</tr>";
											
											while ($hr_cond != '' && $hr_loop < 9){					
												$hr_cond = $hourly[$day_loop]/*This is day*/['Rep'][$hr_loop]/*This corresponds to 3hr increment*/['W'];
												$hr_temp = $hourly[$day_loop]/*This is day*/['Rep'][$hr_loop]/*This corresponds to 3hr increment*/['T'];
												$hr_wspeed = $hourly[$day_loop]/*This is day*/['Rep'][$hr_loop]/*This corresponds to 3hr increment*/['S'];
												$hr_wdir = $hourly[$day_loop]/*This is day*/['Rep'][$hr_loop]/*This corresponds to 3hr increment*/['D'];
												$end_chk = $hourly[$day_loop]/*This is day*/['Rep'][$hr_loop]['W'];
												if ($hr_cond != ''){	
													if ($day_loop == 0){
														switch($first_hr_loop){ //define which hour period is viewed
															case 0: $period = '0000 - 0300';break;
															case 1: $period = '0300 - 0600';break;
															case 2: $period = '0600 - 0900';break;
															case 3: $period = '0900 - 1200';break;
															case 4: $period = '1200 - 1500';break;
															case 5: $period = '1500 - 1800';break;
															case 6: $period = '1800 - 2100';break;
															case 7: $period = '2100 - 0000';break;
														}								
													} else {
														switch($hr_loop){ //define which hour period is viewed
															case 0: $period = '0000 - 0300';break;
															case 1: $period = '0300 - 0600';break;
															case 2: $period = '0600 - 0900';break;
															case 3: $period = '0900 - 1200';break;
															case 4: $period = '1200 - 1500';break;
															case 5: $period = '1500 - 1800';break;
															case 6: $period = '1800 - 2100';break;
															case 7: $period = '2100 - 0000';break;
														}
													}
													echo "<tr style='text-align:center;'>";
														echo "<td>".$period."</td>";
														if ($hr_cond == 13 || $hr_cond == 14 || $hr_cond == 15 || $hr_cond == 25 || $hr_cond == 26 || $hr_cond == 27 || $hr_cond == 28 || $hr_cond == 29 || $hr_cond == 30){
															echo "<td class='danger'>";
														} else {
															echo "<td>";
														}
															include ('./includes/weather_summary_condition.php');
														echo "</td>";
														if ($hr_temp < 0){
															echo "<td class='info'>";
														} elseif ($hr_temp > 30){
															echo "<td class='warning'>";
														} else {
															echo "<td>";
														}
														echo $hr_temp."&degc</td>";
														echo "<td>";
															include ('./includes/wind_summary.php');
														echo "</td>";
														if ($hr_wspeed >= 20 && $hr_wspeed < 50){ 
															echo "<td class='warning'>";
														} elseif ($hr_wspeed >= 50){
															echo "<td class='danger'>";
														} else {
															echo "<td>";
														}
														echo $hr_wspeed." mph</td>";
													echo "</tr>";
													$hr_loop++;
													$first_hr_loop++;
												}										
											// End 3 hourly loop												
											}
										echo "</table>";
									echo "</div>";
								echo "</div>";
									
								//End of hourly forecast									
							echo "</div>";
						echo "</div>";
					echo "</div>";
				echo "</div>";
					
				$day_loop++;
			}
			echo "<div class='col-sm-2' style='padding:5px;border:1px solid black;text-align:center;background:#cebd95;height:100%;'>";
				echo "<b>".$weather_location."</b>";
				echo "<hr style='border:1px solid black;margin:5px 5px 30px 5px;'>Data retrieved from<br><a href='http://www.metoffice.gov.uk' target='_blank'>The MetOffice</a>";
			echo "</div>";
		echo "</div>";
	echo "</div>";
?>