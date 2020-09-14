<?php
    require ('steamauth/steamauth.php');
	require ('SourceQuery/bootstrap.php');
	
	include_once 'convertSteamID.php';
	
	use xPaw\SourceQuery\SourceQuery;
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
	<link href="css/style_index.css" rel="stylesheet" type="text/css">
	
	<link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Open+Sans|Raleway|Candal">
	<link rel="stylesheet" type="text/css" href="css/font-awesome.min.css">
</head>

<?php
	function Query_Server($ip, $port, $type)
	{
		$Query = new SourceQuery( );
		
		try
		{
			$Query->Connect( $ip, $port, 1, SourceQuery::SOURCE );
			
			if($type == "Ping")
				return $Query->Ping( );
			elseif($type == "Info")
				return $Query->GetInfo( );
			elseif($type == "Players")
				return $Query->GetPlayers( );
		}
		catch( Exception $e )
		{
			echo $e->getMessage( );
		}
		finally
		{
			$Query->Disconnect( );
		}
	}
?>

<?php
	function getServer($ip, $port, $request)
	{
		$ServerInfo = Query_Server($ip, $port, 'Info');
		$ServerPing = Query_Server($ip, $port, 'Ping');
		$ServerPlayers = Query_Server($ip, $port, 'Players');
		
		if($request == "Info")
			return $ServerInfo;
		elseif($request == "Ping")
			return $ServerPing;
		else
			return $ServerPlayers;
	}
