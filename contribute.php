<?php 
	require_once ('./includes/essentials.php');
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<?php
			$centre_array_find = filter_input(INPUT_GET, 'centre', FILTER_SANITIZE_SPECIAL_CHARS);
			$type = filter_input(INPUT_GET, 'type', FILTER_SANITIZE_SPECIAL_CHARS);
			$filter = filter_input(INPUT_GET, 'filter', FILTER_SANITIZE_SPECIAL_CHARS);
			
			$centre_array_set = mysqli_query($dblink,"SELECT * FROM maplocations WHERE link = '$centre_array_find'");
			$centre_array = mysqli_fetch_array($centre_array_set);
			
			$centre = $centre_array['link'];
			
		?>
		<title>Traildog Contribute - <?php echo $centre_array['name'];?></title>
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="description" content="MTB Trail Database">
		<meta name="keywords" content="mtb,mountain,bike,cycling,cross,country,xc,downhill,dh,freeride,united,kingdom,uk,ae,forest,scotland">
		<meta name="author" content="Tavy Fraser">
					
		<!-- Bootstrap -->
		<link href="css/bootstrap.min.css" rel="stylesheet">
		<!--New css-->
		<link rel="stylesheet" type="text/css" href="css/styles.css"/>		
		<link rel="icon" href="./assets/tdicon.png" type="image/x-icon">
		<link rel="stylesheet" href="./css/font-awesome.min.css">
		
		<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
			<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
			<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->
		
		<script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
	</head>

<body>
	<div class="container-fluid">
		<?php include "./includes/newheader.php"; ?> <!---Calls all header sections-->
		<div class="row">
			<div class="col-xs-12">
				<?php
					if ($context['user']['is_guest']){
						echo "You really shouldn't be here. Please log in to edit Trailcentres";
					} else {
						if ($type == 'centre'){
							//Add or edit a trailcentre
						} elseif ($type == 'trail'){
							// Adding or Editing a trail
							
							if ($filter == ''){ // Nothing has been selected
								echo '<a href="?centre='. $centre_array_find .'&type='. $type .'&filter=add" class="btn btn-primary" role="button" style="margin:0 5px 0 0;">Add a Trail</a>';
								echo '<a href="?centre='. $centre_array_find .'&type='. $type .'&filter=edit" class="btn btn-primary" role="button" style="margin:0 5px;" disabled="disabled">Edit a Trail</a>';
							} elseif ($filter == 'add'){ //Trail is being added
				?>
								All edits made will require verification before they appear on the site. This is simply to check that information added 
								does not contain advertising, anything malicious, or any stuff that will damage or break the site.
								<hr style="height:1px;border-width:0;width:100%;color:black;background-color:black;margin:5px 0;">
								<form enctype="multipart/form-data" action="./addtrail.php" method="POST">
									<b>Trailcentre: <?php echo $centre_array['name'];?></b>
									<hr style="height:1px;border-width:0;width:100%;color:black;background-color:black;margin:5px 0;">
									Trail Name:<br>
									<input type="text" name="trailname" required autofocus><br>
									<!-- trailcode = trailname(nospaces) -->
									<input type="hidden" name="trailcentre" value="<?php echo $centre_array['link'];?>">
									<hr style="height:1px;border-width:0;width:100%;color:black;background-color:black;margin:5px 0;">
									<b>Trail Details</b><br><br>
									Length:<br>
									<input type="number" name="traillength" required>(m)<br>
									Climb:<br>
									<input type="number" name="trailclimb">(m)<br>
									Descent:<br>
									<input type="number" name="traildescent">(m)<br>
									Trail Grade:<br>
									<select name="trailgrade" required>
										<option value="1">Green</option>
										<option value="2">Blue</option>
										<option value="3">Red</option>
										<option value="4">Black</option>
										<option value="5">Orange</option>
										<option value="6">Skills</option>
									</select><br>
									Trail Type:<br>
									<select name="trailtype" required>
										<option value="1">Cross Country (xc)</option>
										<option value="2">Freeride (fr)</option>
										<option value="3">Downhill (dh)</option>
										<option value="4">Dirt Jumps (dj)</option>
										<option value="5">Pumptrack</option>
										<option value="6">FourCross (4x)</option>
									</select>
									<hr style="height:1px;border-width:0;width:100%;color:black;background-color:black;margin:5px 0;">
									Upload a kml (GPS Route)<br>
									<input type="file" name="routekml"><br><br>
									First Section in Trail:<br>
									<select name="firstsection" required>
										<?php
											$trail_sections_set = mysqli_query($dblink, "SELECT DISTINCT * FROM traildata WHERE centre = '$centre' ORDER BY trtitle ASC");
											$count_sections = mysqli_num_rows($trail_sections_set);
											if ($count_sections == 0){
												echo '<option value="none">No Sections Added Yet</option>';
											} else {
												while ($trail_sections = mysqli_fetch_array($trail_sections_set)){
													echo '<option value="'. $trail_sections['trcode'] .'">'. $trail_sections['trtitle'] .'</option>';
												}
											}
										?>
									</select>
									<hr style="height:1px;border-width:0;width:100%;color:black;background-color:black;margin:5px 0;">
									Submitted by: <?php echo $context['user']['name'];?>
									<hr style="height:1px;border-width:0;width:100%;color:black;background-color:black;margin:5px 0;">
									<input type="hidden" name="user" value="<?php echo $context['user']['name'];?>">
									<br>
									<input type="reset" value="Reset">
									<input type="submit" value="Submit">
								</form>
				<?php
							} else { // Trail is being edited
								//Edit Trail dialogue
							}
						} elseif ($type == 'section'){
							// Adding a trail section
				?>
							<ul>
								<li></li>
							<ul>
				<?php
						} elseif ($type == 'update'){
							// Adding a trail Update
				?>
							<ul>
								<li></li>
							<ul>
					
				<?php
						} else {
							// Probably shouldn't be here
						}
					}
				?>
			</div>
		</div>
		
		<center><?php include "./includes/newfooter.php"; ?></center> <!--- Calls footer stuff-->
	</div>
</body>
</html>