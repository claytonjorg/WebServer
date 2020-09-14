<?php
    require ('steamauth/steamauth.php');
	require ("scoreboards/scoreboards_config.php");
	include_once 'convertSteamID.php';
	
	if (isset($_GET["id"])) 
	{
		$match_id = $_GET["id"];
	} 
	else 
	{
		$match_id = 0;
	}
	
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
	<link href="css/style_scoreboards_expanded.css" rel="stylesheet" type="text/css">
	
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
				echo '<a href="login.php" ><i class="fa fa-user-circle"></i> Login</a>';
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
							<a href="scoreboards.php" class="active"><img src="Images/csgo-icon.png" class="center" width="30px" height="30px" style="vertical-align: middle;"> <b>Scoreboards</b></a>
							<a href="leaderboards.php" ><img src="Images/csgo-icon.png" class="center" width="30px" height="30px" style="vertical-align: middle;"> Leaderboards</a>
							<a href="https://bans.ckl-gaming.com/" ><img src="Images/csgo-icon-x.png" class="center" width="30px" height="30px" style="vertical-align: middle;"> Sourcebans</a>
							<a href="stats_coming_soon.php" ><img src="Images/minecraft.png" class="center" width="30px" height="30px" style="vertical-align: middle;"> World-Map</a>
							<a href="stats_coming_soon.php" ><img src="Images/minecraft-x.png" class="center" width="30px" height="30px" style="vertical-align: middle;"> Bans</a>
						</div>
						<div class="stats_navbar_col" style="width: 80%; background: #ECF0F0; padding-left: 2%; padding-right: 2%;">
							<div class="title-navbar">
								<p>ckL-Gaming.com<br>Stats - Scoreboards</p>
							</div>
							<div class="title-info">
							<?php
							
								$t_playerId = array();
								$t_playerName = array();
								$t_playerKills = array();
								$t_playerAssists = array();
								$t_playerDeaths = array();
								$t_playerkd = array();
								$t_playerScore = array();
								$t_playerMVPs = array();
								$t_playerPing = array();
								
								$ct_playerId = array();
								$ct_playerName = array();
								$ct_playerKills = array();
								$ct_playerAssists = array();
								$ct_playerDeaths = array();
								$ct_playerkd = array();
								$ct_playerScore = array();
								$ct_playerMVPs = array();
								$ct_playerPing = array();
							
								$match_id = $conn->real_escape_string($match_id);

								$sql = "SELECT sql_matches_scoretotal.*, sql_matches.*
										FROM sql_matches_scoretotal INNER JOIN sql_matches
										ON sql_matches_scoretotal.match_id = sql_matches.match_id
										WHERE sql_matches_scoretotal.match_id = '".$match_id."' ORDER BY sql_matches.score DESC";
							
								$result = $conn->query($sql);
							
								if ($result->num_rows > 0) 
								{
									$t = '';
									$ct = '';
									while ($row = $result->fetch_assoc()) 
									{
										$map_img = array_search($row["map"], $maps);
										
										if ($row["kills"] > 0 && $row["deaths"] > 0) 
										{
											$kdr = round(($row["kills"] / $row["deaths"]), 2); 
										}
										elseif($row["kills"] > 0 && $row["deaths"] == 0)
										{
											$kdr = $row["kills"];
										}
										else
										{
											$kdr = 0;
										}
										
										if ($row["team"] == 2) 
										{
											$t_score = $row["team_2"];
											
											array_push($t_playerId, $row['steamid64']);
											array_push($t_playerName, $row['name']);
											array_push($t_playerKills, $row['kills']);
											array_push($t_playerAssists, $row['assists']);
											array_push($t_playerDeaths, $row['deaths']);
											array_push($t_playerkd, $kdr);
											array_push($t_playerScore, $row['score']);
											array_push($t_playerMVPs, $row['mvps']);
											array_push($t_playerPing, $row['ping']);
										}
										elseif ($row["team"] == 3) 
										{
											$ct_score = $row["team_3"];
											
											array_push($ct_playerId, $row['steamid64']);
											array_push($ct_playerName, $row['name']);
											array_push($ct_playerKills, $row['kills']);
											array_push($ct_playerAssists, $row['assists']);
											array_push($ct_playerDeaths, $row['deaths']);
											array_push($ct_playerkd, $kdr);
											array_push($ct_playerScore, $row['score']);
											array_push($ct_playerMVPs, $row['mvps']);
											array_push($ct_playerPing, $row['ping']);
										}
									}
								}
								
								echo '<a href="scoreboards.php?id=10mans" class="back-btn"><i class="fa fa-chevron-circle-left"></i> Back to Scoreboards</a>';
								echo '
									<img src="'.$map_img.'" class="center" width="100%" height="280px" style="margin-top: 5px; border-radius: 15px; padding-left: 2%; padding-right: 2%; z-index: 5; position:relative; filter: blur(3px);">
									';
								echo '
									 <div class="logo"> 
										<h1 style="font-size: 65px; display: inline; color: #5B768D;">'.$ct_score.'</h1> 
										<h1 style="font-size: 65px; display: inline; color: black;"> : </h1>
										<h1 style="font-size: 65px; display: inline; color: #AC9B66;">'.$t_score.'</h1> 
									</div> 
									';
								
								echo '<div class="servers_row">
										<div class="servers_col" style="width: 100%; background: #5B768D;">
											<p style="color: black; text-align: center;"><b>Counter-Terrorists</b></p>
										</div>
									</div>
									<div class="servers_row">
										<div class="servers_col" style="width: 12.5%; background: white;">
											<p style="color: black; text-align: center;">Player</p>
										</div>
										<div class="servers_col" style="width: 12.5%; background: white;">
											<p style="color: black; text-align: center;">Kills</p>
										</div>
										<div class="servers_col" style="width: 12.5%; background: white;">
											<p style="color: black; text-align: center;">Assists</p>
										</div>
										<div class="servers_col" style="width: 12.5%; background: white;">
											<p style="color: black; text-align: center;">Deaths</p>
										</div>
										<div class="servers_col" style="width: 12.5%; background: white;">
											<p style="color: black; text-align: center; word-spacing: 1px;">K/D Ratio</p>
										</div>
										<div class="servers_col" style="width: 12.5%; background: white;">
											<p style="color: black; text-align: center;">MVPs</p>
										</div>
										<div class="servers_col" style="width: 12.5%; background: white;">
											<p style="color: black; text-align: center;">Score</p>
										</div>
										<div class="servers_col" style="width: 12.5%; background: white;">
											<p style="color: black; text-align: center;">Ping</p>
										</div>
									</div>';
								
								echo '<div class="servers_row">
										<div class="servers_col" style="width: 12.5%; background: #ECF0F0;">
											<a href="https://steamcommunity.com/profiles/'.$ct_playerId[0].'" style="color:black; text-align: center; padding: 10px;"><b>'.$ct_playerName[0].'</b></a>
										</div>
										<div class="servers_col" style="width: 12.5%; background: #ECF0F0;">
											<p style="color: black; text-align: center;"><b>'.$ct_playerKills[0].'</b></p>
										</div>
										<div class="servers_col" style="width: 12.5%; background: #ECF0F0;">
											<p style="color: black; text-align: center;"><b>'.$ct_playerAssists[0].'</b></p>
										</div>
										<div class="servers_col" style="width: 12.5%; background: #ECF0F0;">
											<p style="color: black; text-align: center;"><b>'.$ct_playerDeaths[0].'</b></p>
										</div>
										<div class="servers_col" style="width: 12.5%; background: #ECF0F0;">
											<p style="color: black; text-align: center;"><b>'.$ct_playerkd[0].'</b></p>
										</div>
										<div class="servers_col" style="width: 12.5%; background: #ECF0F0;">
											<p style="color: black; text-align: center;"><b>'.$ct_playerMVPs[0].'</b></p>
										</div>
										<div class="servers_col" style="width: 12.5%; background: #ECF0F0;">
											<p style="color: black; text-align: center;"><b>'.$ct_playerScore[0].'</b></p>
										</div>
										<div class="servers_col" style="width: 12.5%; background: #ECF0F0;">
											<p style="color: black; text-align: center;"><b>'.$ct_playerPing[0].'</b></p>
										</div>
									</div>
									<div class="servers_row">
										<div class="servers_col" style="width: 12.5%; background: #ECF0F0;">
											<a href="https://steamcommunity.com/profiles/'.$ct_playerId[1].'" style="color:black; text-align: center; padding: 10px;"><b>'.$ct_playerName[1].'</b></a>
										</div>
										<div class="servers_col" style="width: 12.5%; background: #ECF0F0;">
											<p style="color: black; text-align: center;"><b>'.$ct_playerKills[1].'</b></p>
										</div>
										<div class="servers_col" style="width: 12.5%; background: #ECF0F0;">
											<p style="color: black; text-align: center;"><b>'.$ct_playerAssists[1].'</b></p>
										</div>
										<div class="servers_col" style="width: 12.5%; background: #ECF0F0;">
											<p style="color: black; text-align: center;"><b>'.$ct_playerDeaths[1].'</b></p>
										</div>
										<div class="servers_col" style="width: 12.5%; background: #ECF0F0;">
											<p style="color: black; text-align: center;"><b>'.$ct_playerkd[1].'</b></p>
										</div>
										<div class="servers_col" style="width: 12.5%; background: #ECF0F0;">
											<p style="color: black; text-align: center;"><b>'.$ct_playerMVPs[1].'</b></p>
										</div>
										<div class="servers_col" style="width: 12.5%; background: #ECF0F0;">
											<p style="color: black; text-align: center;"><b>'.$ct_playerScore[1].'</b></p>
										</div>
										<div class="servers_col" style="width: 12.5%; background: #ECF0F0;">
											<p style="color: black; text-align: center;"><b>'.$ct_playerPing[1].'</b></p>
										</div>
									</div>
									<div class="servers_row">
										<div class="servers_col" style="width: 12.5%; background: #ECF0F0;">
											<a href="https://steamcommunity.com/profiles/'.$ct_playerId[2].'" style="color:black; text-align: center; padding: 10px;"><b>'.$ct_playerName[2].'</b></a>
										</div>
										<div class="servers_col" style="width: 12.5%; background: #ECF0F0;">
											<p style="color: black; text-align: center;"><b>'.$ct_playerKills[2].'</b></p>
										</div>
										<div class="servers_col" style="width: 12.5%; background: #ECF0F0;">
											<p style="color: black; text-align: center;"><b>'.$ct_playerAssists[2].'</b></p>
										</div>
										<div class="servers_col" style="width: 12.5%; background: #ECF0F0;">
											<p style="color: black; text-align: center;"><b>'.$ct_playerDeaths[2].'</b></p>
										</div>
										<div class="servers_col" style="width: 12.5%; background: #ECF0F0;">
											<p style="color: black; text-align: center;"><b>'.$ct_playerkd[2].'</b></p>
										</div>
										<div class="servers_col" style="width: 12.5%; background: #ECF0F0;">
											<p style="color: black; text-align: center;"><b>'.$ct_playerMVPs[2].'</b></p>
										</div>
										<div class="servers_col" style="width: 12.5%; background: #ECF0F0;">
											<p style="color: black; text-align: center;"><b>'.$ct_playerScore[2].'</b></p>
										</div>
										<div class="servers_col" style="width: 12.5%; background: #ECF0F0;">
											<p style="color: black; text-align: center;"><b>'.$ct_playerPing[2].'</b></p>
										</div>
									</div>
									<div class="servers_row">
										<div class="servers_col" style="width: 12.5%; background: #ECF0F0;">
											<a href="https://steamcommunity.com/profiles/'.$ct_playerId[3].'" style="color:black; text-align: center; padding: 10px;"><b>'.$ct_playerName[3].'</b></a>
										</div>
										<div class="servers_col" style="width: 12.5%; background: #ECF0F0;">
											<p style="color: black; text-align: center;"><b>'.$ct_playerKills[3].'</b></p>
										</div>
										<div class="servers_col" style="width: 12.5%; background: #ECF0F0;">
											<p style="color: black; text-align: center;"><b>'.$ct_playerAssists[3].'</b></p>
										</div>
										<div class="servers_col" style="width: 12.5%; background: #ECF0F0;">
											<p style="color: black; text-align: center;"><b>'.$ct_playerDeaths[3].'</b></p>
										</div>
										<div class="servers_col" style="width: 12.5%; background: #ECF0F0;">
											<p style="color: black; text-align: center;"><b>'.$ct_playerkd[3].'</b></p>
										</div>
										<div class="servers_col" style="width: 12.5%; background: #ECF0F0;">
											<p style="color: black; text-align: center;"><b>'.$ct_playerMVPs[3].'</b></p>
										</div>
										<div class="servers_col" style="width: 12.5%; background: #ECF0F0;">
											<p style="color: black; text-align: center;"><b>'.$ct_playerScore[3].'</b></p>
										</div>
										<div class="servers_col" style="width: 12.5%; background: #ECF0F0;">
											<p style="color: black; text-align: center;"><b>'.$ct_playerPing[3].'</b></p>
										</div>
									</div>
									<div class="servers_row">
										<div class="servers_col" style="width: 12.5%; background: #ECF0F0;">
											<a href="https://steamcommunity.com/profiles/'.$ct_playerId[4].'" style="color:black; text-align: center; padding: 10px;"><b>'.$ct_playerName[4].'</b></a>
										</div>
										<div class="servers_col" style="width: 12.5%; background: #ECF0F0;">
											<p style="color: black; text-align: center;"><b>'.$ct_playerKills[4].'</b></p>
										</div>
										<div class="servers_col" style="width: 12.5%; background: #ECF0F0;">
											<p style="color: black; text-align: center;"><b>'.$ct_playerAssists[4].'</b></p>
										</div>
										<div class="servers_col" style="width: 12.5%; background: #ECF0F0;">
											<p style="color: black; text-align: center;"><b>'.$ct_playerDeaths[4].'</b></p>
										</div>
										<div class="servers_col" style="width: 12.5%; background: #ECF0F0;">
											<p style="color: black; text-align: center;"><b>'.$ct_playerkd[4].'</b></p>
										</div>
										<div class="servers_col" style="width: 12.5%; background: #ECF0F0;">
											<p style="color: black; text-align: center;"><b>'.$ct_playerMVPs[4].'</b></p>
										</div>
										<div class="servers_col" style="width: 12.5%; background: #ECF0F0;">
											<p style="color: black; text-align: center;"><b>'.$ct_playerScore[4].'</b></p>
										</div>
										<div class="servers_col" style="width: 12.5%; background: #ECF0F0;">
											<p style="color: black; text-align: center;"><b>'.$ct_playerPing[4].'</b></p>
										</div>
									</div>
									';
									
									echo '<div class="servers_row">
										<div class="servers_col" style="width: 100%; background: #AC9B66; margin-top: 30px;">
											<p style="color: black; text-align: center;"><b>Terrorists</b></p>
										</div>
									</div>
									<div class="servers_row">
										<div class="servers_col" style="width: 12.5%; background: white;">
											<p style="color: black; text-align: center;">Player</p>
										</div>
										<div class="servers_col" style="width: 12.5%; background: white;">
											<p style="color: black; text-align: center;">Kills</p>
										</div>
										<div class="servers_col" style="width: 12.5%; background: white;">
											<p style="color: black; text-align: center;">Assists</p>
										</div>
										<div class="servers_col" style="width: 12.5%; background: white;">
											<p style="color: black; text-align: center;">Deaths</p>
										</div>
										<div class="servers_col" style="width: 12.5%; background: white;">
											<p style="color: black; text-align: center; word-spacing: 1px;">K/D Ratio</p>
										</div>
										<div class="servers_col" style="width: 12.5%; background: white;">
											<p style="color: black; text-align: center;">MVPs</p>
										</div>
										<div class="servers_col" style="width: 12.5%; background: white;">
											<p style="color: black; text-align: center;">Score</p>
										</div>
										<div class="servers_col" style="width: 12.5%; background: white;">
											<p style="color: black; text-align: center;">Ping</p>
										</div>
									</div>';
								
								echo '<div class="servers_row">
										<div class="servers_col" style="width: 12.5%; background: #ECF0F0;">
											<a href="https://steamcommunity.com/profiles/'.$t_playerId[0].'" style="color:black; text-align: center; padding: 10px;"><b>'.$t_playerName[0].'</b></a>
										</div>
										<div class="servers_col" style="width: 12.5%; background: #ECF0F0;">
											<p style="color: black; text-align: center;"><b>'.$t_playerKills[0].'</b></p>
										</div>
										<div class="servers_col" style="width: 12.5%; background: #ECF0F0;">
											<p style="color: black; text-align: center;"><b>'.$t_playerAssists[0].'</b></p>
										</div>
										<div class="servers_col" style="width: 12.5%; background: #ECF0F0;">
											<p style="color: black; text-align: center;"><b>'.$t_playerDeaths[0].'</b></p>
										</div>
										<div class="servers_col" style="width: 12.5%; background: #ECF0F0;">
											<p style="color: black; text-align: center;"><b>'.$t_playerkd[0].'</b></p>
										</div>
										<div class="servers_col" style="width: 12.5%; background: #ECF0F0;">
											<p style="color: black; text-align: center;"><b>'.$t_playerMVPs[0].'</b></p>
										</div>
										<div class="servers_col" style="width: 12.5%; background: #ECF0F0;">
											<p style="color: black; text-align: center;"><b>'.$t_playerScore[0].'</b></p>
										</div>
										<div class="servers_col" style="width: 12.5%; background: #ECF0F0;">
											<p style="color: black; text-align: center;"><b>'.$t_playerPing[0].'</b></p>
										</div>
									</div>
									<div class="servers_row">
										<div class="servers_col" style="width: 12.5%; background: #ECF0F0;">
											<a href="https://steamcommunity.com/profiles/'.$t_playerId[1].'" style="color:black; text-align: center; padding: 10px;"><b>'.$t_playerName[1].'</b></a>
										</div>
										<div class="servers_col" style="width: 12.5%; background: #ECF0F0;">
											<p style="color: black; text-align: center;"><b>'.$t_playerKills[1].'</b></p>
										</div>
										<div class="servers_col" style="width: 12.5%; background: #ECF0F0;">
											<p style="color: black; text-align: center;"><b>'.$t_playerAssists[1].'</b></p>
										</div>
										<div class="servers_col" style="width: 12.5%; background: #ECF0F0;">
											<p style="color: black; text-align: center;"><b>'.$t_playerDeaths[1].'</b></p>
										</div>
										<div class="servers_col" style="width: 12.5%; background: #ECF0F0;">
											<p style="color: black; text-align: center;"><b>'.$t_playerkd[1].'</b></p>
										</div>
										<div class="servers_col" style="width: 12.5%; background: #ECF0F0;">
											<p style="color: black; text-align: center;"><b>'.$t_playerMVPs[1].'</b></p>
										</div>
										<div class="servers_col" style="width: 12.5%; background: #ECF0F0;">
											<p style="color: black; text-align: center;"><b>'.$t_playerScore[1].'</b></p>
										</div>
										<div class="servers_col" style="width: 12.5%; background: #ECF0F0;">
											<p style="color: black; text-align: center;"><b>'.$t_playerPing[1].'</b></p>
										</div>
									</div>
									<div class="servers_row">
										<div class="servers_col" style="width: 12.5%; background: #ECF0F0;">
											<a href="https://steamcommunity.com/profiles/'.$t_playerId[2].'" style="color:black; text-align: center; padding: 10px;"><b>'.$t_playerName[2].'</b></a>
										</div>
										<div class="servers_col" style="width: 12.5%; background: #ECF0F0;">
											<p style="color: black; text-align: center;"><b>'.$t_playerKills[2].'</b></p>
										</div>
										<div class="servers_col" style="width: 12.5%; background: #ECF0F0;">
											<p style="color: black; text-align: center;"><b>'.$t_playerAssists[2].'</b></p>
										</div>
										<div class="servers_col" style="width: 12.5%; background: #ECF0F0;">
											<p style="color: black; text-align: center;"><b>'.$t_playerDeaths[2].'</b></p>
										</div>
										<div class="servers_col" style="width: 12.5%; background: #ECF0F0;">
											<p style="color: black; text-align: center;"><b>'.$t_playerkd[2].'</b></p>
										</div>
										<div class="servers_col" style="width: 12.5%; background: #ECF0F0;">
											<p style="color: black; text-align: center;"><b>'.$t_playerMVPs[2].'</b></p>
										</div>
										<div class="servers_col" style="width: 12.5%; background: #ECF0F0;">
											<p style="color: black; text-align: center;"><b>'.$t_playerScore[2].'</b></p>
										</div>
										<div class="servers_col" style="width: 12.5%; background: #ECF0F0;">
											<p style="color: black; text-align: center;"><b>'.$t_playerPing[2].'</b></p>
										</div>
									</div>
									<div class="servers_row">
										<div class="servers_col" style="width: 12.5%; background: #ECF0F0;">
											<a href="https://steamcommunity.com/profiles/'.$t_playerId[3].'" style="color:black; text-align: center; padding: 10px;"><b>'.$t_playerName[3].'</b></a>
										</div>
										<div class="servers_col" style="width: 12.5%; background: #ECF0F0;">
											<p style="color: black; text-align: center;"><b>'.$t_playerKills[3].'</b></p>
										</div>
										<div class="servers_col" style="width: 12.5%; background: #ECF0F0;">
											<p style="color: black; text-align: center;"><b>'.$t_playerAssists[3].'</b></p>
										</div>
										<div class="servers_col" style="width: 12.5%; background: #ECF0F0;">
											<p style="color: black; text-align: center;"><b>'.$t_playerDeaths[3].'</b></p>
										</div>
										<div class="servers_col" style="width: 12.5%; background: #ECF0F0;">
											<p style="color: black; text-align: center;"><b>'.$t_playerkd[3].'</b></p>
										</div>
										<div class="servers_col" style="width: 12.5%; background: #ECF0F0;">
											<p style="color: black; text-align: center;"><b>'.$t_playerMVPs[3].'</b></p>
										</div>
										<div class="servers_col" style="width: 12.5%; background: #ECF0F0;">
											<p style="color: black; text-align: center;"><b>'.$t_playerScore[3].'</b></p>
										</div>
										<div class="servers_col" style="width: 12.5%; background: #ECF0F0;">
											<p style="color: black; text-align: center;"><b>'.$t_playerPing[3].'</b></p>
										</div>
									</div>
									<div class="servers_row">
										<div class="servers_col" style="width: 12.5%; background: #ECF0F0;">
											<a href="https://steamcommunity.com/profiles/'.$t_playerId[4].'" style="color:black; text-align: center; padding: 10px;"><b>'.$t_playerName[4].'</b></a>
										</div>
										<div class="servers_col" style="width: 12.5%; background: #ECF0F0;">
											<p style="color: black; text-align: center;"><b>'.$t_playerKills[4].'</b></p>
										</div>
										<div class="servers_col" style="width: 12.5%; background: #ECF0F0;">
											<p style="color: black; text-align: center;"><b>'.$t_playerAssists[4].'</b></p>
										</div>
										<div class="servers_col" style="width: 12.5%; background: #ECF0F0;">
											<p style="color: black; text-align: center;"><b>'.$t_playerDeaths[4].'</b></p>
										</div>
										<div class="servers_col" style="width: 12.5%; background: #ECF0F0;">
											<p style="color: black; text-align: center;"><b>'.$t_playerkd[4].'</b></p>
										</div>
										<div class="servers_col" style="width: 12.5%; background: #ECF0F0;">
											<p style="color: black; text-align: center;"><b>'.$t_playerMVPs[4].'</b></p>
										</div>
										<div class="servers_col" style="width: 12.5%; background: #ECF0F0;">
											<p style="color: black; text-align: center;"><b>'.$t_playerScore[4].'</b></p>
										</div>
										<div class="servers_col" style="width: 12.5%; background: #ECF0F0;">
											<p style="color: black; text-align: center;"><b>'.$t_playerPing[4].'</b></p>
										</div>
									</div>
									';
								
								?>
								
								

							</div>
							<div class="title-test">
								<!-- extra pixels to fit to screen -->
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