?>


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
							<a href="index.php" class="active"><img src="Images/server2.png" class="center" width="30px" height="30px" style="vertical-align: middle;"> <b>Servers</b></a>
							<a href="scoreboards.php?id=10mans" ><img src="Images/csgo-icon.png" class="center" width="30px" height="30px" style="vertical-align: middle;"> Scoreboards</a>
							<a href="leaderboards.php?id=10mans" ><img src="Images/csgo-icon.png" class="center" width="30px" height="30px" style="vertical-align: middle;"> Leaderboards</a>
							<a href="https://bans.ckl-gaming.com/" ><img src="Images/csgo-icon-x.png" class="center" width="30px" height="30px" style="vertical-align: middle;"> Sourcebans</a>
							<a href="stats_coming_soon.php" ><img src="Images/minecraft.png" class="center" width="30px" height="30px" style="vertical-align: middle;"> World-Map</a>
							<a href="stats_coming_soon.php" ><img src="Images/minecraft-x.png" class="center" width="30px" height="30px" style="vertical-align: middle;"> Bans</a>
						</div>
						<div class="stats_navbar_col" style="width: 80%; background: #ECF0F0; padding-left: 2%; padding-right: 2%;">
							<div class="title-navbar">
								<p>ckL-Gaming.com<br>Stats - Servers</p>
							</div>
							<div class="title-info">
								<div class="servers_row" style="padding-top: 25px">
									<div class="servers_col" style="width: 5%">
										<p><b>Game</b></p>
									</div>
									<div class="servers_col" style="width: 5%">
										<p><b>Region</b></p>
									</div>
									<div class="servers_col" style="width: 5%">
										<p><b>OS</b></p>
									</div>
									<div class="servers_col" style="width: 5%">
										<p><b>AC</b></p>
									</div>
									<div class="servers_col" style="width: 7%">
										<p><b>Status</b></p>
									</div>
									<div class="servers_col" style="width: 40%">
										<p><b>Hostname</b></p>
									</div>
									<div class="servers_col" style="width: 10%">
										<p><b>Players</b></p>
									</div>
									<div class="servers_col" style="width: 10%">
										<p><b>Map</b></p>
									</div>
									<div class="servers_col" style="width: 13%">
										<p><b>IP</b></p>
									</div>
								</div>
								
								<?php
								$ip[0] = '74.91.124.5'; $port[0] = '27015';
								$ip[1] = '74.91.121.238'; $port[1] = '27015';
								$ip[2] = '208.167.251.47'; $port[2] = '27015';
								$ip[3] = '74.91.124.204'; $port[3] = '27015';
								$ip[4] = '108.61.88.139'; $port[4] = '27015';
								$ip[5] = '74.91.121.238'; $port[5] = '27017';
								$ip[6] = '74.91.121.238'; $port[6] = '27019';
								
								for($i = 0; $i <= 6; $i++)
								{
									$Server[$i] = getServer($ip[$i], $port[$i], 'Info');
									$Server1_Ping[$i] = getServer($ip[$i], $port[$i], 'Ping');
									
									if($Server1_Ping[$i] == 1)
									{
										$Server_Status[$i] = "Online";
										$Server_Color[$i] = "#26b526";
										$Server_Name[$i] = $Server[$i]['HostName'];
										$Server_Map[$i] = $Server[$i]['Map'];
										$Server_Players[$i] = $Server[$i]['Players'];
										$Server_MaxPlayers[$i] = $Server[$i]['MaxPlayers'];
										$Server_Address[$i] = $ip[$i] . ":" . $port[$i];
										
										if($Server[$i]['Os'] == "l")
											$Server_OS[$i] = '<img src="Images/lunix.png" class="img-responsive" width="25px" height="25px" style="margin-top: 3px;">';
										else
											$Server_OS[$i] = '<img src="Images/windows.png" class="img-responsive" width="25px" height="25px" style="margin-top: 3px;">';
										
										$Server_VAC[$i] = '<img src="Images/check.png" class="img-responsive" width="25px" height="30px" style="margin-top: 2px;">';
										$Server_Location[$i] = '<img src="Images/us.png" class="img-responsive" width="30px" height="20px" style="margin-top: 6px;">';
									}
									else
									{
										$Server_Status[$i] = "Offline";
										$Server_Color[$i] = "red";
										$Server_Name[$i] = "Error: Connecting (".$ip[$i].":".$port[$i].") . . .";
										$Server_Map[$i] = "N/A";
										$Server_Players[$i] = "N";
										$Server_MaxPlayers[$i] = "A";
										$Server_Address[$i] = "N/A";
										$Server_Address[$i] = "N/A";
										$Server_OS[$i] = '<img src="Images/error.png" class="img-responsive" width="22px" height="22px" style="margin-top: 6px;">';
										$Server_VAC[$i] = '<img src="Images/error.png" class="img-responsive" width="22px" height="22px" style="margin-top: 6px;">';
										$Server_Location[$i] = '<img src="Images/error.png" class="img-responsive" width="22px" height="22px" style="margin-top: 6px;">';
									}
								}
									
									echo '
									<div class="servers_row">
										<div class="servers_col" style="width: 5%; background: #ECF0F0;">
											<img src="Images/csgo-icon.png" class="img-responsive" width="25px" height="25px" style="margin-top: 3px;">
										</div>
										<div class="servers_col" style="width: 5%; background: #ECF0F0;">
											'.$Server_Location[0].'
										</div>
										<div class="servers_col" style="width: 5%; background: #ECF0F0;">
											'.$Server_OS[0].'
										</div>
										<div class="servers_col" style="width: 5%; background: #ECF0F0;">
											'.$Server_VAC[0].'
										</div>
										<div class="servers_col" style="width: 7%; background: #ECF0F0; color: '.$Server_Color[0].';">
											<p><b>'.$Server_Status[0].'</b></p>
										</div>
										<div class="servers_col" style="width: 40%; text-align: left; background: #ECF0F0; padding-left: 1%;">
											<p>'.$Server_Name[0].'</p>
										</div>
										<div class="servers_col" style="width: 10%; background: #ECF0F0;">
											<p>'.$Server_Players[0].'/'.$Server_MaxPlayers[0].'</p>
										</div>
										<div class="servers_col" style="width: 10%; background: #ECF0F0;">
											<p>'.$Server_Map[0].'</p>
										</div>
										<div class="servers_col" style="width: 13%; background: #ECF0F0;">
											<p>'.$Server_Address[0].'</p>
										</div>
									</div>
									<div class="servers_row">
										<div class="servers_col" style="width: 5%; background: #ECF0F0;">
											<img src="Images/csgo-icon.png" class="img-responsive" width="25px" height="25px" style="margin-top: 3px;">
										</div>
										<div class="servers_col" style="width: 5%; background: #ECF0F0;">
											'.$Server_Location[1].'
										</div>
										<div class="servers_col" style="width: 5%; background: #ECF0F0;">
											'.$Server_OS[1].'
										</div>
										<div class="servers_col" style="width: 5%; background: #ECF0F0;">
											'.$Server_VAC[1].'
										</div>
										<div class="servers_col" style="width: 7%; background: #ECF0F0; color: '.$Server_Color[1].';">
											<p><b>'.$Server_Status[1].'</b></p>
										</div>
										<div class="servers_col" style="width: 40%; text-align: left; background: #ECF0F0; padding-left: 1%;">
											<p>'.$Server_Name[1].'</p>
										</div>
										<div class="servers_col" style="width: 10%; background: #ECF0F0;">
											<p>'.$Server_Players[1].'/'.$Server_MaxPlayers[1].'</p>
										</div>
										<div class="servers_col" style="width: 10%; background: #ECF0F0;">
											<p>'.$Server_Map[1].'</p>
										</div>
										<div class="servers_col" style="width: 13%; background: #ECF0F0;">
											<p>'.$Server_Address[1].'</p>
										</div>
									</div>
									<div class="servers_row">
										<div class="servers_col" style="width: 5%; background: #ECF0F0;">
											<img src="Images/csgo-icon.png" class="img-responsive" width="25px" height="25px" style="margin-top: 3px;">
										</div>
										<div class="servers_col" style="width: 5%; background: #ECF0F0;">
											'.$Server_Location[2].'
										</div>
										<div class="servers_col" style="width: 5%; background: #ECF0F0;">
											'.$Server_OS[2].'
										</div>
										<div class="servers_col" style="width: 5%; background: #ECF0F0;">
											'.$Server_VAC[2].'
										</div>
										<div class="servers_col" style="width: 7%; background: #ECF0F0; color: '.$Server_Color[2].';">
											<p><b>'.$Server_Status[2].'</b></p>
										</div>
										<div class="servers_col" style="width: 40%; text-align: left; background: #ECF0F0; padding-left: 1%;">
											<p>'.$Server_Name[2].'</p>
										</div>
										<div class="servers_col" style="width: 10%; background: #ECF0F0;">
											<p>'.$Server_Players[2].'/'.$Server_MaxPlayers[2].'</p>
										</div>
										<div class="servers_col" style="width: 10%; background: #ECF0F0;">
											<p>'.$Server_Map[2].'</p>
										</div>
										<div class="servers_col" style="width: 13%; background: #ECF0F0;">
											<p>'.$Server_Address[2].'</p>
										</div>
									</div>
									<div class="servers_row">
										<div class="servers_col" style="width: 5%; background: #ECF0F0;">
											<img src="Images/csgo-icon.png" class="img-responsive" width="25px" height="25px" style="margin-top: 3px;">
										</div>
										<div class="servers_col" style="width: 5%; background: #ECF0F0;">
											'.$Server_Location[3].'
										</div>
										<div class="servers_col" style="width: 5%; background: #ECF0F0;">
											'.$Server_OS[3].'
										</div>
										<div class="servers_col" style="width: 5%; background: #ECF0F0;">
											'.$Server_VAC[3].'
										</div>
										<div class="servers_col" style="width: 7%; background: #ECF0F0; color: '.$Server_Color[3].';">
											<p><b>'.$Server_Status[3].'</b></p>
										</div>
										<div class="servers_col" style="width: 40%; text-align: left; background: #ECF0F0; padding-left: 1%;">
											<p>'.$Server_Name[3].'</p>
										</div>
										<div class="servers_col" style="width: 10%; background: #ECF0F0;">
											<p>'.$Server_Players[3].'/'.$Server_MaxPlayers[3].'</p>
										</div>
										<div class="servers_col" style="width: 10%; background: #ECF0F0;">
											<p>'.$Server_Map[3].'</p>
										</div>
										<div class="servers_col" style="width: 13%; background: #ECF0F0;">
											<p>'.$Server_Address[3].'</p>
										</div>
									</div>
									<div class="servers_row">
										<div class="servers_col" style="width: 5%; background: #ECF0F0;">
											<img src="Images/csgo-icon.png" class="img-responsive" width="25px" height="25px" style="margin-top: 3px;">
										</div>
										<div class="servers_col" style="width: 5%; background: #ECF0F0;">
											'.$Server_Location[4].'
										</div>
										<div class="servers_col" style="width: 5%; background: #ECF0F0;">
											'.$Server_OS[4].'
										</div>
										<div class="servers_col" style="width: 5%; background: #ECF0F0;">
											'.$Server_VAC[4].'
										</div>
										<div class="servers_col" style="width: 7%; background: #ECF0F0; color: '.$Server_Color[4].';">
											<p><b>'.$Server_Status[4].'</b></p>
										</div>
										<div class="servers_col" style="width: 40%; text-align: left; background: #ECF0F0; padding-left: 1%;">
											<p>'.$Server_Name[4].'</p>
										</div>
										<div class="servers_col" style="width: 10%; background: #ECF0F0;">
											<p>'.$Server_Players[4].'/'.$Server_MaxPlayers[4].'</p>
										</div>
										<div class="servers_col" style="width: 10%; background: #ECF0F0;">
											<p>'.$Server_Map[4].'</p>
										</div>
										<div class="servers_col" style="width: 13%; background: #ECF0F0;">
											<p>'.$Server_Address[4].'</p>
										</div>
									</div>
									<div class="servers_row">
										<div class="servers_col" style="width: 5%; background: #ECF0F0;">
											<img src="Images/csgo-icon.png" class="img-responsive" width="25px" height="25px" style="margin-top: 3px;">
										</div>
										<div class="servers_col" style="width: 5%; background: #ECF0F0;">
											<img src="Images/us.png" class="img-responsive" width="30px" height="20px" style="margin-top: 6px;">
										</div>
										<div class="servers_col" style="width: 5%; background: #ECF0F0;">
											<img src="Images/lunix.png" class="img-responsive" width="25px" height="25px" style="margin-top: 3px;">
										</div>
										<div class="servers_col" style="width: 5%; background: #ECF0F0;">
											<img src="Images/check.png" class="img-responsive" width="25px" height="30px" style="margin-top: 2px;">
										</div>
										<div class="servers_col" style="width: 7%; background: #ECF0F0; color: goldenrod;">
											<p><b>N/A</b></p>
										</div>
										<div class="servers_col" style="width: 40%; text-align: left; background: #ECF0F0; padding-left: 1%;">
											<p>[ckL-Gaming] Retakes #1 [!ws !knife !gloves | 128Tick | Atlanta] <b>***Coming Soon!***</b></p>
										</div>
										<div class="servers_col" style="width: 10%; background: #ECF0F0;">
											<p>N/A</p>
										</div>
										<div class="servers_col" style="width: 10%; background: #ECF0F0;">
											<p>N/A</p>
										</div>
										<div class="servers_col" style="width: 13%; background: #ECF0F0;">
											<p>Coming Soon!</p>
										</div>
									</div>
									<div class="servers_row">
										<div class="servers_col" style="width: 5%; background: #ECF0F0;">
											<img src="Images/csgo-icon.png" class="img-responsive" width="25px" height="25px" style="margin-top: 3px;">
										</div>
										<div class="servers_col" style="width: 5%; background: #ECF0F0;">
											<img src="Images/us.png" class="img-responsive" width="30px" height="20px" style="margin-top: 6px;">
										</div>
										<div class="servers_col" style="width: 5%; background: #ECF0F0;">
											<img src="Images/lunix.png" class="img-responsive" width="25px" height="25px" style="margin-top: 3px;">
										</div>
										<div class="servers_col" style="width: 5%; background: #ECF0F0;">
											<img src="Images/check.png" class="img-responsive" width="25px" height="30px" style="margin-top: 2px;">
										</div>
										<div class="servers_col" style="width: 7%; background: #ECF0F0; color: goldenrod;">
											<p><b>N/A</b></p>
										</div>
										<div class="servers_col" style="width: 40%; text-align: left; background: #ECF0F0; padding-left: 1%;">
											<p>[ckL-Gaming] FFA DM #1 [!ws !knife !gloves | 128Tick | Atlanta] <b>***Coming Soon!***</b></p>
										</div>
										<div class="servers_col" style="width: 10%; background: #ECF0F0;">
											<p>N/A</p>
										</div>
										<div class="servers_col" style="width: 10%; background: #ECF0F0;">
											<p>N/A</p>
										</div>
										<div class="servers_col" style="width: 13%; background: #ECF0F0;">
											<p>Coming Soon!</p>
										</div>
									</div>
									<div class="servers_row">
										<div class="servers_col" style="width: 5%; background: #ECF0F0;">
											<img src="Images/minecraft.png" class="img-responsive" width="25px" height="25px" style="margin-top: 3px;">
										</div>
										<div class="servers_col" style="width: 5%; background: #ECF0F0;">
											<img src="Images/us.png" class="img-responsive" width="30px" height="20px" style="margin-top: 6px;">
										</div>
										<div class="servers_col" style="width: 5%; background: #ECF0F0;">
											<img src="Images/lunix.png" class="img-responsive" width="25px" height="25px" style="margin-top: 3px;">
										</div>
										<div class="servers_col" style="width: 5%; background: #ECF0F0;">
											<img src="Images/check.png" class="img-responsive" width="25px" height="30px" style="margin-top: 2px;">
										</div>
										<div class="servers_col" style="width: 7%; background: #ECF0F0; color: #26b526;">
											<p><b>Online</b></p>
										</div>
										<div class="servers_col" style="width: 40%; text-align: left; background: #ECF0F0; padding-left: 1%;">
											<p>[ckL-Gaming] Minecraft Survival #1 [No Rules | Chicago]</p>
										</div>
										<div class="servers_col" style="width: 10%; background: #ECF0F0;">
											<p>0/0</p>
										</div>
										<div class="servers_col" style="width: 10%; background: #ECF0F0;">
											<p>Vanilla</p>
										</div>
										<div class="servers_col" style="width: 13%; background: #ECF0F0;">
											<p>74.91.124.5:25565</p>
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