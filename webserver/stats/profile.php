<?php
    require ('steamauth/steamauth.php');
	require ("scoreboards/scoreboards_config.php");
	require ("leaderboards/rankme_config.php");
	include_once 'convertSteamID.php';
	
	if (isset($_GET["page"])) 
	{
		$page_number = $_GET["page"];
	} 
	else 
	{
		$page_number = 0;
	}

	if (isset($_GET["user"])) 
	{
		$profile_id = $_GET["user"];
	} 
	else 
	{
		$profile_id = 0;
	}
	
	$profileID = IDto64($profile_id);
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
	<link href="css/style_profile.css" rel="stylesheet" type="text/css">
	
	<link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Open+Sans|Raleway|Candal">
	<link rel="stylesheet" type="text/css" href="css/font-awesome.min.css">
	<link rel="stylesheet" href="circle.css">
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
				
				$profile_id2 = $steamprofile['steamid'];
				$profile_ID = IDfrom64($profile_id2);
				
				echo '<div class="model-container">
							<a href="profile.php?user='.$profile_ID.'&id=10mans" style="padding-top: 0px; padding-left: 0px; font-size:15px;"><button class="profilebtn" id="myBtn" style="margin-right: 2%;"> <img src="' . $steamprofile['avatarfull'] .'" class="img-responsive" width="40px" height="40px" style="border-radius: 50%; vertical-align: middle; margin-right: 6px;"> <b> ' . $steamprofile['personaname'] . ' </b></button></a>
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
								<p>ckL-Gaming.com<br>Stats - Profile</p>
							</div>
							<div class="title-info">
							<br>
								<?php
									if (isset($_GET['id']))
									{
										$selected_type = $_GET['id'];
										
										if($selected_type == "10mans")
										{
											echo '
											<form method="get" id="serverType">
												<input type="hidden" name="user" value="'.$_GET['user'].'">
												<input type="radio" id="10mans" name="id" value="10mans" checked>
													<label for="10mans">10Mans</label>
												<input type="radio" id="5v5s" name="id" value="5v5s">
													<label for="5v5s">5v5s</label>
												 <input type="submit" value="Update">
											</form>
											';
										}
										else
										{
											echo '
											<form method="get" id="serverType">
												<input type="hidden" name="user" value="'.$_GET['user'].'">
												<input type="radio" id="10mans" name="id" value="10mans">
													<label for="10mans">10Mans</label>
												<input type="radio" id="5v5s" name="id" value="5v5s" checked>
													<label for="5v5s">5v5s</label>
												 <input type="submit" value="Update">
											</form>
											';
										}
									}
								?>
								
								<?php
									if (isset($_GET['id']))
									{
										$selected_type = $_GET['id'];
										
										if($selected_type == "10mans")
										{
								?>
								
								<div class="servers_row" style="padding-top: 25px">
									<div class="servers_col" style="width: 20%; background: #ECF0F0; height: 215px;">
										<!--
										<img src="Images/avatar.png" class="img-responsive" width="185px" height="185px" style="margin-top: 15px;">
										-->
										<?php
											$steamID = $profileID;
											$url = 'http://api.steampowered.com/ISteamUser/GetPlayerSummaries/v0002/?key=5546C9362128B17919BBF662A72DC5E1&steamids='.$steamID.'';
											$json_object = file_get_contents($url);
											$json_decoded = json_decode($json_object, true);
											
											$name = $json_decoded['response']['players'][0]['personaname'];
											$avatar= $json_decoded['response']['players'][0]['avatarfull'];
											
											echo '<img src="' . $avatar .'" class="img-responsive" width="185px" height="185px" style="margin-top: 15px;">';
										?>
									</div>
									<?php
									$steamid = $connect->real_escape_string($profile_id);
									$sql = "SELECT DISTINCT * FROM rankme
											WHERE rankme.steam LIKE '%".$steamid."%'";
																		
									$result = $connect->query($sql);

									if($result->num_rows > 0) 
									{
										while($row = $result->fetch_assoc()) 
										{
											$totalKills = $row['kills'];
											$totalDeaths = $row['deaths'];
											
											if($totalDeaths == 0)
												$totalDeaths2 = 1;
											else
												$totalDeaths2 = $totalDeaths;
											
											$totalKD = round($totalKills/$totalDeaths2, 2);
											
											$roundsTotal = $row['rounds_ct'];
											$roundsTotal += $row['rounds_tr'];
											$damageTotal = $row['damage'];
											$totalADR = round($damageTotal / $roundsTotal, 2);

											$totalAssists = $row['assists'];
										}
									}
									
									echo '
									<div class="servers_col" style="width: 13.333%; background: #ECF0F0; height: 215px;">
											<h2 style="margin-top: 80px;">'.$totalKills.'</h2>
									</div>
									<div class="servers_col" style="width: 13.333%; background: #ECF0F0; height: 215px;">
										<h2 style="margin-top: 80px;">'.$totalAssists.'</h2>
									</div>
									<div class="servers_col" style="width: 13.333%; background: #ECF0F0; height: 215px;">
										<h2 style="margin-top: 80px;">'.$totalDeaths.'</h2>
									</div>
									<div class="servers_col" style="width: 13.333%; background: #ECF0F0; height: 215px;">
										<h2 style="margin-top: 80px;">'.$totalKD.'</h2>
									</div>
									<div class="servers_col" style="width: 13.333%; background: #ECF0F0; height: 215px;">
										<h2 style="margin-top: 80px;">'.$totalADR.'</h2>
									</div>
									<div class="servers_col" style="width: 13.333%; background: #ECF0F0; height: 215px;">
										<h2 style="margin-top: 80px;">N/A</h2>
									</div>
									';
									?>
								</div>
								<div class="servers_row">
									<div class="servers_col" style="width: 20%">
										<!--
										<p style="font-size: 17px;">SeaC</p>
										-->
										<?php
											echo '<p style="font-size: 17px;"><b>'.$name.'</b></p>';
										?>
									</div>
									<div class="servers_col" style="width: 13.333%">
										<p style="font-size: 17px;"><b>Kills</b></p>
									</div>
									<div class="servers_col" style="width: 13.333%">
										<p style="font-size: 17px;"><b>Assists</b></p>
									</div>
									<div class="servers_col" style="width: 13.333%">
										<p style="font-size: 17px;"><b>Deaths</b></p>
									</div>
									<div class="servers_col" style="width: 13.333%">
										<p style="font-size: 17px;"><b>K/D Ratio</b></p>
									</div>
									<div class="servers_col" style="width: 13.333%">
										<p style="font-size: 17px;"><b>ADR</b></p>
									</div>
									<div class="servers_col" style="width: 13.333%">
										<p style="font-size: 17px;"><b>HLTV Rating</b></p>
									</div>
								</div>
		
							</div>
							<div class="title-info" style="height: 500px;">
								<p style="text-align: left; padding-left: 30px;"><b>Recent Matches (Last 10)</b></p>
								
								<div class="servers_row">
									<div class="servers_col" style="width: 20%; background: white;">
										<p style="color: black; text-align: center;">Date</p>
									</div>
									<div class="servers_col" style="width: 20%; background: white;">
										<p style="color: black; text-align: center;">Result</p>
									</div>
									<div class="servers_col" style="width: 20%; background: white;">
										<p style="color: black; text-align: center;">Score</p>
									</div>
									<div class="servers_col" style="width: 25%; background: white;">
										<p style="color: black; text-align: center;">Map</p>
									</div>
									<div class="servers_col" style="width: 15%; background: white;">
										<p style="color: black; text-align: center;">Winner</p>
									</div>
								</div>
								<?php
								$limit2 = 10;
								
								if (isset($_GET["page"])) 
								{
									$page_number = $conn->real_escape_string($_GET["page"]);
									$offset = ($page_number - 1) * $limit2; 
									
									$search = $conn->real_escape_string($profileID);
									$sql = "SELECT DISTINCT sql_matches_scoretotal.match_id, sql_matches_scoretotal.timestamp, sql_matches_scoretotal.map, sql_matches_scoretotal.team_2, sql_matches_scoretotal.team_3
											FROM sql_matches_scoretotal INNER JOIN sql_matches
											ON sql_matches_scoretotal.match_id = sql_matches.match_id
											WHERE sql_matches.name LIKE '%".$search."%' OR sql_matches.steamid64 = '".$search."' OR sql_matches_scoretotal.match_id = '".$search."' ORDER BY sql_matches_scoretotal.match_id DESC LIMIT $offset, $limit2";
								}
								else
								{
									$search = $conn->real_escape_string($profileID);
									$page_number = 1;
									$sql = "SELECT DISTINCT sql_matches_scoretotal.match_id, sql_matches_scoretotal.timestamp, sql_matches_scoretotal.map, sql_matches_scoretotal.team_2, sql_matches_scoretotal.team_3
										FROM sql_matches_scoretotal INNER JOIN sql_matches
										ON sql_matches_scoretotal.match_id = sql_matches.match_id
										WHERE sql_matches.name LIKE '%".$search."%' OR sql_matches.steamid64 = '".$search."' OR sql_matches_scoretotal.match_id = '".$search."' ORDER BY sql_matches_scoretotal.match_id DESC LIMIT $limit2";
								}
								
								$result = $conn->query($sql);
	
								if($result->num_rows > 0) 
								{
									while($row = $result->fetch_assoc()) 
									{
										$half = ($row["team_2"] + $row["team_3"]) / 2;

										if ($row["team_3"] > $half) 
										{
											$image = 'ct_icon.png';
											$team_win = "CT";
										} 
										elseif ($row["team_2"] == $half && $row["team_3"] == $half) 
										{
											$image = 'tie_icon.png';
											$team_win = "Tie";
										} 
										else 
										{
											$image = 't_icon.png';
											$team_win = "T";
										}
										$map_img = array_search($row["map"], $maps);
										
										$match_id = $conn->real_escape_string($row["match_id"]);
										$sql2 = "SELECT sql_matches_scoretotal.*, sql_matches.*
												FROM sql_matches_scoretotal INNER JOIN sql_matches
												ON sql_matches_scoretotal.match_id = sql_matches.match_id
												WHERE sql_matches_scoretotal.match_id = '".$match_id."' ORDER BY sql_matches.score DESC";
									
										$result2 = $conn->query($sql2);
									
										if ($result2->num_rows > 0) 
										{
											while ($row2 = $result2->fetch_assoc()) 
											{
												$MyTeam_id = $row2["team"];
												if($MyTeam_id == "2")
												{
													$MyTeam = "T";
												}
												else
												{
													$MyTeam = "CT";
												}
												
												if(($row2['steamid64'] == $profileID) && ($MyTeam == $team_win))
												{
													$color = 'green';
													$Match_Result = "Win";
													
													if($row["team_2"] > $row["team_3"])
													{
														$team1 = "team_2";
														$team2 = "team_3";
													}
													else
													{
														$team1 = "team_3";
														$team2 = "team_2";
													}
													break;
												}
												else
												{
													$color = 'red';
													$Match_Result = "Loss";
													if($row["team_2"] > $row["team_3"])
													{
														$team1 = "team_2";
														$team2 = "team_3";
													}
													else
													{
														$team1 = "team_3";
														$team2 = "team_2";
													}
													continue;
												}
											}
										}
												
										echo '<a href="scoreboards_10man.php?id='.$row["match_id"].'">
												<div class="servers_row">
													<div class="servers_col" style="width: 20%; background: #ECF0F0; min-height: 40px;">
														<p style="color: black; text-align: center;">'.$row['timestamp'].'</p>
													</div>
													<div class="servers_col" style="width: 20%; background: #ECF0F0; min-height: 40px;">
														<p style="color: '.$color.'; text-align: center; display: inline-block;">'.$Match_Result.'</p>
													</div>
													<div class="servers_col" style="width: 20%; background: #ECF0F0; min-height: 40px;">
														<p style="color: '.$color.'; text-align: center; display: inline-block;">'.$row[$team1].' </p><p style="color: black; text-align: center; display: inline-block;"> - </p><p style="color: '.$color.'; text-align: center; display: inline-block; ">'.$row[$team2].'</p>
													</div>
													<div class="servers_col" style="width: 12.5%; background: #ECF0F0; border-right: none; min-height: 40px;">
														<img class="" src="'.$map_img.'?h=4347d1d6c5595286f4b1acacc902fedd" style="width: 50px; height: 35px; display: inline-block; vertical-align: middle; float: right;">
													</div>
													<div class="servers_col" style="width: 12.5%; background: #ECF0F0; border-left: none; min-height: 40px;">
														<p style="color: black; text-align: center; display: inline-block; float: left;">'. $row['map']. '</p>
													</div>
													<div class="servers_col" style="width: 7.5%; background: #ECF0F0; border-right: none; min-height: 40px;">
														<img class="" src="scoreboards/img/'.$image.'?h=4347d1d6c5595286f4b1acacc902fedd" style="width: 25px; height: 25px; margin-top: 7px; float: right;">
														
													</div>
													<div class="servers_col" style="width: 7.5%; background: #ECF0F0; border-left: none; min-height: 40px;">
														<p style="color: black; text-align: center; display: inline-block; float: left;">'. $team_win. '</p>
													</div>
												</div>
											</a>';
									}
								}
								else 
								{
										echo '<h1 style="margin-top:20px;text-align:center;">No Results!</h1>';
								}
								
								?>
								
							</div>
							<div class="title-info" style="height: 780px;">
								<p style="text-align: left; padding-left: 30px;"><b>More Statistics</b></p>
								<?php
								$steamid = $connect->real_escape_string($profile_id);
								$sql = "SELECT DISTINCT * FROM rankme
										WHERE rankme.steam LIKE '%".$steamid."%'";
																		
								$result = $connect->query($sql);

								if($result->num_rows > 0) 
								{
									while($row = $result->fetch_assoc()) 
									{
										$headshots = $row['headshots'];
										$kills = $row['kills'];
										$hs = round(($headshots / $kills) * 100, 0);
										
										$defuses = $row['c4_defused'];
										$wallbangs = $row['wallbang'];
										$thruSmoke = $row['thru_smoke'];
										$mvps = $row['mvp'];
										
										//Row 1
										$totalKnife = $row['knife'];
										$totalAK47 = $row['ak47'];
										$totalM4A4 = $row['m4a1'];
										$totalM4A1 = $row['m4a1_silencer'];
										$totalAWP = $row['awp'];
										
										//Row 2
										$totalAUG = $row['aug'];
										$totalSG = $row['sg556'];
										$totalFamas = $row['famas'];
										$totalGalil = $row['galilar'];
										$totalSCAR = $row['scar20'];
										
										//Row 3
										$totalSCOUT = $row['ssg08'];
										$totalNEGEV = $row['negev'];
										$totalM249 = $row['m249'];
										$totalG3 = $row['g3sg1'];
										$totalNOVA = $row['nova'];
										
										//Row 4
										$totalSAW = $row['sawedoff'];
										$totalXM = $row['xm1014'];
										$totalMAG = $row['mag7'];
										$totalBIZ = $row['bizon'];
										$totalMP5 = $row['mp5sd'];
										
										//Row 5
										$totalUSP = $row['usp_silencer'];
										$totalP2000 = $row['hkp2000'];
										$totalGLOCK = $row['glock'];
										$totalP250 = $row['p250'];
										$totalDEAGLE = $row['deagle'];
										
										//Row 6
										$totalDUAL = $row['elite'];
										$total57 = $row['fiveseven'];
										$totalTEC9 = $row['tec9'];
										$totalCZ = $row['cz75a'];
										$totalR8 = $row['revolver'];
										
										//Row 6
										$totalFIRE = $row['inferno'];
										$totalNADE = $row['hegrenade'];
										$totalFLASH = $row['flashbang'];
										$totalSMOKE = $row['smokegrenade'];
										$totalDECOY = $row['decoy'];
									}
								}
								echo '
								<div class="servers_row">
									<div class="servers_col" style="width: 100%; background: white;">
										<p style="color: black; text-align: center;">More Stats</p>
									</div>
								</div>
								<div class="servers_row">
									<div class="servers_col" style="width: 20%; background: #ECF0F0; min-height: 200px; border-right: none;">
										<img class="" src="Images/defusekit.png" style="width: 70px; height: 70px; margin-top: 25px;">
										<p style="font-size: 18px;"><b>Defuses</b></p>
										<p style="font-size: 18px; color: #1E90FF; margin-top: 25px;"><b>'.$defuses.'</b></p>
									</div>
									<div class="servers_col" style="width: 20%; background: #ECF0F0; min-height: 200px; border-left: none; border-right: none;">
										<img class="" src="Images/headshot.png" style="width: 80px; height: 70px; margin-top: 25px;">
										<p style="font-size: 18px;"><b>Headshot %</b></p>
										<p style="font-size: 18px; color: #1E90FF; margin-top: 25px;"><b>'.$hs.'</b></p>
									</div>
									<div class="servers_col" style="width: 20%; background: #ECF0F0; min-height: 200px; border-right: none; border-left: none;">
										<img class="" src="Images/wallbang.png" style="width: 80px; height: 70px; margin-top: 25px;">
										<p style="font-size: 18px;"><b>Wallbangs</b></p>
										<p style="font-size: 18px; color: #1E90FF; margin-top: 25px;"><b>'.$wallbangs.'</b></p>
									</div>
									<div class="servers_col" style="width: 20%; background: #ECF0F0; min-height: 200px; border-right: none; border-left: none;">
										<img class="" src="Images/thrusmoke.png" style="width: 80px; height: 70px; margin-top: 25px;">
										<p style="font-size: 18px;"><b>Thru-Smoke</b></p>
										<p style="font-size: 18px; color: #1E90FF; margin-top: 25px;"><b>'.$thruSmoke.'</b></p>
									</div>
									<div class="servers_col" style="width: 20%; background: #ECF0F0; min-height: 200px; border-left: none;">
										<img class="" src="Images/mvp.png" style="width: 70px; height: 70px; margin-top: 25px;">
										<p style="font-size: 18px;"><b>MVPs</b></p>
										<p style="font-size: 18px; color: #1E90FF; margin-top: 25px;"><b>'.$mvps.'</b></p>
									</div>
								</div>
								
								<div class="servers_row" style="margin-top: 25px;">
									<div class="servers_col" style="width: 100%; background: white;">
										<p style="color: black; text-align: center;">Weapon Stats [Kills]</p>
									</div>
								</div>
								<div class="servers_row">
									<div class="servers_col" style="width: 5%; background: #ECF0F0; min-height: 60px; border-right: none;">
										<img class="" src="Images/weapons/knife.png" style="width: 45px; height: 45px; display: inline-block; vertical-align: middle; margin-top: 5px;">
									</div>
									<div class="servers_col" style="width: 5%; background: #ECF0F0; min-height: 60px; border-left: none; border-right: none;">
										<p style="color: black; text-align: center; display: inline-block; float: left; font-size: 15px; margin-top: 28px;"><b>KNIFES</b></p>
									</div>
									<div class="servers_col" style="width: 10%; background: #ECF0F0; min-height: 60px; border-left: none;">
										<p style="color: black; text-align: center; margin-top: 28px; font-size: 15px; color: #1E90FF;"><b>'.$totalKnife.'</b></p>
									</div>
									<div class="servers_col" style="width: 5%; background: #ECF0F0; min-height: 60px; border-right: none;">
										<img class="" src="Images/weapons/ak47.png" style="width: 45px; height: 45px; display: inline-block; vertical-align: middle; margin-top: 5px;">
									</div>
									<div class="servers_col" style="width: 5%; background: #ECF0F0; min-height: 60px; border-left: none; border-right: none;">
										<p style="color: black; text-align: center; display: inline-block; float: left; font-size: 15px; margin-top: 28px;"><b>AK47</b></p>
									</div>
									<div class="servers_col" style="width: 10%; background: #ECF0F0; min-height: 60px; border-left: none;">
										<p style="color: black; text-align: center; margin-top: 28px; font-size: 15px; color: #1E90FF;"><b>'.$totalAK47.'</b></p>
									</div>
									<div class="servers_col" style="width: 5%; background: #ECF0F0; min-height: 60px; border-right: none;">
										<img class="" src="Images/weapons/m4a4.png" style="width: 45px; height: 45px; display: inline-block; vertical-align: middle; margin-top: 5px;">
									</div>
									<div class="servers_col" style="width: 5%; background: #ECF0F0; min-height: 60px; border-left: none; border-right: none;">
										<p style="color: black; text-align: center; display: inline-block; float: left; font-size: 15px; margin-top: 28px;"><b>M4A4</b></p>
									</div>
									<div class="servers_col" style="width: 10%; background: #ECF0F0; min-height: 60px; border-left: none;">
										<p style="color: black; text-align: center; margin-top: 28px; font-size: 15px; color: #1E90FF;"><b>'.$totalM4A4.'</b></p>
									</div>
									<div class="servers_col" style="width: 5%; background: #ECF0F0; min-height: 60px; border-right: none;">
										<img class="" src="Images/weapons/m4a1.png" style="width: 45px; height: 45px; display: inline-block; vertical-align: middle; margin-top: 5px;">
									</div>
									<div class="servers_col" style="width: 5%; background: #ECF0F0; min-height: 60px; border-left: none; border-right: none;">
										<p style="color: black; text-align: center; display: inline-block; float: left; font-size: 15px; margin-top: 28px;"><b>M4A1-S</b></p>
									</div>
									<div class="servers_col" style="width: 10%; background: #ECF0F0; min-height: 60px; border-left: none;">
										<p style="color: black; text-align: center; margin-top: 28px; font-size: 15px; color: #1E90FF;"><b>'.$totalM4A1.'</b></p>
									</div>
									<div class="servers_col" style="width: 5%; background: #ECF0F0; min-height: 60px; border-right: none;">
										<img class="" src="Images/weapons/AWP.png" style="width: 45px; height: 45px; display: inline-block; vertical-align: middle; margin-top: 5px;">
									</div>
									<div class="servers_col" style="width: 5%; background: #ECF0F0; min-height: 60px; border-left: none; border-right: none;">
										<p style="color: black; text-align: center; display: inline-block; float: left; font-size: 15px; margin-top: 28px;"><b>AWP</b></p>
									</div>
									<div class="servers_col" style="width: 10%; background: #ECF0F0; min-height: 60px; border-left: none;">
										<p style="color: black; text-align: center; margin-top: 28px; font-size: 15px; color: #1E90FF;"><b>'.$totalAWP.'</b></p>
									</div>
								</div>
								<div class="servers_row">
									<div class="servers_col" style="width: 5%; background: #ECF0F0; min-height: 60px; border-right: none;">
										<img class="" src="Images/weapons/aug.png" style="width: 45px; height: 45px; display: inline-block; vertical-align: middle; margin-top: 5px;">
									</div>
									<div class="servers_col" style="width: 5%; background: #ECF0F0; min-height: 60px; border-left: none; border-right: none;">
										<p style="color: black; text-align: center; display: inline-block; float: left; font-size: 15px; margin-top: 28px;"><b>AUG</b></p>
									</div>
									<div class="servers_col" style="width: 10%; background: #ECF0F0; min-height: 60px; border-left: none;">
										<p style="color: black; text-align: center; margin-top: 28px; font-size: 15px; color: #1E90FF;"><b>'.$totalAUG.'</b></p>
									</div>
									<div class="servers_col" style="width: 5%; background: #ECF0F0; min-height: 60px; border-right: none;">
										<img class="" src="Images/weapons/sg.png" style="width: 45px; height: 45px; display: inline-block; vertical-align: middle; margin-top: 5px;">
									</div>
									<div class="servers_col" style="width: 5%; background: #ECF0F0; min-height: 60px; border-left: none; border-right: none;">
										<p style="color: black; text-align: center; display: inline-block; float: left; font-size: 15px; margin-top: 28px;"><b>SG553</b></p>
									</div>
									<div class="servers_col" style="width: 10%; background: #ECF0F0; min-height: 60px; border-left: none;">
										<p style="color: black; text-align: center; margin-top: 28px; font-size: 15px; color: #1E90FF;"><b>'.$totalSG.'</b></p>
									</div>
									<div class="servers_col" style="width: 5%; background: #ECF0F0; min-height: 60px; border-right: none;">
										<img class="" src="Images/weapons/famas.png" style="width: 45px; height: 45px; display: inline-block; vertical-align: middle; margin-top: 5px;">
									</div>
									<div class="servers_col" style="width: 5%; background: #ECF0F0; min-height: 60px; border-left: none; border-right: none;">
										<p style="color: black; text-align: center; display: inline-block; float: left; font-size: 15px; margin-top: 28px;"><b>FAMAS</b></p>
									</div>
									<div class="servers_col" style="width: 10%; background: #ECF0F0; min-height: 60px; border-left: none;">
										<p style="color: black; text-align: center; margin-top: 28px; font-size: 15px; color: #1E90FF;"><b>'.$totalFamas.'</b></p>
									</div>
									<div class="servers_col" style="width: 5%; background: #ECF0F0; min-height: 60px; border-right: none;">
										<img class="" src="Images/weapons/galil.png" style="width: 45px; height: 45px; display: inline-block; vertical-align: middle; margin-top: 5px;">
									</div>
									<div class="servers_col" style="width: 5%; background: #ECF0F0; min-height: 60px; border-left: none; border-right: none;">
										<p style="color: black; text-align: center; display: inline-block; float: left; font-size: 15px; margin-top: 28px;"><b>GALILAR</b></p>
									</div>
									<div class="servers_col" style="width: 10%; background: #ECF0F0; min-height: 60px; border-left: none;">
										<p style="color: black; text-align: center; margin-top: 28px; font-size: 15px; color: #1E90FF;"><b>'.$totalGalil.'</b></p>
									</div>
									<div class="servers_col" style="width: 5%; background: #ECF0F0; min-height: 60px; border-right: none;">
										<img class="" src="Images/weapons/scar20.png" style="width: 45px; height: 45px; display: inline-block; vertical-align: middle; margin-top: 5px;">
									</div>
									<div class="servers_col" style="width: 5%; background: #ECF0F0; min-height: 60px; border-left: none; border-right: none;">
										<p style="color: black; text-align: center; display: inline-block; float: left; font-size: 15px; margin-top: 28px;"><b>SCAR20</b></p>
									</div>
									<div class="servers_col" style="width: 10%; background: #ECF0F0; min-height: 60px; border-left: none;">
										<p style="color: black; text-align: center; margin-top: 28px; font-size: 15px; color: #1E90FF;"><b>'.$totalSCAR.'</b></p>
									</div>
								</div>
								<div class="servers_row">
									<div class="servers_col" style="width: 5%; background: #ECF0F0; min-height: 60px; border-right: none;">
										<img class="" src="Images/weapons/scout.png" style="width: 45px; height: 45px; display: inline-block; vertical-align: middle; margin-top: 5px;">
									</div>
									<div class="servers_col" style="width: 5%; background: #ECF0F0; min-height: 60px; border-left: none; border-right: none;">
										<p style="color: black; text-align: center; display: inline-block; float: left; font-size: 15px; margin-top: 28px;"><b>SSG08</b></p>
									</div>
									<div class="servers_col" style="width: 10%; background: #ECF0F0; min-height: 60px; border-left: none;">
										<p style="color: black; text-align: center; margin-top: 28px; font-size: 15px; color: #1E90FF;"><b>'.$totalSCOUT.'</b></p>
									</div>
									<div class="servers_col" style="width: 5%; background: #ECF0F0; min-height: 60px; border-right: none;">
										<img class="" src="Images/weapons/negev.png" style="width: 45px; height: 45px; display: inline-block; vertical-align: middle; margin-top: 5px;">
									</div>
									<div class="servers_col" style="width: 5%; background: #ECF0F0; min-height: 60px; border-left: none; border-right: none;">
										<p style="color: black; text-align: center; display: inline-block; float: left; font-size: 15px; margin-top: 28px;"><b>NEGEV</b></p>
									</div>
									<div class="servers_col" style="width: 10%; background: #ECF0F0; min-height: 60px; border-left: none;">
										<p style="color: black; text-align: center; margin-top: 28px; font-size: 15px; color: #1E90FF;"><b>'.$totalNEGEV.'</b></p>
									</div>
									<div class="servers_col" style="width: 5%; background: #ECF0F0; min-height: 60px; border-right: none;">
										<img class="" src="Images/weapons/m249.png" style="width: 45px; height: 45px; display: inline-block; vertical-align: middle; margin-top: 5px;">
									</div>
									<div class="servers_col" style="width: 5%; background: #ECF0F0; min-height: 60px; border-left: none; border-right: none;">
										<p style="color: black; text-align: center; display: inline-block; float: left; font-size: 15px; margin-top: 28px;"><b>M249</b></p>
									</div>
									<div class="servers_col" style="width: 10%; background: #ECF0F0; min-height: 60px; border-left: none;">
										<p style="color: black; text-align: center; margin-top: 28px; font-size: 15px; color: #1E90FF;"><b>'.$totalM249.'</b></p>
									</div>
									<div class="servers_col" style="width: 5%; background: #ECF0F0; min-height: 60px; border-right: none;">
										<img class="" src="Images/weapons/g3sg1.png" style="width: 45px; height: 45px; display: inline-block; vertical-align: middle; margin-top: 5px;">
									</div>
									<div class="servers_col" style="width: 5%; background: #ECF0F0; min-height: 60px; border-left: none; border-right: none;">
										<p style="color: black; text-align: center; display: inline-block; float: left; font-size: 15px; margin-top: 28px;"><b>G3SG1</b></p>
									</div>
									<div class="servers_col" style="width: 10%; background: #ECF0F0; min-height: 60px; border-left: none;">
										<p style="color: black; text-align: center; margin-top: 28px; font-size: 15px; color: #1E90FF;"><b>'.$totalG3.'</b></p>
									</div>
									<div class="servers_col" style="width: 5%; background: #ECF0F0; min-height: 60px; border-right: none;">
										<img class="" src="Images/weapons/nova.png" style="width: 45px; height: 45px; display: inline-block; vertical-align: middle; margin-top: 5px;">
									</div>
									<div class="servers_col" style="width: 5%; background: #ECF0F0; min-height: 60px; border-left: none; border-right: none;">
										<p style="color: black; text-align: center; display: inline-block; float: left; font-size: 15px; margin-top: 28px;"><b>NOVA</b></p>
									</div>
									<div class="servers_col" style="width: 10%; background: #ECF0F0; min-height: 60px; border-left: none;">
										<p style="color: black; text-align: center; margin-top: 28px; font-size: 15px; color: #1E90FF;"><b>'.$totalNOVA.'</b></p>
									</div>
								</div>
								<div class="servers_row">
									<div class="servers_col" style="width: 5%; background: #ECF0F0; min-height: 60px; border-right: none;">
										<img class="" src="Images/weapons/saw.png" style="width: 45px; height: 45px; display: inline-block; vertical-align: middle; margin-top: 5px;">
									</div>
									<div class="servers_col" style="width: 5%; background: #ECF0F0; min-height: 60px; border-left: none; border-right: none;">
										<p style="color: black; text-align: center; display: inline-block; float: left; font-size: 11px; margin-top: 28px;"><b>SAWED-OFF</b></p>
									</div>
									<div class="servers_col" style="width: 10%; background: #ECF0F0; min-height: 60px; border-left: none;">
										<p style="color: black; text-align: center; margin-top: 28px; font-size: 15px; color: #1E90FF;"><b>'.$totalSAW.'</b></p>
									</div>
									<div class="servers_col" style="width: 5%; background: #ECF0F0; min-height: 60px; border-right: none;">
										<img class="" src="Images/weapons/xm.png" style="width: 45px; height: 45px; display: inline-block; vertical-align: middle; margin-top: 5px;">
									</div>
									<div class="servers_col" style="width: 5%; background: #ECF0F0; min-height: 60px; border-left: none; border-right: none;">
										<p style="color: black; text-align: center; display: inline-block; float: left; font-size: 15px; margin-top: 28px;"><b>XM1014</b></p>
									</div>
									<div class="servers_col" style="width: 10%; background: #ECF0F0; min-height: 60px; border-left: none;">
										<p style="color: black; text-align: center; margin-top: 28px; font-size: 15px; color: #1E90FF;"><b>'.$totalXM.'</b></p>
									</div>
									<div class="servers_col" style="width: 5%; background: #ECF0F0; min-height: 60px; border-right: none;">
										<img class="" src="Images/weapons/mag7.png" style="width: 45px; height: 45px; display: inline-block; vertical-align: middle; margin-top: 5px;">
									</div>
									<div class="servers_col" style="width: 5%; background: #ECF0F0; min-height: 60px; border-left: none; border-right: none;">
										<p style="color: black; text-align: center; display: inline-block; float: left; font-size: 15px; margin-top: 28px;"><b>MAG7</b></p>
									</div>
									<div class="servers_col" style="width: 10%; background: #ECF0F0; min-height: 60px; border-left: none;">
										<p style="color: black; text-align: center; margin-top: 28px; font-size: 15px; color: #1E90FF;"><b>'.$totalMAG.'</b></p>
									</div>
									<div class="servers_col" style="width: 5%; background: #ECF0F0; min-height: 60px; border-right: none;">
										<img class="" src="Images/weapons/pp.png" style="width: 45px; height: 45px; display: inline-block; vertical-align: middle; margin-top: 5px;">
									</div>
									<div class="servers_col" style="width: 5%; background: #ECF0F0; min-height: 60px; border-left: none; border-right: none;">
										<p style="color: black; text-align: center; display: inline-block; float: left; font-size: 15px; margin-top: 28px;"><b>BIZON</b></p>
									</div>
									<div class="servers_col" style="width: 10%; background: #ECF0F0; min-height: 60px; border-left: none;">
										<p style="color: black; text-align: center; margin-top: 28px; font-size: 15px; color: #1E90FF;"><b>'.$totalBIZ.'</b></p>
									</div>
									<div class="servers_col" style="width: 5%; background: #ECF0F0; min-height: 60px; border-right: none;">
										<img class="" src="Images/weapons/mp5sd.png" style="width: 45px; height: 45px; display: inline-block; vertical-align: middle; margin-top: 5px;">
									</div>
									<div class="servers_col" style="width: 5%; background: #ECF0F0; min-height: 60px; border-left: none; border-right: none;">
										<p style="color: black; text-align: center; display: inline-block; float: left; font-size: 15px; margin-top: 28px;"><b>MP5-SD</b></p>
									</div>
									<div class="servers_col" style="width: 10%; background: #ECF0F0; min-height: 60px; border-left: none;">
										<p style="color: black; text-align: center; margin-top: 28px; font-size: 15px; color: #1E90FF;"><b>'.$totalMP5.'</b></p>
									</div>
								</div>
								<div class="servers_row">
									<div class="servers_col" style="width: 5%; background: #ECF0F0; min-height: 60px; border-right: none;">
										<img class="" src="Images/weapons/usp.png" style="width: 45px; height: 45px; display: inline-block; vertical-align: middle; margin-top: 5px;">
									</div>
									<div class="servers_col" style="width: 5%; background: #ECF0F0; min-height: 60px; border-left: none; border-right: none;">
										<p style="color: black; text-align: center; display: inline-block; float: left; font-size: 15px; margin-top: 28px;"><b>USP-S</b></p>
									</div>
									<div class="servers_col" style="width: 10%; background: #ECF0F0; min-height: 60px; border-left: none;">
										<p style="color: black; text-align: center; margin-top: 28px; font-size: 15px; color: #1E90FF;"><b>'.$totalUSP.'</b></p>
									</div>
									<div class="servers_col" style="width: 5%; background: #ECF0F0; min-height: 60px; border-right: none;">
										<img class="" src="Images/weapons/p2000.png" style="width: 45px; height: 45px; display: inline-block; vertical-align: middle; margin-top: 5px;">
									</div>
									<div class="servers_col" style="width: 5%; background: #ECF0F0; min-height: 60px; border-left: none; border-right: none;">
										<p style="color: black; text-align: center; display: inline-block; float: left; font-size: 15px; margin-top: 28px;"><b>P2000</b></p>
									</div>
									<div class="servers_col" style="width: 10%; background: #ECF0F0; min-height: 60px; border-left: none;">
										<p style="color: black; text-align: center; margin-top: 28px; font-size: 15px; color: #1E90FF;"><b>'.$totalP2000.'</b></p>
									</div>
									<div class="servers_col" style="width: 5%; background: #ECF0F0; min-height: 60px; border-right: none;">
										<img class="" src="Images/weapons/glock.png" style="width: 45px; height: 45px; display: inline-block; vertical-align: middle; margin-top: 5px;">
									</div>
									<div class="servers_col" style="width: 5%; background: #ECF0F0; min-height: 60px; border-left: none; border-right: none;">
										<p style="color: black; text-align: center; display: inline-block; float: left; font-size: 15px; margin-top: 28px;"><b>GLOCK</b></p>
									</div>
									<div class="servers_col" style="width: 10%; background: #ECF0F0; min-height: 60px; border-left: none;">
										<p style="color: black; text-align: center; margin-top: 28px; font-size: 15px; color: #1E90FF;"><b>'.$totalGLOCK.'</b></p>
									</div>
									<div class="servers_col" style="width: 5%; background: #ECF0F0; min-height: 60px; border-right: none;">
										<img class="" src="Images/weapons/p250.png" style="width: 45px; height: 45px; display: inline-block; vertical-align: middle; margin-top: 5px;">
									</div>
									<div class="servers_col" style="width: 5%; background: #ECF0F0; min-height: 60px; border-left: none; border-right: none;">
										<p style="color: black; text-align: center; display: inline-block; float: left; font-size: 15px; margin-top: 28px;"><b>P250</b></p>
									</div>
									<div class="servers_col" style="width: 10%; background: #ECF0F0; min-height: 60px; border-left: none;">
										<p style="color: black; text-align: center; margin-top: 28px; font-size: 15px; color: #1E90FF;"><b>'.$totalP250.'</b></p>
									</div>
									<div class="servers_col" style="width: 5%; background: #ECF0F0; min-height: 60px; border-right: none;">
										<img class="" src="Images/weapons/deagle.png" style="width: 45px; height: 45px; display: inline-block; vertical-align: middle; margin-top: 5px;">
									</div>
									<div class="servers_col" style="width: 5%; background: #ECF0F0; min-height: 60px; border-left: none; border-right: none;">
										<p style="color: black; text-align: center; display: inline-block; float: left; font-size: 15px; margin-top: 28px;"><b>DEAGLE</b></p>
									</div>
									<div class="servers_col" style="width: 10%; background: #ECF0F0; min-height: 60px; border-left: none;">
										<p style="color: black; text-align: center; margin-top: 28px; font-size: 15px; color: #1E90FF;"><b>'.$totalDEAGLE.'</b></p>
									</div>
								</div>
								<div class="servers_row">
									<div class="servers_col" style="width: 5%; background: #ECF0F0; min-height: 60px; border-right: none;">
										<img class="" src="Images/weapons/dual.png" style="width: 45px; height: 45px; display: inline-block; vertical-align: middle; margin-top: 5px;">
									</div>
									<div class="servers_col" style="width: 5%; background: #ECF0F0; min-height: 60px; border-left: none; border-right: none;">
										<p style="color: black; text-align: center; display: inline-block; float: left; font-size: 15px; margin-top: 28px;"><b>DUAL-B</b></p>
									</div>
									<div class="servers_col" style="width: 10%; background: #ECF0F0; min-height: 60px; border-left: none;">
										<p style="color: black; text-align: center; margin-top: 28px; font-size: 15px; color: #1E90FF;"><b>'.$totalDUAL.'</b></p>
									</div>
									<div class="servers_col" style="width: 5%; background: #ECF0F0; min-height: 60px; border-right: none;">
										<img class="" src="Images/weapons/five7.png" style="width: 45px; height: 45px; display: inline-block; vertical-align: middle; margin-top: 5px;">
									</div>
									<div class="servers_col" style="width: 5%; background: #ECF0F0; min-height: 60px; border-left: none; border-right: none;">
										<p style="color: black; text-align: center; display: inline-block; float: left; font-size: 15px; margin-top: 28px;"><b>FIVE-7</b></p>
									</div>
									<div class="servers_col" style="width: 10%; background: #ECF0F0; min-height: 60px; border-left: none;">
										<p style="color: black; text-align: center; margin-top: 28px; font-size: 15px; color: #1E90FF;"><b>'.$total57.'</b></p>
									</div>
									<div class="servers_col" style="width: 5%; background: #ECF0F0; min-height: 60px; border-right: none;">
										<img class="" src="Images/weapons/tec9.png" style="width: 45px; height: 45px; display: inline-block; vertical-align: middle; margin-top: 5px;">
									</div>
									<div class="servers_col" style="width: 5%; background: #ECF0F0; min-height: 60px; border-left: none; border-right: none;">
										<p style="color: black; text-align: center; display: inline-block; float: left; font-size: 15px; margin-top: 28px;"><b>TEC9</b></p>
									</div>
									<div class="servers_col" style="width: 10%; background: #ECF0F0; min-height: 60px; border-left: none;">
										<p style="color: black; text-align: center; margin-top: 28px; font-size: 15px; color: #1E90FF;"><b>'.$totalTEC9.'</b></p>
									</div>
									<div class="servers_col" style="width: 5%; background: #ECF0F0; min-height: 60px; border-right: none;">
										<img class="" src="Images/weapons/cz75.png" style="width: 45px; height: 45px; display: inline-block; vertical-align: middle; margin-top: 5px;">
									</div>
									<div class="servers_col" style="width: 5%; background: #ECF0F0; min-height: 60px; border-left: none; border-right: none;">
										<p style="color: black; text-align: center; display: inline-block; float: left; font-size: 15px; margin-top: 28px;"><b>CZ75A</b></p>
									</div>
									<div class="servers_col" style="width: 10%; background: #ECF0F0; min-height: 60px; border-left: none;">
										<p style="color: black; text-align: center; margin-top: 28px; font-size: 15px; color: #1E90FF;"><b>'.$totalCZ.'</b></p>
									</div>
									<div class="servers_col" style="width: 5%; background: #ECF0F0; min-height: 60px; border-right: none;">
										<img class="" src="Images/weapons/r8.png" style="width: 45px; height: 45px; display: inline-block; vertical-align: middle; margin-top: 5px;">
									</div>
									<div class="servers_col" style="width: 5%; background: #ECF0F0; min-height: 60px; border-left: none; border-right: none;">
										<p style="color: black; text-align: center; display: inline-block; float: left; font-size: 15px; margin-top: 28px;"><b>R8</b></p>
									</div>
									<div class="servers_col" style="width: 10%; background: #ECF0F0; min-height: 60px; border-left: none;">
										<p style="color: black; text-align: center; margin-top: 28px; font-size: 15px; color: #1E90FF;"><b>'.$totalR8.'</b></p>
									</div>
								</div>
								<div class="servers_row">
									<div class="servers_col" style="width: 5%; background: #ECF0F0; min-height: 60px; border-right: none;">
										<img class="" src="Images/weapons/ctmolly.png" style="width: 45px; height: 25px; display: inline-block; vertical-align: middle; margin-top: 15px;">
									</div>
									<div class="servers_col" style="width: 5%; background: #ECF0F0; min-height: 60px; border-left: none; border-right: none;">
										<p style="color: black; text-align: center; display: inline-block; float: left; font-size: 15px; margin-top: 28px;"><b>FIRE</b></p>
									</div>
									<div class="servers_col" style="width: 10%; background: #ECF0F0; min-height: 60px; border-left: none;">
										<p style="color: black; text-align: center; margin-top: 28px; font-size: 15px; color: #1E90FF;"><b>'.$totalFIRE.'</b></p>
									</div>
									<div class="servers_col" style="width: 5%; background: #ECF0F0; min-height: 60px; border-right: none;">
										<img class="" src="Images/weapons/he.png" style="width: 45px; height: 25px; display: inline-block; vertical-align: middle; margin-top: 15px;">
									</div>
									<div class="servers_col" style="width: 5%; background: #ECF0F0; min-height: 60px; border-left: none; border-right: none;">
										<p style="color: black; text-align: center; display: inline-block; float: left; font-size: 15px; margin-top: 28px;"><b>HE-NADE</b></p>
									</div>
									<div class="servers_col" style="width: 10%; background: #ECF0F0; min-height: 60px; border-left: none;">
										<p style="color: black; text-align: center; margin-top: 28px; font-size: 15px; color: #1E90FF;"><b>'.$totalNADE.'</b></p>
									</div>
									<div class="servers_col" style="width: 5%; background: #ECF0F0; min-height: 60px; border-right: none;">
										<img class="" src="Images/weapons/flash.png" style="width: 45px; height: 25px; display: inline-block; vertical-align: middle; margin-top: 15px;">
									</div>
									<div class="servers_col" style="width: 5%; background: #ECF0F0; min-height: 60px; border-left: none; border-right: none;">
										<p style="color: black; text-align: center; display: inline-block; float: left; font-size: 15px; margin-top: 28px;"><b>FLASH</b></p>
									</div>
									<div class="servers_col" style="width: 10%; background: #ECF0F0; min-height: 60px; border-left: none;">
										<p style="color: black; text-align: center; margin-top: 28px; font-size: 15px; color: #1E90FF;"><b>'.$totalFLASH.'</b></p>
									</div>
									<div class="servers_col" style="width: 5%; background: #ECF0F0; min-height: 60px; border-right: none;">
										<img class="" src="Images/weapons/smoke.png" style="width: 45px; height: 25px; display: inline-block; vertical-align: middle; margin-top: 15px;">
									</div>
									<div class="servers_col" style="width: 5%; background: #ECF0F0; min-height: 60px; border-left: none; border-right: none;">
										<p style="color: black; text-align: center; display: inline-block; float: left; font-size: 15px; margin-top: 28px;"><b>SMOKE</b></p>
									</div>
									<div class="servers_col" style="width: 10%; background: #ECF0F0; min-height: 60px; border-left: none;">
										<p style="color: black; text-align: center; margin-top: 28px; font-size: 15px; color: #1E90FF;"><b>'.$totalSMOKE.'</b></p>
									</div>
									<div class="servers_col" style="width: 5%; background: #ECF0F0; min-height: 60px; border-right: none;">
										<img class="" src="Images/weapons/decoy.png" style="width: 45px; height: 25px; display: inline-block; vertical-align: middle; margin-top: 15px;">
									</div>
									<div class="servers_col" style="width: 5%; background: #ECF0F0; min-height: 60px; border-left: none; border-right: none;">
										<p style="color: black; text-align: center; display: inline-block; float: left; font-size: 15px; margin-top: 28px;"><b>DECOY</b></p>
									</div>
									<div class="servers_col" style="width: 10%; background: #ECF0F0; min-height: 60px; border-left: none;">
										<p style="color: black; text-align: center; margin-top: 28px; font-size: 15px; color: #1E90FF;"><b>'.$totalDECOY.'</b></p>
									</div>
								</div>
								';
								?>
								<?php
								}
								else if($selected_type == "5v5s")
								{
								?>
								<div class="servers_row" style="padding-top: 25px">
									<div class="servers_col" style="width: 20%; background: #ECF0F0; height: 215px;">
										<!--
										<img src="Images/avatar.png" class="img-responsive" width="185px" height="185px" style="margin-top: 15px;">
										-->
										<?php
											$steamID = $profileID;
											$url = 'http://api.steampowered.com/ISteamUser/GetPlayerSummaries/v0002/?key=5546C9362128B17919BBF662A72DC5E1&steamids='.$steamID.'';
											$json_object = file_get_contents($url);
											$json_decoded = json_decode($json_object, true);
											
											$name = $json_decoded['response']['players'][0]['personaname'];
											$avatar= $json_decoded['response']['players'][0]['avatarfull'];
											
											echo '<img src="' . $avatar .'" class="img-responsive" width="185px" height="185px" style="margin-top: 15px;">';
										?>
									</div>
									<?php
									$steamid = $connect2->real_escape_string($profile_id);
									$sql = "SELECT DISTINCT * FROM rankme
											WHERE rankme.steam LIKE '%".$steamid."%'";
																		
									$result = $connect2->query($sql);

									if($result->num_rows > 0) 
									{
										while($row = $result->fetch_assoc()) 
										{
											$totalKills = $row['kills'];
											$totalDeaths = $row['deaths'];
											
											if($totalDeaths == 0)
												$totalDeaths2 = 1;
											else
												$totalDeaths2 = $totalDeaths;
											
											$totalKD = round($totalKills/$totalDeaths2, 2);
											
											$roundsTotal = $row['rounds_ct'];
											$roundsTotal += $row['rounds_tr'];
											$damageTotal = $row['damage'];
											$totalADR = round($damageTotal / $roundsTotal, 2);

											$totalAssists = $row['assists'];
										}
									}
									
									echo '
									<div class="servers_col" style="width: 13.333%; background: #ECF0F0; height: 215px;">
											<h2 style="margin-top: 80px;">'.$totalKills.'</h2>
									</div>
									<div class="servers_col" style="width: 13.333%; background: #ECF0F0; height: 215px;">
										<h2 style="margin-top: 80px;">'.$totalAssists.'</h2>
									</div>
									<div class="servers_col" style="width: 13.333%; background: #ECF0F0; height: 215px;">
										<h2 style="margin-top: 80px;">'.$totalDeaths.'</h2>
									</div>
									<div class="servers_col" style="width: 13.333%; background: #ECF0F0; height: 215px;">
										<h2 style="margin-top: 80px;">'.$totalKD.'</h2>
									</div>
									<div class="servers_col" style="width: 13.333%; background: #ECF0F0; height: 215px;">
										<h2 style="margin-top: 80px;">'.$totalADR.'</h2>
									</div>
									<div class="servers_col" style="width: 13.333%; background: #ECF0F0; height: 215px;">
										<h2 style="margin-top: 80px;">N/A</h2>
									</div>
									';
									?>
								</div>
								<div class="servers_row">
									<div class="servers_col" style="width: 20%">
										<!--
										<p style="font-size: 17px;">SeaC</p>
										-->
										<?php
											echo '<p style="font-size: 17px;"><b>'.$name.'</b></p>';
										?>
									</div>
									<div class="servers_col" style="width: 13.333%">
										<p style="font-size: 17px;"><b>Kills</b></p>
									</div>
									<div class="servers_col" style="width: 13.333%">
										<p style="font-size: 17px;"><b>Assists</b></p>
									</div>
									<div class="servers_col" style="width: 13.333%">
										<p style="font-size: 17px;"><b>Deaths</b></p>
									</div>
									<div class="servers_col" style="width: 13.333%">
										<p style="font-size: 17px;"><b>K/D Ratio</b></p>
									</div>
									<div class="servers_col" style="width: 13.333%">
										<p style="font-size: 17px;"><b>ADR</b></p>
									</div>
									<div class="servers_col" style="width: 13.333%">
										<p style="font-size: 17px;"><b>HLTV Rating</b></p>
									</div>
								</div>
		
							</div>
							<div class="title-info" style="height: 500px;">
								<p style="text-align: left; padding-left: 30px;"><b>Recent Matches (Last 10)</b></p>
								
								<div class="servers_row">
									<div class="servers_col" style="width: 20%; background: white;">
										<p style="color: black; text-align: center;">Date</p>
									</div>
									<div class="servers_col" style="width: 20%; background: white;">
										<p style="color: black; text-align: center;">Result</p>
									</div>
									<div class="servers_col" style="width: 20%; background: white;">
										<p style="color: black; text-align: center;">Score</p>
									</div>
									<div class="servers_col" style="width: 25%; background: white;">
										<p style="color: black; text-align: center;">Map</p>
									</div>
									<div class="servers_col" style="width: 15%; background: white;">
										<p style="color: black; text-align: center;">Winner</p>
									</div>
								</div>
								<?php
								$limit2 = 10;
								
								if (isset($_GET["page"])) 
								{
									$page_number = $conn2->real_escape_string($_GET["page"]);
									$offset = ($page_number - 1) * $limit2; 
									
									$search = $conn2->real_escape_string($profileID);
									$sql = "SELECT DISTINCT sql_matches_scoretotal.match_id, sql_matches_scoretotal.timestamp, sql_matches_scoretotal.map, sql_matches_scoretotal.team_2, sql_matches_scoretotal.team_3
											FROM sql_matches_scoretotal INNER JOIN sql_matches
											ON sql_matches_scoretotal.match_id = sql_matches.match_id
											WHERE sql_matches.name LIKE '%".$search."%' OR sql_matches.steamid64 = '".$search."' OR sql_matches_scoretotal.match_id = '".$search."' ORDER BY sql_matches_scoretotal.match_id DESC LIMIT $offset, $limit2";
								}
								else
								{
									$search = $conn2->real_escape_string($profileID);
									$page_number = 1;
									$sql = "SELECT DISTINCT sql_matches_scoretotal.match_id, sql_matches_scoretotal.timestamp, sql_matches_scoretotal.map, sql_matches_scoretotal.team_2, sql_matches_scoretotal.team_3
										FROM sql_matches_scoretotal INNER JOIN sql_matches
										ON sql_matches_scoretotal.match_id = sql_matches.match_id
										WHERE sql_matches.name LIKE '%".$search."%' OR sql_matches.steamid64 = '".$search."' OR sql_matches_scoretotal.match_id = '".$search."' ORDER BY sql_matches_scoretotal.match_id DESC LIMIT $limit2";
								}
								
								$result = $conn2->query($sql);
	
								if($result->num_rows > 0) 
								{
									while($row = $result->fetch_assoc()) 
									{
										$half = ($row["team_2"] + $row["team_3"]) / 2;

										if ($row["team_3"] > $half) 
										{
											$image = 'ct_icon.png';
											$team_win = "CT";
										} 
										elseif ($row["team_2"] == $half && $row["team_3"] == $half) 
										{
											$image = 'tie_icon.png';
											$team_win = "Tie";
										} 
										else 
										{
											$image = 't_icon.png';
											$team_win = "T";
										}
										$map_img = array_search($row["map"], $maps);
										
										$match_id = $conn->real_escape_string($row["match_id"]);
										$sql2 = "SELECT sql_matches_scoretotal.*, sql_matches.*
												FROM sql_matches_scoretotal INNER JOIN sql_matches
												ON sql_matches_scoretotal.match_id = sql_matches.match_id
												WHERE sql_matches_scoretotal.match_id = '".$match_id."' ORDER BY sql_matches.score DESC";
									
										$result2 = $conn2->query($sql2);
									
										$color = "NULL";
										$team1 = "NULL";
										$team2 = "NULL";
										$Match_Result = "NULL";
									
										if ($result2->num_rows > 0) 
										{
											while ($row2 = $result2->fetch_assoc()) 
											{
												$MyTeam_id = $row2["team"];
												if($MyTeam_id == "2")
												{
													$MyTeam = "T";
												}
												else
												{
													$MyTeam = "CT";
												}
												
												if(($row2['steamid64'] == $profileID) && ($MyTeam == $team_win))
												{
													$color = 'green';
													$Match_Result = "Win";
													
													if($row["team_2"] > $row["team_3"])
													{
														$team1 = "team_2";
														$team2 = "team_3";
													}
													else
													{
														$team1 = "team_3";
														$team2 = "team_2";
													}
													break;
												}
												else
												{
													$color = 'red';
													$Match_Result = "Loss";
													if($row["team_2"] > $row["team_3"])
													{
														$team1 = "team_2";
														$team2 = "team_3";
													}
													else
													{
														$team1 = "team_3";
														$team2 = "team_2";
													}
													continue;
												}
											}
										}
												
										echo '<a href="scoreboards_5v5.php?id='.$row["match_id"].'">
												<div class="servers_row">
													<div class="servers_col" style="width: 20%; background: #ECF0F0; min-height: 40px;">
														<p style="color: black; text-align: center;">'.$row['timestamp'].'</p>
													</div>
													<div class="servers_col" style="width: 20%; background: #ECF0F0; min-height: 40px;">
														<p style="color: '.$color.'; text-align: center; display: inline-block;">'.$Match_Result.'</p>
													</div>
													<div class="servers_col" style="width: 20%; background: #ECF0F0; min-height: 40px;">
														<p style="color: '.$color.'; text-align: center; display: inline-block;">'.$row[$team1].' </p><p style="color: black; text-align: center; display: inline-block;"> - </p><p style="color: '.$color.'; text-align: center; display: inline-block; ">'.$row[$team2].'</p>
													</div>
													<div class="servers_col" style="width: 12.5%; background: #ECF0F0; border-right: none; min-height: 40px;">
														<img class="" src="'.$map_img.'?h=4347d1d6c5595286f4b1acacc902fedd" style="width: 50px; height: 35px; display: inline-block; vertical-align: middle; float: right;">
													</div>
													<div class="servers_col" style="width: 12.5%; background: #ECF0F0; border-left: none; min-height: 40px;">
														<p style="color: black; text-align: center; display: inline-block; float: left;">'. $row['map']. '</p>
													</div>
													<div class="servers_col" style="width: 7.5%; background: #ECF0F0; border-right: none; min-height: 40px;">
														<img class="" src="scoreboards/img/'.$image.'?h=4347d1d6c5595286f4b1acacc902fedd" style="width: 25px; height: 25px; margin-top: 7px; float: right;">
														
													</div>
													<div class="servers_col" style="width: 7.5%; background: #ECF0F0; border-left: none; min-height: 40px;">
														<p style="color: black; text-align: center; display: inline-block; float: left;">'. $team_win. '</p>
													</div>
												</div>
											</a>';
									}
								}
								else 
								{
										echo '<h1 style="margin-top:20px;text-align:center;">No Results!</h1>';
								}
								
								?>
								
							</div>
							<div class="title-info" style="height: 780px;">
								<p style="text-align: left; padding-left: 30px;"><b>More Statistics</b></p>
								<?php
								$steamid = $connect2->real_escape_string($profile_id);
								$sql = "SELECT DISTINCT * FROM rankme
										WHERE rankme.steam LIKE '%".$steamid."%'";
																		
								$result = $connect2->query($sql);

								if($result->num_rows > 0) 
								{
									while($row = $result->fetch_assoc()) 
									{
										$headshots = $row['headshots'];
										$kills = $row['kills'];
										$hs = round(($headshots / $kills) * 100, 0);
										
										$defuses = $row['c4_defused'];
										$wallbangs = $row['wallbang'];
										$thruSmoke = $row['thru_smoke'];
										$mvps = $row['mvp'];
										
										//Row 1
										$totalKnife = $row['knife'];
										$totalAK47 = $row['ak47'];
										$totalM4A4 = $row['m4a1'];
										$totalM4A1 = $row['m4a1_silencer'];
										$totalAWP = $row['awp'];
										
										//Row 2
										$totalAUG = $row['aug'];
										$totalSG = $row['sg556'];
										$totalFamas = $row['famas'];
										$totalGalil = $row['galilar'];
										$totalSCAR = $row['scar20'];
										
										//Row 3
										$totalSCOUT = $row['ssg08'];
										$totalNEGEV = $row['negev'];
										$totalM249 = $row['m249'];
										$totalG3 = $row['g3sg1'];
										$totalNOVA = $row['nova'];
										
										//Row 4
										$totalSAW = $row['sawedoff'];
										$totalXM = $row['xm1014'];
										$totalMAG = $row['mag7'];
										$totalBIZ = $row['bizon'];
										$totalMP5 = $row['mp5sd'];
										
										//Row 5
										$totalUSP = $row['usp_silencer'];
										$totalP2000 = $row['hkp2000'];
										$totalGLOCK = $row['glock'];
										$totalP250 = $row['p250'];
										$totalDEAGLE = $row['deagle'];
										
										//Row 6
										$totalDUAL = $row['elite'];
										$total57 = $row['fiveseven'];
										$totalTEC9 = $row['tec9'];
										$totalCZ = $row['cz75a'];
										$totalR8 = $row['revolver'];
										
										//Row 6
										$totalFIRE = $row['inferno'];
										$totalNADE = $row['hegrenade'];
										$totalFLASH = $row['flashbang'];
										$totalSMOKE = $row['smokegrenade'];
										$totalDECOY = $row['decoy'];
									}
								}
								echo '
								<div class="servers_row">
									<div class="servers_col" style="width: 100%; background: white;">
										<p style="color: black; text-align: center;">More Stats</p>
									</div>
								</div>
								<div class="servers_row">
									<div class="servers_col" style="width: 20%; background: #ECF0F0; min-height: 200px; border-right: none;">
										<img class="" src="Images/defusekit.png" style="width: 70px; height: 70px; margin-top: 25px;">
										<p style="font-size: 18px;"><b>Defuses</b></p>
										<p style="font-size: 18px; color: #1E90FF; margin-top: 25px;"><b>'.$defuses.'</b></p>
									</div>
									<div class="servers_col" style="width: 20%; background: #ECF0F0; min-height: 200px; border-left: none; border-right: none;">
										<img class="" src="Images/headshot.png" style="width: 80px; height: 70px; margin-top: 25px;">
										<p style="font-size: 18px;"><b>Headshot %</b></p>
										<p style="font-size: 18px; color: #1E90FF; margin-top: 25px;"><b>'.$hs.'</b></p>
									</div>
									<div class="servers_col" style="width: 20%; background: #ECF0F0; min-height: 200px; border-right: none; border-left: none;">
										<img class="" src="Images/wallbang.png" style="width: 80px; height: 70px; margin-top: 25px;">
										<p style="font-size: 18px;"><b>Wallbangs</b></p>
										<p style="font-size: 18px; color: #1E90FF; margin-top: 25px;"><b>'.$wallbangs.'</b></p>
									</div>
									<div class="servers_col" style="width: 20%; background: #ECF0F0; min-height: 200px; border-right: none; border-left: none;">
										<img class="" src="Images/thrusmoke.png" style="width: 80px; height: 70px; margin-top: 25px;">
										<p style="font-size: 18px;"><b>Thru-Smoke</b></p>
										<p style="font-size: 18px; color: #1E90FF; margin-top: 25px;"><b>'.$thruSmoke.'</b></p>
									</div>
									<div class="servers_col" style="width: 20%; background: #ECF0F0; min-height: 200px; border-left: none;">
										<img class="" src="Images/mvp.png" style="width: 70px; height: 70px; margin-top: 25px;">
										<p style="font-size: 18px;"><b>MVPs</b></p>
										<p style="font-size: 18px; color: #1E90FF; margin-top: 25px;"><b>'.$mvps.'</b></p>
									</div>
								</div>
								
								<div class="servers_row" style="margin-top: 25px;">
									<div class="servers_col" style="width: 100%; background: white;">
										<p style="color: black; text-align: center;">Weapon Stats [Kills]</p>
									</div>
								</div>
								<div class="servers_row">
									<div class="servers_col" style="width: 5%; background: #ECF0F0; min-height: 60px; border-right: none;">
										<img class="" src="Images/weapons/knife.png" style="width: 45px; height: 45px; display: inline-block; vertical-align: middle; margin-top: 5px;">
									</div>
									<div class="servers_col" style="width: 5%; background: #ECF0F0; min-height: 60px; border-left: none; border-right: none;">
										<p style="color: black; text-align: center; display: inline-block; float: left; font-size: 15px; margin-top: 28px;"><b>KNIFES</b></p>
									</div>
									<div class="servers_col" style="width: 10%; background: #ECF0F0; min-height: 60px; border-left: none;">
										<p style="color: black; text-align: center; margin-top: 28px; font-size: 15px; color: #1E90FF;"><b>'.$totalKnife.'</b></p>
									</div>
									<div class="servers_col" style="width: 5%; background: #ECF0F0; min-height: 60px; border-right: none;">
										<img class="" src="Images/weapons/ak47.png" style="width: 45px; height: 45px; display: inline-block; vertical-align: middle; margin-top: 5px;">
									</div>
									<div class="servers_col" style="width: 5%; background: #ECF0F0; min-height: 60px; border-left: none; border-right: none;">
										<p style="color: black; text-align: center; display: inline-block; float: left; font-size: 15px; margin-top: 28px;"><b>AK47</b></p>
									</div>
									<div class="servers_col" style="width: 10%; background: #ECF0F0; min-height: 60px; border-left: none;">
										<p style="color: black; text-align: center; margin-top: 28px; font-size: 15px; color: #1E90FF;"><b>'.$totalAK47.'</b></p>
									</div>
									<div class="servers_col" style="width: 5%; background: #ECF0F0; min-height: 60px; border-right: none;">
										<img class="" src="Images/weapons/m4a4.png" style="width: 45px; height: 45px; display: inline-block; vertical-align: middle; margin-top: 5px;">
									</div>
									<div class="servers_col" style="width: 5%; background: #ECF0F0; min-height: 60px; border-left: none; border-right: none;">
										<p style="color: black; text-align: center; display: inline-block; float: left; font-size: 15px; margin-top: 28px;"><b>M4A4</b></p>
									</div>
									<div class="servers_col" style="width: 10%; background: #ECF0F0; min-height: 60px; border-left: none;">
										<p style="color: black; text-align: center; margin-top: 28px; font-size: 15px; color: #1E90FF;"><b>'.$totalM4A4.'</b></p>
									</div>
									<div class="servers_col" style="width: 5%; background: #ECF0F0; min-height: 60px; border-right: none;">
										<img class="" src="Images/weapons/m4a1.png" style="width: 45px; height: 45px; display: inline-block; vertical-align: middle; margin-top: 5px;">
									</div>
									<div class="servers_col" style="width: 5%; background: #ECF0F0; min-height: 60px; border-left: none; border-right: none;">
										<p style="color: black; text-align: center; display: inline-block; float: left; font-size: 15px; margin-top: 28px;"><b>M4A1-S</b></p>
									</div>
									<div class="servers_col" style="width: 10%; background: #ECF0F0; min-height: 60px; border-left: none;">
										<p style="color: black; text-align: center; margin-top: 28px; font-size: 15px; color: #1E90FF;"><b>'.$totalM4A1.'</b></p>
									</div>
									<div class="servers_col" style="width: 5%; background: #ECF0F0; min-height: 60px; border-right: none;">
										<img class="" src="Images/weapons/AWP.png" style="width: 45px; height: 45px; display: inline-block; vertical-align: middle; margin-top: 5px;">
									</div>
									<div class="servers_col" style="width: 5%; background: #ECF0F0; min-height: 60px; border-left: none; border-right: none;">
										<p style="color: black; text-align: center; display: inline-block; float: left; font-size: 15px; margin-top: 28px;"><b>AWP</b></p>
									</div>
									<div class="servers_col" style="width: 10%; background: #ECF0F0; min-height: 60px; border-left: none;">
										<p style="color: black; text-align: center; margin-top: 28px; font-size: 15px; color: #1E90FF;"><b>'.$totalAWP.'</b></p>
									</div>
								</div>
								<div class="servers_row">
									<div class="servers_col" style="width: 5%; background: #ECF0F0; min-height: 60px; border-right: none;">
										<img class="" src="Images/weapons/aug.png" style="width: 45px; height: 45px; display: inline-block; vertical-align: middle; margin-top: 5px;">
									</div>
									<div class="servers_col" style="width: 5%; background: #ECF0F0; min-height: 60px; border-left: none; border-right: none;">
										<p style="color: black; text-align: center; display: inline-block; float: left; font-size: 15px; margin-top: 28px;"><b>AUG</b></p>
									</div>
									<div class="servers_col" style="width: 10%; background: #ECF0F0; min-height: 60px; border-left: none;">
										<p style="color: black; text-align: center; margin-top: 28px; font-size: 15px; color: #1E90FF;"><b>'.$totalAUG.'</b></p>
									</div>
									<div class="servers_col" style="width: 5%; background: #ECF0F0; min-height: 60px; border-right: none;">
										<img class="" src="Images/weapons/sg.png" style="width: 45px; height: 45px; display: inline-block; vertical-align: middle; margin-top: 5px;">
									</div>
									<div class="servers_col" style="width: 5%; background: #ECF0F0; min-height: 60px; border-left: none; border-right: none;">
										<p style="color: black; text-align: center; display: inline-block; float: left; font-size: 15px; margin-top: 28px;"><b>SG553</b></p>
									</div>
									<div class="servers_col" style="width: 10%; background: #ECF0F0; min-height: 60px; border-left: none;">
										<p style="color: black; text-align: center; margin-top: 28px; font-size: 15px; color: #1E90FF;"><b>'.$totalSG.'</b></p>
									</div>
									<div class="servers_col" style="width: 5%; background: #ECF0F0; min-height: 60px; border-right: none;">
										<img class="" src="Images/weapons/famas.png" style="width: 45px; height: 45px; display: inline-block; vertical-align: middle; margin-top: 5px;">
									</div>
									<div class="servers_col" style="width: 5%; background: #ECF0F0; min-height: 60px; border-left: none; border-right: none;">
										<p style="color: black; text-align: center; display: inline-block; float: left; font-size: 15px; margin-top: 28px;"><b>FAMAS</b></p>
									</div>
									<div class="servers_col" style="width: 10%; background: #ECF0F0; min-height: 60px; border-left: none;">
										<p style="color: black; text-align: center; margin-top: 28px; font-size: 15px; color: #1E90FF;"><b>'.$totalFamas.'</b></p>
									</div>
									<div class="servers_col" style="width: 5%; background: #ECF0F0; min-height: 60px; border-right: none;">
										<img class="" src="Images/weapons/galil.png" style="width: 45px; height: 45px; display: inline-block; vertical-align: middle; margin-top: 5px;">
									</div>
									<div class="servers_col" style="width: 5%; background: #ECF0F0; min-height: 60px; border-left: none; border-right: none;">
										<p style="color: black; text-align: center; display: inline-block; float: left; font-size: 15px; margin-top: 28px;"><b>GALILAR</b></p>
									</div>
									<div class="servers_col" style="width: 10%; background: #ECF0F0; min-height: 60px; border-left: none;">
										<p style="color: black; text-align: center; margin-top: 28px; font-size: 15px; color: #1E90FF;"><b>'.$totalGalil.'</b></p>
									</div>
									<div class="servers_col" style="width: 5%; background: #ECF0F0; min-height: 60px; border-right: none;">
										<img class="" src="Images/weapons/scar20.png" style="width: 45px; height: 45px; display: inline-block; vertical-align: middle; margin-top: 5px;">
									</div>
									<div class="servers_col" style="width: 5%; background: #ECF0F0; min-height: 60px; border-left: none; border-right: none;">
										<p style="color: black; text-align: center; display: inline-block; float: left; font-size: 15px; margin-top: 28px;"><b>SCAR20</b></p>
									</div>
									<div class="servers_col" style="width: 10%; background: #ECF0F0; min-height: 60px; border-left: none;">
										<p style="color: black; text-align: center; margin-top: 28px; font-size: 15px; color: #1E90FF;"><b>'.$totalSCAR.'</b></p>
									</div>
								</div>
								<div class="servers_row">
									<div class="servers_col" style="width: 5%; background: #ECF0F0; min-height: 60px; border-right: none;">
										<img class="" src="Images/weapons/scout.png" style="width: 45px; height: 45px; display: inline-block; vertical-align: middle; margin-top: 5px;">
									</div>
									<div class="servers_col" style="width: 5%; background: #ECF0F0; min-height: 60px; border-left: none; border-right: none;">
										<p style="color: black; text-align: center; display: inline-block; float: left; font-size: 15px; margin-top: 28px;"><b>SSG08</b></p>
									</div>
									<div class="servers_col" style="width: 10%; background: #ECF0F0; min-height: 60px; border-left: none;">
										<p style="color: black; text-align: center; margin-top: 28px; font-size: 15px; color: #1E90FF;"><b>'.$totalSCOUT.'</b></p>
									</div>
									<div class="servers_col" style="width: 5%; background: #ECF0F0; min-height: 60px; border-right: none;">
										<img class="" src="Images/weapons/negev.png" style="width: 45px; height: 45px; display: inline-block; vertical-align: middle; margin-top: 5px;">
									</div>
									<div class="servers_col" style="width: 5%; background: #ECF0F0; min-height: 60px; border-left: none; border-right: none;">
										<p style="color: black; text-align: center; display: inline-block; float: left; font-size: 15px; margin-top: 28px;"><b>NEGEV</b></p>
									</div>
									<div class="servers_col" style="width: 10%; background: #ECF0F0; min-height: 60px; border-left: none;">
										<p style="color: black; text-align: center; margin-top: 28px; font-size: 15px; color: #1E90FF;"><b>'.$totalNEGEV.'</b></p>
									</div>
									<div class="servers_col" style="width: 5%; background: #ECF0F0; min-height: 60px; border-right: none;">
										<img class="" src="Images/weapons/m249.png" style="width: 45px; height: 45px; display: inline-block; vertical-align: middle; margin-top: 5px;">
									</div>
									<div class="servers_col" style="width: 5%; background: #ECF0F0; min-height: 60px; border-left: none; border-right: none;">
										<p style="color: black; text-align: center; display: inline-block; float: left; font-size: 15px; margin-top: 28px;"><b>M249</b></p>
									</div>
									<div class="servers_col" style="width: 10%; background: #ECF0F0; min-height: 60px; border-left: none;">
										<p style="color: black; text-align: center; margin-top: 28px; font-size: 15px; color: #1E90FF;"><b>'.$totalM249.'</b></p>
									</div>
									<div class="servers_col" style="width: 5%; background: #ECF0F0; min-height: 60px; border-right: none;">
										<img class="" src="Images/weapons/g3sg1.png" style="width: 45px; height: 45px; display: inline-block; vertical-align: middle; margin-top: 5px;">
									</div>
									<div class="servers_col" style="width: 5%; background: #ECF0F0; min-height: 60px; border-left: none; border-right: none;">
										<p style="color: black; text-align: center; display: inline-block; float: left; font-size: 15px; margin-top: 28px;"><b>G3SG1</b></p>
									</div>
									<div class="servers_col" style="width: 10%; background: #ECF0F0; min-height: 60px; border-left: none;">
										<p style="color: black; text-align: center; margin-top: 28px; font-size: 15px; color: #1E90FF;"><b>'.$totalG3.'</b></p>
									</div>
									<div class="servers_col" style="width: 5%; background: #ECF0F0; min-height: 60px; border-right: none;">
										<img class="" src="Images/weapons/nova.png" style="width: 45px; height: 45px; display: inline-block; vertical-align: middle; margin-top: 5px;">
									</div>
									<div class="servers_col" style="width: 5%; background: #ECF0F0; min-height: 60px; border-left: none; border-right: none;">
										<p style="color: black; text-align: center; display: inline-block; float: left; font-size: 15px; margin-top: 28px;"><b>NOVA</b></p>
									</div>
									<div class="servers_col" style="width: 10%; background: #ECF0F0; min-height: 60px; border-left: none;">
										<p style="color: black; text-align: center; margin-top: 28px; font-size: 15px; color: #1E90FF;"><b>'.$totalNOVA.'</b></p>
									</div>
								</div>
								<div class="servers_row">
									<div class="servers_col" style="width: 5%; background: #ECF0F0; min-height: 60px; border-right: none;">
										<img class="" src="Images/weapons/saw.png" style="width: 45px; height: 45px; display: inline-block; vertical-align: middle; margin-top: 5px;">
									</div>
									<div class="servers_col" style="width: 5%; background: #ECF0F0; min-height: 60px; border-left: none; border-right: none;">
										<p style="color: black; text-align: center; display: inline-block; float: left; font-size: 11px; margin-top: 28px;"><b>SAWED-OFF</b></p>
									</div>
									<div class="servers_col" style="width: 10%; background: #ECF0F0; min-height: 60px; border-left: none;">
										<p style="color: black; text-align: center; margin-top: 28px; font-size: 15px; color: #1E90FF;"><b>'.$totalSAW.'</b></p>
									</div>
									<div class="servers_col" style="width: 5%; background: #ECF0F0; min-height: 60px; border-right: none;">
										<img class="" src="Images/weapons/xm.png" style="width: 45px; height: 45px; display: inline-block; vertical-align: middle; margin-top: 5px;">
									</div>
									<div class="servers_col" style="width: 5%; background: #ECF0F0; min-height: 60px; border-left: none; border-right: none;">
										<p style="color: black; text-align: center; display: inline-block; float: left; font-size: 15px; margin-top: 28px;"><b>XM1014</b></p>
									</div>
									<div class="servers_col" style="width: 10%; background: #ECF0F0; min-height: 60px; border-left: none;">
										<p style="color: black; text-align: center; margin-top: 28px; font-size: 15px; color: #1E90FF;"><b>'.$totalXM.'</b></p>
									</div>
									<div class="servers_col" style="width: 5%; background: #ECF0F0; min-height: 60px; border-right: none;">
										<img class="" src="Images/weapons/mag7.png" style="width: 45px; height: 45px; display: inline-block; vertical-align: middle; margin-top: 5px;">
									</div>
									<div class="servers_col" style="width: 5%; background: #ECF0F0; min-height: 60px; border-left: none; border-right: none;">
										<p style="color: black; text-align: center; display: inline-block; float: left; font-size: 15px; margin-top: 28px;"><b>MAG7</b></p>
									</div>
									<div class="servers_col" style="width: 10%; background: #ECF0F0; min-height: 60px; border-left: none;">
										<p style="color: black; text-align: center; margin-top: 28px; font-size: 15px; color: #1E90FF;"><b>'.$totalMAG.'</b></p>
									</div>
									<div class="servers_col" style="width: 5%; background: #ECF0F0; min-height: 60px; border-right: none;">
										<img class="" src="Images/weapons/pp.png" style="width: 45px; height: 45px; display: inline-block; vertical-align: middle; margin-top: 5px;">
									</div>
									<div class="servers_col" style="width: 5%; background: #ECF0F0; min-height: 60px; border-left: none; border-right: none;">
										<p style="color: black; text-align: center; display: inline-block; float: left; font-size: 15px; margin-top: 28px;"><b>BIZON</b></p>
									</div>
									<div class="servers_col" style="width: 10%; background: #ECF0F0; min-height: 60px; border-left: none;">
										<p style="color: black; text-align: center; margin-top: 28px; font-size: 15px; color: #1E90FF;"><b>'.$totalBIZ.'</b></p>
									</div>
									<div class="servers_col" style="width: 5%; background: #ECF0F0; min-height: 60px; border-right: none;">
										<img class="" src="Images/weapons/mp5sd.png" style="width: 45px; height: 45px; display: inline-block; vertical-align: middle; margin-top: 5px;">
									</div>
									<div class="servers_col" style="width: 5%; background: #ECF0F0; min-height: 60px; border-left: none; border-right: none;">
										<p style="color: black; text-align: center; display: inline-block; float: left; font-size: 15px; margin-top: 28px;"><b>MP5-SD</b></p>
									</div>
									<div class="servers_col" style="width: 10%; background: #ECF0F0; min-height: 60px; border-left: none;">
										<p style="color: black; text-align: center; margin-top: 28px; font-size: 15px; color: #1E90FF;"><b>'.$totalMP5.'</b></p>
									</div>
								</div>
								<div class="servers_row">
									<div class="servers_col" style="width: 5%; background: #ECF0F0; min-height: 60px; border-right: none;">
										<img class="" src="Images/weapons/usp.png" style="width: 45px; height: 45px; display: inline-block; vertical-align: middle; margin-top: 5px;">
									</div>
									<div class="servers_col" style="width: 5%; background: #ECF0F0; min-height: 60px; border-left: none; border-right: none;">
										<p style="color: black; text-align: center; display: inline-block; float: left; font-size: 15px; margin-top: 28px;"><b>USP-S</b></p>
									</div>
									<div class="servers_col" style="width: 10%; background: #ECF0F0; min-height: 60px; border-left: none;">
										<p style="color: black; text-align: center; margin-top: 28px; font-size: 15px; color: #1E90FF;"><b>'.$totalUSP.'</b></p>
									</div>
									<div class="servers_col" style="width: 5%; background: #ECF0F0; min-height: 60px; border-right: none;">
										<img class="" src="Images/weapons/p2000.png" style="width: 45px; height: 45px; display: inline-block; vertical-align: middle; margin-top: 5px;">
									</div>
									<div class="servers_col" style="width: 5%; background: #ECF0F0; min-height: 60px; border-left: none; border-right: none;">
										<p style="color: black; text-align: center; display: inline-block; float: left; font-size: 15px; margin-top: 28px;"><b>P2000</b></p>
									</div>
									<div class="servers_col" style="width: 10%; background: #ECF0F0; min-height: 60px; border-left: none;">
										<p style="color: black; text-align: center; margin-top: 28px; font-size: 15px; color: #1E90FF;"><b>'.$totalP2000.'</b></p>
									</div>
									<div class="servers_col" style="width: 5%; background: #ECF0F0; min-height: 60px; border-right: none;">
										<img class="" src="Images/weapons/glock.png" style="width: 45px; height: 45px; display: inline-block; vertical-align: middle; margin-top: 5px;">
									</div>
									<div class="servers_col" style="width: 5%; background: #ECF0F0; min-height: 60px; border-left: none; border-right: none;">
										<p style="color: black; text-align: center; display: inline-block; float: left; font-size: 15px; margin-top: 28px;"><b>GLOCK</b></p>
									</div>
									<div class="servers_col" style="width: 10%; background: #ECF0F0; min-height: 60px; border-left: none;">
										<p style="color: black; text-align: center; margin-top: 28px; font-size: 15px; color: #1E90FF;"><b>'.$totalGLOCK.'</b></p>
									</div>
									<div class="servers_col" style="width: 5%; background: #ECF0F0; min-height: 60px; border-right: none;">
										<img class="" src="Images/weapons/p250.png" style="width: 45px; height: 45px; display: inline-block; vertical-align: middle; margin-top: 5px;">
									</div>
									<div class="servers_col" style="width: 5%; background: #ECF0F0; min-height: 60px; border-left: none; border-right: none;">
										<p style="color: black; text-align: center; display: inline-block; float: left; font-size: 15px; margin-top: 28px;"><b>P250</b></p>
									</div>
									<div class="servers_col" style="width: 10%; background: #ECF0F0; min-height: 60px; border-left: none;">
										<p style="color: black; text-align: center; margin-top: 28px; font-size: 15px; color: #1E90FF;"><b>'.$totalP250.'</b></p>
									</div>
									<div class="servers_col" style="width: 5%; background: #ECF0F0; min-height: 60px; border-right: none;">
										<img class="" src="Images/weapons/deagle.png" style="width: 45px; height: 45px; display: inline-block; vertical-align: middle; margin-top: 5px;">
									</div>
									<div class="servers_col" style="width: 5%; background: #ECF0F0; min-height: 60px; border-left: none; border-right: none;">
										<p style="color: black; text-align: center; display: inline-block; float: left; font-size: 15px; margin-top: 28px;"><b>DEAGLE</b></p>
									</div>
									<div class="servers_col" style="width: 10%; background: #ECF0F0; min-height: 60px; border-left: none;">
										<p style="color: black; text-align: center; margin-top: 28px; font-size: 15px; color: #1E90FF;"><b>'.$totalDEAGLE.'</b></p>
									</div>
								</div>
								<div class="servers_row">
									<div class="servers_col" style="width: 5%; background: #ECF0F0; min-height: 60px; border-right: none;">
										<img class="" src="Images/weapons/dual.png" style="width: 45px; height: 45px; display: inline-block; vertical-align: middle; margin-top: 5px;">
									</div>
									<div class="servers_col" style="width: 5%; background: #ECF0F0; min-height: 60px; border-left: none; border-right: none;">
										<p style="color: black; text-align: center; display: inline-block; float: left; font-size: 15px; margin-top: 28px;"><b>DUAL-B</b></p>
									</div>
									<div class="servers_col" style="width: 10%; background: #ECF0F0; min-height: 60px; border-left: none;">
										<p style="color: black; text-align: center; margin-top: 28px; font-size: 15px; color: #1E90FF;"><b>'.$totalDUAL.'</b></p>
									</div>
									<div class="servers_col" style="width: 5%; background: #ECF0F0; min-height: 60px; border-right: none;">
										<img class="" src="Images/weapons/five7.png" style="width: 45px; height: 45px; display: inline-block; vertical-align: middle; margin-top: 5px;">
									</div>
									<div class="servers_col" style="width: 5%; background: #ECF0F0; min-height: 60px; border-left: none; border-right: none;">
										<p style="color: black; text-align: center; display: inline-block; float: left; font-size: 15px; margin-top: 28px;"><b>FIVE-7</b></p>
									</div>
									<div class="servers_col" style="width: 10%; background: #ECF0F0; min-height: 60px; border-left: none;">
										<p style="color: black; text-align: center; margin-top: 28px; font-size: 15px; color: #1E90FF;"><b>'.$total57.'</b></p>
									</div>
									<div class="servers_col" style="width: 5%; background: #ECF0F0; min-height: 60px; border-right: none;">
										<img class="" src="Images/weapons/tec9.png" style="width: 45px; height: 45px; display: inline-block; vertical-align: middle; margin-top: 5px;">
									</div>
									<div class="servers_col" style="width: 5%; background: #ECF0F0; min-height: 60px; border-left: none; border-right: none;">
										<p style="color: black; text-align: center; display: inline-block; float: left; font-size: 15px; margin-top: 28px;"><b>TEC9</b></p>
									</div>
									<div class="servers_col" style="width: 10%; background: #ECF0F0; min-height: 60px; border-left: none;">
										<p style="color: black; text-align: center; margin-top: 28px; font-size: 15px; color: #1E90FF;"><b>'.$totalTEC9.'</b></p>
									</div>
									<div class="servers_col" style="width: 5%; background: #ECF0F0; min-height: 60px; border-right: none;">
										<img class="" src="Images/weapons/cz75.png" style="width: 45px; height: 45px; display: inline-block; vertical-align: middle; margin-top: 5px;">
									</div>
									<div class="servers_col" style="width: 5%; background: #ECF0F0; min-height: 60px; border-left: none; border-right: none;">
										<p style="color: black; text-align: center; display: inline-block; float: left; font-size: 15px; margin-top: 28px;"><b>CZ75A</b></p>
									</div>
									<div class="servers_col" style="width: 10%; background: #ECF0F0; min-height: 60px; border-left: none;">
										<p style="color: black; text-align: center; margin-top: 28px; font-size: 15px; color: #1E90FF;"><b>'.$totalCZ.'</b></p>
									</div>
									<div class="servers_col" style="width: 5%; background: #ECF0F0; min-height: 60px; border-right: none;">
										<img class="" src="Images/weapons/r8.png" style="width: 45px; height: 45px; display: inline-block; vertical-align: middle; margin-top: 5px;">
									</div>
									<div class="servers_col" style="width: 5%; background: #ECF0F0; min-height: 60px; border-left: none; border-right: none;">
										<p style="color: black; text-align: center; display: inline-block; float: left; font-size: 15px; margin-top: 28px;"><b>R8</b></p>
									</div>
									<div class="servers_col" style="width: 10%; background: #ECF0F0; min-height: 60px; border-left: none;">
										<p style="color: black; text-align: center; margin-top: 28px; font-size: 15px; color: #1E90FF;"><b>'.$totalR8.'</b></p>
									</div>
								</div>
								<div class="servers_row">
									<div class="servers_col" style="width: 5%; background: #ECF0F0; min-height: 60px; border-right: none;">
										<img class="" src="Images/weapons/ctmolly.png" style="width: 45px; height: 25px; display: inline-block; vertical-align: middle; margin-top: 15px;">
									</div>
									<div class="servers_col" style="width: 5%; background: #ECF0F0; min-height: 60px; border-left: none; border-right: none;">
										<p style="color: black; text-align: center; display: inline-block; float: left; font-size: 15px; margin-top: 28px;"><b>FIRE</b></p>
									</div>
									<div class="servers_col" style="width: 10%; background: #ECF0F0; min-height: 60px; border-left: none;">
										<p style="color: black; text-align: center; margin-top: 28px; font-size: 15px; color: #1E90FF;"><b>'.$totalFIRE.'</b></p>
									</div>
									<div class="servers_col" style="width: 5%; background: #ECF0F0; min-height: 60px; border-right: none;">
										<img class="" src="Images/weapons/he.png" style="width: 45px; height: 25px; display: inline-block; vertical-align: middle; margin-top: 15px;">
									</div>
									<div class="servers_col" style="width: 5%; background: #ECF0F0; min-height: 60px; border-left: none; border-right: none;">
										<p style="color: black; text-align: center; display: inline-block; float: left; font-size: 15px; margin-top: 28px;"><b>HE-NADE</b></p>
									</div>
									<div class="servers_col" style="width: 10%; background: #ECF0F0; min-height: 60px; border-left: none;">
										<p style="color: black; text-align: center; margin-top: 28px; font-size: 15px; color: #1E90FF;"><b>'.$totalNADE.'</b></p>
									</div>
									<div class="servers_col" style="width: 5%; background: #ECF0F0; min-height: 60px; border-right: none;">
										<img class="" src="Images/weapons/flash.png" style="width: 45px; height: 25px; display: inline-block; vertical-align: middle; margin-top: 15px;">
									</div>
									<div class="servers_col" style="width: 5%; background: #ECF0F0; min-height: 60px; border-left: none; border-right: none;">
										<p style="color: black; text-align: center; display: inline-block; float: left; font-size: 15px; margin-top: 28px;"><b>FLASH</b></p>
									</div>
									<div class="servers_col" style="width: 10%; background: #ECF0F0; min-height: 60px; border-left: none;">
										<p style="color: black; text-align: center; margin-top: 28px; font-size: 15px; color: #1E90FF;"><b>'.$totalFLASH.'</b></p>
									</div>
									<div class="servers_col" style="width: 5%; background: #ECF0F0; min-height: 60px; border-right: none;">
										<img class="" src="Images/weapons/smoke.png" style="width: 45px; height: 25px; display: inline-block; vertical-align: middle; margin-top: 15px;">
									</div>
									<div class="servers_col" style="width: 5%; background: #ECF0F0; min-height: 60px; border-left: none; border-right: none;">
										<p style="color: black; text-align: center; display: inline-block; float: left; font-size: 15px; margin-top: 28px;"><b>SMOKE</b></p>
									</div>
									<div class="servers_col" style="width: 10%; background: #ECF0F0; min-height: 60px; border-left: none;">
										<p style="color: black; text-align: center; margin-top: 28px; font-size: 15px; color: #1E90FF;"><b>'.$totalSMOKE.'</b></p>
									</div>
									<div class="servers_col" style="width: 5%; background: #ECF0F0; min-height: 60px; border-right: none;">
										<img class="" src="Images/weapons/decoy.png" style="width: 45px; height: 25px; display: inline-block; vertical-align: middle; margin-top: 15px;">
									</div>
									<div class="servers_col" style="width: 5%; background: #ECF0F0; min-height: 60px; border-left: none; border-right: none;">
										<p style="color: black; text-align: center; display: inline-block; float: left; font-size: 15px; margin-top: 28px;"><b>DECOY</b></p>
									</div>
									<div class="servers_col" style="width: 10%; background: #ECF0F0; min-height: 60px; border-left: none;">
										<p style="color: black; text-align: center; margin-top: 28px; font-size: 15px; color: #1E90FF;"><b>'.$totalDECOY.'</b></p>
									</div>
								</div>
								';
								?>
								<?php
								}
								else
								{
									echo 'Error in tag: id.';
								}
							}
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