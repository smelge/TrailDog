<?php 
	require_once ('./includes/essentials.php');
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Traildog</title>
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="description" content="MTB Trail Database">
		<meta name="keywords" content="mtb,mountain,bike,cycling,cross,country,xc,downhill,dh,freeride,united,kingdom,uk,ae,forest,scotland">
		<meta name="author" content="Tavy Fraser">
		<link rel="icon" href="./assets/tdicon.png" type="image/x-icon">
		<link rel="stylesheet" href="./css/font-awesome.min.css">
		<!-- Bootstrap -->
		<link href="css/bootstrap.min.css" rel="stylesheet">
		<!--New css-->
		<link rel="stylesheet" type="text/css" href="css/styles.css"/>
		
		<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
			<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
			<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->
		<?php
			$random_video_check = '';
			
			while ($random_video_check == ''){
				$random_video_set = mysqli_query($dblink, "SELECT * FROM traildata ORDER BY rand() limit 100");
				$random_video_check = mysqli_fetch_array($random_video_set);
			
				if ($random_video_check['tryoutube'] != ''){
					if ($random_video_check['trtitle'] != 'default'){
						$rnd_vid = $random_video_check['tryoutube'];
					}
				}
				$random_video_check = $random_video_check['tryoutube'];
			}
			//$rnd_vid = $random_video_check['tryoutube'];
			
			$featured_trail_set = mysqli_query($dblink,"SELECT * FROM featured");
		?>
		
		<script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
	</head>
	
	<body>
		<div class="container-fluid">
			<?php include "./includes/newheader.php"; ?> <!---Calls all header sections-->
			<div class="row">	
				<div class="col-sm-12">
					<div class="col-sm-9">
						<div class="row">
							<!--<div class="slider" style="border:2px solid black;margin-right:10px;height:374px;overflow:hidden;">
								<img width="925" src="./assets/carousel/slider1.jpg"/>
							</div>-->
							
							
							
							<div id="myCarousel" class="carousel slide" data-ride="carousel" style="border:2px solid black;margin-right:10px;height:374px;overflow:hidden;">
								<!-- Carousel indicators -->								
								<ol class="carousel-indicators">									
									<li data-target="#myCarousel" data-slide-to="0" class="active"></li>									
									<li data-target="#myCarousel" data-slide-to="1"></li>									
									<li data-target="#myCarousel" data-slide-to="2"></li>
									<li data-target="#myCarousel" data-slide-to="3"></li>									
									<li data-target="#myCarousel" data-slide-to="4"></li>									
								</ol>   								
								<!-- Carousel items -->								
								<div class="carousel-inner">									
									<div class="item active">										
										<img width="925" src="./assets/carousel/slider1.jpg" alt="Traildog Slider Images"/>			
									</div>									
									<div class="item">										
										<img width="925" src="./assets/carousel/slider2.jpg" alt="Traildog Slider Images"/>							
									</div>									
									<div class="item">										
										<img width="925" src="./assets/carousel/slider3.jpg" alt="Traildog Slider Images"/>							
									</div>
									<div class="item">										
										<img width="925" src="./assets/carousel/slider4.jpg" alt="Traildog Slider Images"/>							
									</div>									
									<div class="item">										
										<img width="925" src="./assets/carousel/slider5.jpg" alt="Traildog Slider Images"/>							
									</div>									
								</div>								
								<!-- Carousel nav -->								
								<a class="carousel-control left" href="#myCarousel" data-slide="prev">								
								<span class="glyphicon glyphicon-chevron-left"></span>								
								</a>								
								<a class="carousel-control right" href="#myCarousel" data-slide="next">								
								<span class="glyphicon glyphicon-chevron-right"></span>								
								</a>								
							</div>
						</div>
						<div class="row" style="margin-top:10px;">
							
							<?php
								while ($featured_trail = mysqli_fetch_array($featured_trail_set)){
									if ($today_date >= $featured_trail['from'] && $today_date < $featured_trail['until']){
										$featureset = $featured_trail['trailcentre'];										
									}
								}
								$featuredcentre = mysqli_query($dblink,"SELECT * FROM maplocations WHERE link = '$featureset'");
								$feat = mysqli_fetch_array($featuredcentre);
							?>							
							
							<div class="col-sm-6" id="rndtrail" style="border:2px solid black; padding:0;">
								<div class="random-header">Featured Trailcentre</div>
								<div class="rccentre" style="border:5px solid black;">
									<?php
										if ($feat['name'] != ''){
											echo '<a href="./trailhead.php?centre='. $feat['link'] .'">';
											echo '<div class="featuredname">'. $feat['name'] .'</div>';
											echo '<img style="width:100%;" src="./assets/trailimage/'. $feat['cover_image'] .'.jpg" alt="'. $feat['name'] .'"/></a>';
										} else {
											echo '<a href="./directory.php">';
											echo '<div class="featuredname">Whoops!</div>';
											echo '<img style="width:100%;" src="./assets/trailimage/whoops.jpg" alt="The Featured Trail has exploded."/></a>';
										}
									?>
								</div>
							</div>
							<div class="col-sm-6" id="rndvid" style="padding:0;height:265px;">
								<!--<div class="random-header" style="border-right:2px solid black;border-top:2px solid black;border-left:2px solid black;margin:0 10px 0 20px;">Random Video</div>-->
								<div class="rccentre" style="margin:0 10px 0 20px;background:black;border:5px solid black;height:259px;">
									<div class="embed-responsive embed-responsive-16by9">
										<iframe class="embed-responsive-item" src="http://www.youtube.com/embed/<?php echo $rnd_vid;?>" allowfullscreen></iframe>
									</div>
								</div>
								
							</div>
						</div>
					</div>
					<div class="col-sm-3" style="border:2px solid black;background:#cccccc;padding:0;">
						<div id="twitters">
							<a class="twitter-timeline" height="639" style="float:right;" href="https://twitter.com/TraildogFilms"  data-widget-id="435588644733087744">
								Twitter Feed is Loading
							</a>
							<script>
								!function(d,s,id){
									var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';
									if(!d.getElementById(id)){
										js=d.createElement(s);
										js.id=id;
										js.src=p+"://platform.twitter.com/widgets.js";
										fjs.parentNode.insertBefore(js,fjs);
									}
								}
								(document,"script","twitter-wjs");
							</script>
						</div>						
					</div>
					<div class="row" style="margin-top:10px;">
						<div class="col-sm-12" style="ext-align:center;">
							<div class="col-sm-4" style="min-width:320px;background:#b6cee4;">
								<!-- ad 1 -->
								<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
								<!-- traildog homepage -->
								<ins class="adsbygoogle"
								style="display:inline-block;width:320px;height:50px"
								data-ad-client="ca-pub-3065942552061354"
								data-ad-slot="9006117297"></ins>
								<script>
									(adsbygoogle = window.adsbygoogle || []).push({});
								</script>
							</div>
							<div class="col-sm-4" style="min-width:320px;background:#b6cee4;">
								<!-- ad 2 -->
								<script async s
								rc="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
								<!-- traildog homepage 2 -->
								<ins class="adsbygoogle"
								style="display:inline-block;width:320px;height:50px"
								data-ad-client="ca-pub-3065942552061354"
								data-ad-slot="8866516493"></ins>
								<script>
									(adsbygoogle = window.adsbygoogle || []).push({});
								</script>
							</div>
							<div class="col-sm-4" style="min-width:320px;background:#b6cee4;">
								<!-- ad 3 -->
								<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
								<!-- traildog homepage 3 -->
								<ins class="adsbygoogle"
								style="display:inline-block;width:320px;height:50px"
								data-ad-client="ca-pub-3065942552061354"
								data-ad-slot="2819982892"></ins>
								<script>
									(adsbygoogle = window.adsbygoogle || []).push({});
								</script>
							</div>
						</div>
					</div>
				</div>
			</div>
			<center><?php include "./includes/newfooter.php"; ?></center>
		</div>		
	</body>
</html>