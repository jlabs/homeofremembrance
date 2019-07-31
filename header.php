<?php
	session_start();
	if ($_SESSION['user_id'] == null)
	{
		header("location: frontdoor.php");
	}

	require_once("config/db.php");	

	$pagename = basename($_SERVER['PHP_SELF']);
	$pageTitle = "";
?>

<!DOCTYPE html>
	<html>
		<head>
			<title> 
				<?php echo "Home of Remembrance - ".$pageTitle; ?>
			</title>			
			<meta name="viewport" content="width=device-width, initial-scale=1.0">
			<!--<meta http-equiv="X-UA-Compatible" content="IE=edge">-->			
			<link href="styles/custom.css" rel="stylesheet" type="text/css">		
		</head>	
	<body>
	
		<!-- Static navbar -->
		<nav class="navbar navbar-default navbar-fixed-top">
			<div class="container">             
				<div class="navbar-collapse collapse">
					<ul class="nav navbar-nav">          
						<li class="dropdown 
							<?php
								if($pagename=="frontdoor.php"||
									$pagename=="help.php"||
									$pagename=="contact.php")
									{
										echo "active";
									}
							?>">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">Home <b class="caret"></b></a>
							<ul class="dropdown-menu">
								<li class="<?php if($pagename == "frontdoor.php"){echo "active";} ?>"><a href="frontdoor.php">Home</a></li>
								<li class="<?php if($pagename == "help.php"){echo "active";} ?>"><a href="#">Help</a></li>
								<li class="<?php if($pagename == "contact.php"){echo "active";} ?>"><a href="#">Contact Us</a></li>
								<li class="<?php if ($pagename == "tell-us.php") echo "active"; ?>"><a href="tell-us.php">Tell us</a></li>
								<li class="divider"></li>
								<li class="<?php if ($pagename == "") echo "active"; ?>"><a href="/jobs">Jobs List</a></li>
								<li class="divider"></li>
								<li>
									<a href="frontdoor.php?logout">Logout</a>
								</li>
							</ul>
						</li>				
						<li class="<?php if($pagename=="my-life.php"){echo "active";} ?>"><a href="my-life.php">My Life</a></li>
						<li class="<?php if($pagename=="gallery.php"){echo "active";} ?>"><a href="gallery.php">Gallery</a></li>
						<li class="dropdown 
							<?php 
								if($pagename=="about-me.php"
									||$pagename=="bucketlist.php" 
									||$pagename=="time-capsule.php" 
									||$pagename=="vault.php" 
									||$pagename=="treasured-memories.php" 
									||$pagename=="details.php") 
									{
										echo "active";
									} 
							?>">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">Profile <b class="caret"></b></a>
							<ul class="dropdown-menu" role="menu">
								<li class="<?php if($pagename == 'about-me.php') {echo "active";} ?>">
									<a href="about-me.php">About Me</a>
								</li>
								<li class="<?php if($pagename == "bucketlist.php") {echo "active";} ?>">
									<a href="bucketlist.php">My Bucket List</a>
								</li>
								<li class="<?php if($pagename == "time-capsule.php") {echo "active";} ?>">
									<a href="time-capsule.php">Time Capsule</a>
								</li>
								<li class="<?php if($pagename == "vault.php") {echo "active";} ?>">
									<a href="vault.php">Vault</a>
								</li>
								<li class="<?php if($pagename == "treasured-memories.php"){echo "active";} ?>">
									<a href="treasured-memories.php">Treasured Memories</a>
								</li>
								<li class="divider"></li>
								<li>
									<a href="details.php">Account Details</a>
								</li>
							</ul>
							<li class="<?php if($pagename=="tree.php"){echo "active";} ?>">
								<a href="tree.php">Family Tree</a>
							</li>
						</li>
						<li>
							<a href="#">
								<?php echo $pageTitle; ?>
							</a>
						</li>
						<li>
							<?php echo $page_action; ?>
						</li>
					</ul>				
					<ul class="nav navbar-nav navbar-right">
						<li>
							<a href="http://en.wikipedia.org/wiki/Software_testing#Alpha_testing" target="_blank">
								ALPHA
							</a>
						</li>
						<form class="navbar-form pull-left" method="post" action="search.php">
							<input disabled type="text" class="form-control" style="width: 200px;" name="SearchText">
							<button type="submit" 
								class="btn btn-default">Search</button>
						</form>
					</ul>
				</div><!--/.nav-collapse -->
			</div>
		</nav>
		
		<!--
		<nav class="navbar navbar-default navbar-fixed-top" style="margin-top: 50px;">
			<div class="container">             
				<div class="navbar-collapse collapse">
					<ul class="nav navbar-nav">
						<li><a href="#">Test</a></</li>
					</ul>
				</div>
			</div>
		</nav>
		-->
			
		<!-- block to drop the content below the nav bar-->
		<div class="headerSpacer"></div>