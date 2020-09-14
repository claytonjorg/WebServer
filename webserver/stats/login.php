<?php
    require ('steamauth/steamauth.php');
	# You would uncomment the line beneath to make it refresh the data every time the page is loaded
	// unset($_SESSION['steam_uptodate']);
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>ckL-Gaming</title>
	<meta name="description" content="www.ckL-Gaming.com">
	<meta name="keywords" content="ckl, ckL, ckL-Gaming, csgo, kf2, killing floor, killing floor 2, mc, minecraft">
	<link href="css/style_stats_login.css" rel="stylesheet" type="text/css">
	
	<link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Open+Sans|Raleway|Candal">
	<link rel="stylesheet" type="text/css" href="css/font-awesome.min.css">
</head>

<body>
	
	<div class="header">
		<div class="stats_navbar_col" style="width: 20%; background: white;">
			<h1 style="user-select: none;">Stats // ckL-Gaming</h1>
		</div>
	</div>
	
	<div class="main">
		<div class="main-section-stats">
			<div class="main-stats-row">
				<div class="main-stats-column">
					<div class="stats_navbar_row">
						<div class="stats_navbar_col" style="width: 20%">
							<a href="https://www.ckl-gaming.com/" ><img src="Images/home.png" class="center" width="30px" height="30px" style="vertical-align: middle;"> ckL-Gaming.com</a>
							<a href="index.php" ><img src="Images/server2.png" class="center" width="30px" height="30px" style="vertical-align: middle;"> Servers</a>
							<a href="scoreboards.php?id=10mans" ><img src="Images/csgo-icon.png" class="center" width="30px" height="30px" style="vertical-align: middle;"> Scoreboards</a>
							<a href="leaderboards.php?id=10mans" ><img src="Images/csgo-icon.png" class="center" width="30px" height="30px" style="vertical-align: middle;"> Leaderboards</a>
							<a href="https://bans.ckl-gaming.com/" ><img src="Images/csgo-icon-x.png" class="center" width="30px" height="30px" style="vertical-align: middle;"> Sourcebans</a>
							<a href="stats_coming_soon.php" ><img src="Images/minecraft.png" class="center" width="30px" height="30px" style="vertical-align: middle;"> World-Map</a>
							<a href="stats_coming_soon.php" ><img src="Images/minecraft-x.png" class="center" width="30px" height="30px" style="vertical-align: middle;"> Bans</a>
						</div>
						<div class="stats_navbar_col" style="width: 80%; background: #ECF0F0; padding-left: 2%; padding-right: 2%;">
							<div class="title-navbar">
								<p>ckL-Gaming.com<br>Stats - Login</p>
							</div>
							<div class="title-login">
								<p>To access your server stats please login with steam.</p>
								<?php
									if(!isset($_SESSION['steamid'])) 
									{
										loginbutton();
									}
								?> 
								<!--
								<a href="" ><img class="mr-3" src="Images/loginsteam.png" alt=""></a>
								-->
							</div>
							<div class="title-test">
							
							</div>
							<div class="footer">
								<p>&#169 2019-2020 ckL-Gaming. All rights reserved.<br>Developed By: SeaC</p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	
	
</body>

</html>