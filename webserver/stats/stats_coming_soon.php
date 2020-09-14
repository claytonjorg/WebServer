<?php
    require ('steamauth/steamauth.php');
	include_once 'convertSteamID.php';
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
	<link href="css/style_stats_coming_soon.css" rel="stylesheet" type="text/css">
	
	<link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Open+Sans|Raleway|Candal">
	<link rel="stylesheet" type="text/css" href="css/font-awesome.min.css">
</head>

<body>
	
	<div class="header">
		<div class="stats_navbar_col" style="width: 20%; background: white;">
			<h1 style="user-select: none;">Stats // ckL-Gaming</h1>
		</div>
		<?php
			if(!isset($_SESSION['steamid'])) 
			{
				echo '<a href="stats_login.php" ><i class="fa fa-user-circle"></i> Login</a>';
			}
			else
			{
				include ('steamauth/userInfo.php');
				
				$profile_id = $steamprofile['steamid'];
				$profileID = IDfrom64($profile_id);
				
				echo '<div class="model-container">
							<a href="profile.php?user='.$profileID.'&id=10mans" style="padding-top: 0px; padding-left: 0px; font-size:15px;"><button class="profilebtn" id="myBtn" style="margin-right: 2%;"> <img src="' . $steamprofile['avatarfull'] .'" class="img-responsive" width="40px" height="40px" style="border-radius: 50%; vertical-align: middle; margin-right: 6px;"> <b> ' . $steamprofile['personaname'] . ' </b></button></a>
							<form action="" method="get"><button name="logout" type="submit" class="profilebtn" id="myBtn" style="margin-right: 0%;"> Logout <i class="fa fa-sign-out"></i> </button></form>
					 </div>';
			}
		?>
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
								<p>ckL-Gaming.com<br>Stats - 404</p>
							</div>
							<div class="title-login">
								<img src="Images/404.png" class="center" width="400px" height="180px" style="margin-top: 30px; border-radius: 15px;">
								<p style="padding-left: 17%; padding-right: 17%;">Oops - Page Not Found<br>
								The page you are looking for might have been removed had its name changed or is temporaily unavailable.</p>
								
								<p style="text-align: left; padding-left: 17%; padding-right: 17%;">Please try the following:<br>
								1. If you typed the page address into the address bar, make sure that it is spelled correctly.<br>
								2. If you clicked a link from an outside source, check the date of the article. Chances are the link is expired or no longer available.<br>
								3. Click the HERE or any of the tabs on the top of the navbar to be brought to our home page.</p>
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