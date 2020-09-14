<?php
    require ('steamauth/steamauth.php');
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
	<link href="css/style_leaderboards.css" rel="stylesheet" type="text/css">
	
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
							<a href="scoreboards.php?id=10mans" ><img src="Images/csgo-icon.png" class="center" width="30px" height="30px" style="vertical-align: middle;"> Scoreboards</a>
							<a href="leaderboards.php?id=10mans" class="active"><img src="Images/csgo-icon.png" class="center" width="30px" height="30px" style="vertical-align: middle;"> <b>Leaderboards</b></a>
							<a href="https://bans.ckl-gaming.com/" ><img src="Images/csgo-icon-x.png" class="center" width="30px" height="30px" style="vertical-align: middle;"> Sourcebans</a>
							<a href="stats_coming_soon.php" ><img src="Images/minecraft.png" class="center" width="30px" height="30px" style="vertical-align: middle;"> World-Map</a>
							<a href="stats_coming_soon.php" ><img src="Images/minecraft-x.png" class="center" width="30px" height="30px" style="vertical-align: middle;"> Bans</a>
						</div>
						<div class="stats_navbar_col" style="width: 80%; background: #ECF0F0; padding-left: 2%; padding-right: 2%;">
							<div class="title-navbar">
								<p>ckL-Gaming.com<br>Stats - Leaderboards</p>
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
								
								<form method="post">
									<div class="search-container" style="width:100%;">
										<input type="text" name="search-bar" placeholder="Search PlayerName, or SteamID" class="search-input">
										<button class="search-btn" type="submit" name="Submit"> <i class="fa fa-search"></i></button>
									</div>
								</form>
								
								<div class="servers_row">
									<div class="servers_col" style="width: 6%; background: white;">
										<p style="color: black; text-align: center;">Rank</p>
									</div>
									<div class="servers_col" style="width: 20%; background: white;">
										<p style="color: black; text-align: center;">Name</p>
									</div>
									<div class="servers_col" style="width: 15%; background: white;">
										<p style="color: black; text-align: center;">Steam-ID</p>
									</div>
									<div class="servers_col" style="width: 11%; background: white;">
										<p style="color: black; text-align: center;">Kills</p>
									</div>
									<div class="servers_col" style="width: 11%; background: white;">
										<p style="color: black; text-align: center;">Deaths</p>
									</div>
									<div class="servers_col" style="width: 11%; background: white;">
										<p style="color: black; text-align: center;">K/D</p>
									</div>
									<div class="servers_col" style="width: 11%; background: white;">
										<p style="color: black; text-align: center;">Score</p>
									</div>
									<div class="servers_col" style="width: 15%; background: white;">
										<p style="color: black; text-align: center;">Profile</p>
									</div>
								</div>
								<?php
									if (isset($_POST['Submit']) && !empty($_POST['search-bar'])) 
									{
										$search = $connect->real_escape_string($_POST['search-bar']);
										$sql = "SELECT DISTINCT * FROM rankme
												WHERE rankme.name LIKE '%".$search."%' OR rankme.steam = '".$search."' ORDER BY rankme.score DESC";
										
										$rank = "N/A";
									} 
									else 
									{
										if (isset($_GET["page"])) 
										{
											$page_number = $connect->real_escape_string($_GET["page"]);
											$offset = ($page_number - 1) * $limit; 
											$sql = "SELECT * FROM rankme ORDER BY score DESC LIMIT $offset, $limit";
										} 
										else 
										{
											$page_number = 1;
											$sql = "SELECT * FROM rankme ORDER BY score DESC LIMIT $limit";
										}  
										$rank = "N/A";
									}
									
									$result = $connect->query($sql);

									if($result->num_rows > 0) 
									{
										while($row = $result->fetch_assoc()) 
										{
											echo '
												<div class="servers_row">
													<div class="servers_col" style="width: 6%; background: #ECF0F0;">
														<p style="color: black; text-align: center;">'.$rank.'</p>
													</div>
														<div class="servers_col" style="width: 20%; background: #ECF0F0;">
														<p style="color: black; text-align: left; padding-left: 10px;">'.$row['name'].'</p>
													</div>
													<div class="servers_col" style="width: 15%; background: #ECF0F0;">
														<p style="color: black; text-align: left; padding-left: 10px;">'.$row['steam'].'</p>
													</div>
													<div class="servers_col" style="width: 11%; background: #ECF0F0;">
														<p style="color: black; text-align: center;">'.$row['kills'].'</p>
													</div>
													<div class="servers_col" style="width: 11%; background: #ECF0F0;">
														<p style="color: black; text-align: center;">'.$row['deaths'].'</p>
													</div>
													<div class="servers_col" style="width: 11%; background: #ECF0F0;">
														<p style="color: black; text-align: center;">'.round($row['kills']/$row['deaths'], 2).'</p>
													</div>
													<div class="servers_col" style="width: 11%; background: #ECF0F0;">
														<p style="color: black; text-align: center;">'.$row['score'].'</p>
													</div>
													<div class="servers_col" style="width: 15%; background: #ECF0F0;">
														<a href="profile.php?user='.$row['steam'].'&id=10mans" style="word-spacing: 3px; color: blue; padding: 10px;">View Profile</a>
													</div>
												</div>
											';
										}
									}
									else 
									{
										echo '<h1 style="margin-top:20px;text-align:center;">No Results!</h1>';
									}
								?>
								
								<?php
										if (!isset($_POST['Submit'])) 
										{
											$sql_pages = "SELECT COUNT(*) FROM rankme";
											$result_pages = $connect->query($sql_pages);
											$row_pages = $result_pages->fetch_assoc();

											$total_pages = ceil($row_pages["COUNT(*)"] / $limit);
											
											echo '<div class="test" style="margin-top:10px; margin-left: 2%; width:100%;">';
											
											if ($page_number == 1) 
											{
												 echo '
													<a class="page-item disabled" style="width: 80px;">Previous</a>';
											}
											else 
											{
												$past_page = $page_number - 1;
												echo '<a class="page-item" style="width: 80px;" href="?id=10mans&page='.$past_page.'">Previous</a>';
											}
											for ($i = max(1, $page_number - 2); $i <= min($page_number + 4, $total_pages); $i++) 
											{
												if ($i == $page_number) 
												{
													 echo '<a class="page-item active" style="">'.$i.'</a>';
												} 
												else 
												{
													echo '<a class="page-item" style="" href="?id=10mans&page='.$i.'">'.$i.'</a>';
												}
											}
											 if ($page_number == $total_pages) 
											 {
												 echo '<a class="page-item disabled" style="width: 80px;">Next</a>';
											 }
											 else
											 {
												 $next_page = $page_number + 1;
												 echo '<a class="page-item" style="width: 80px;" href="?id=10mans&page='.$next_page.'">Next</a>';
											 }
											 echo '
											</div>';
										}
										elseif (isset($_POST['Submit']) && empty($_POST['search-bar']))
										{
											$sql_pages = "SELECT COUNT(*) FROM rankme";
											$result_pages = $connect->query($sql_pages);
											$row_pages = $result_pages->fetch_assoc();

											$total_pages = ceil($row_pages["COUNT(*)"] / $limit);
											
											echo '<div class="test" style="margin-top:10px; margin-left: 2%; width:100%;">';
											
											if ($page_number == 1) 
											{
												 echo '
													<a class="page-item disabled" style="width: 80px;">Previous</a>';
											}
											else 
											{
												$past_page = $page_number - 1;
												echo '<a class="page-item" style="width: 80px;" href="?id=10mans&page='.$past_page.'">Previous</a>';
											}
											for ($i = max(1, $page_number - 2); $i <= min($page_number + 4, $total_pages); $i++) 
											{
												if ($i == $page_number) 
												{
													 echo '<a class="page-item active" style="">'.$i.'</a>';
												} 
												else 
												{
													echo '<a class="page-item" style="" href="?id=10mans&page='.$i.'">'.$i.'</a>';
												}
											}
											 if ($page_number == $total_pages) 
											 {
												 echo '<a class="page-item disabled" style="width: 80px;">Next</a>';
											 }
											 else
											 {
												 $next_page = $page_number + 1;
												 echo '<a class="page-item" style="width: 80px;" href="?id=10mans&page='.$next_page.'">Next</a>';
											 }
											 echo '
											</div>';
										}
									?>
									<?php
								}
								else if($selected_type == "5v5s")
								{
									?>
									<form method="post">
									<div class="search-container" style="width:100%;">
										<input type="text" name="search-bar" placeholder="Search PlayerName, or SteamID" class="search-input">
										<button class="search-btn" type="submit" name="Submit"> <i class="fa fa-search"></i></button>
									</div>
								</form>
								
								<div class="servers_row">
									<div class="servers_col" style="width: 6%; background: white;">
										<p style="color: black; text-align: center;">Rank</p>
									</div>
									<div class="servers_col" style="width: 20%; background: white;">
										<p style="color: black; text-align: center;">Name</p>
									</div>
									<div class="servers_col" style="width: 15%; background: white;">
										<p style="color: black; text-align: center;">Steam-ID</p>
									</div>
									<div class="servers_col" style="width: 11%; background: white;">
										<p style="color: black; text-align: center;">Kills</p>
									</div>
									<div class="servers_col" style="width: 11%; background: white;">
										<p style="color: black; text-align: center;">Deaths</p>
									</div>
									<div class="servers_col" style="width: 11%; background: white;">
										<p style="color: black; text-align: center;">K/D</p>
									</div>
									<div class="servers_col" style="width: 11%; background: white;">
										<p style="color: black; text-align: center;">Score</p>
									</div>
									<div class="servers_col" style="width: 15%; background: white;">
										<p style="color: black; text-align: center;">Profile</p>
									</div>
								</div>
								<?php
									if (isset($_POST['Submit']) && !empty($_POST['search-bar'])) 
									{
										$search = $connect2->real_escape_string($_POST['search-bar']);
										$sql = "SELECT DISTINCT * FROM rankme
												WHERE rankme.name LIKE '%".$search."%' OR rankme.steam = '".$search."' ORDER BY rankme.score DESC";
										
										$rank = "N/A";
									} 
									else 
									{
										if (isset($_GET["page"])) 
										{
											$page_number = $connect2->real_escape_string($_GET["page"]);
											$offset = ($page_number - 1) * $limit; 
											$sql = "SELECT * FROM rankme ORDER BY score DESC LIMIT $offset, $limit";
										} 
										else 
										{
											$page_number = 1;
											$sql = "SELECT * FROM rankme ORDER BY score DESC LIMIT $limit";
										}  
										$rank = "N/A";
									}
									
									$result = $connect2->query($sql);

									if($result->num_rows > 0) 
									{
										while($row = $result->fetch_assoc()) 
										{
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
										
											echo '
												<div class="servers_row">
													<div class="servers_col" style="width: 6%; background: #ECF0F0;">
														<p style="color: black; text-align: center;">'.$rank.'</p>
													</div>
														<div class="servers_col" style="width: 20%; background: #ECF0F0;">
														<p style="color: black; text-align: left; padding-left: 10px;">'.$row['name'].'</p>
													</div>
													<div class="servers_col" style="width: 15%; background: #ECF0F0;">
														<p style="color: black; text-align: left; padding-left: 10px;">'.$row['steam'].'</p>
													</div>
													<div class="servers_col" style="width: 11%; background: #ECF0F0;">
														<p style="color: black; text-align: center;">'.$row['kills'].'</p>
													</div>
													<div class="servers_col" style="width: 11%; background: #ECF0F0;">
														<p style="color: black; text-align: center;">'.$row['deaths'].'</p>
													</div>
													<div class="servers_col" style="width: 11%; background: #ECF0F0;">
														<p style="color: black; text-align: center;">'.$kdr.'</p>
													</div>
													<div class="servers_col" style="width: 11%; background: #ECF0F0;">
														<p style="color: black; text-align: center;">'.$row['score'].'</p>
													</div>
													<div class="servers_col" style="width: 15%; background: #ECF0F0;">
														<a href="profile.php?user='.$row['steam'].'&id=5v5s" style="word-spacing: 3px; color: blue; padding: 10px;">View Profile</a>
													</div>
												</div>
											';
										}
									}
									else 
									{
										echo '<h1 style="margin-top:20px;text-align:center;">No Results!</h1>';
									}
								?>
								
								<?php
										if (!isset($_POST['Submit'])) 
										{
											$sql_pages = "SELECT COUNT(*) FROM rankme";
											$result_pages = $connect2->query($sql_pages);
											$row_pages = $result_pages->fetch_assoc();

											$total_pages = ceil($row_pages["COUNT(*)"] / $limit);
											
											echo '<div class="test" style="margin-top:10px; margin-left: 2%; width:100%;">';
											
											if ($page_number == 1) 
											{
												 echo '
													<a class="page-item disabled" style="width: 80px;">Previous</a>';
											}
											else 
											{
												$past_page = $page_number - 1;
												echo '<a class="page-item" style="width: 80px;" href="?id=5v5s&page='.$past_page.'">Previous</a>';
											}
											for ($i = max(1, $page_number - 2); $i <= min($page_number + 4, $total_pages); $i++) 
											{
												if ($i == $page_number) 
												{
													 echo '<a class="page-item active" style="">'.$i.'</a>';
												} 
												else 
												{
													echo '<a class="page-item" style="" href="?id=5v5s&page='.$i.'">'.$i.'</a>';
												}
											}
											 if ($page_number == $total_pages) 
											 {
												 echo '<a class="page-item disabled" style="width: 80px;">Next</a>';
											 }
											 else
											 {
												 $next_page = $page_number + 1;
												 echo '<a class="page-item" style="width: 80px;" href="?id=5v5s&page='.$next_page.'">Next</a>';
											 }
											 echo '
											</div>';
										}
										elseif (isset($_POST['Submit']) && empty($_POST['search-bar']))
										{
											$sql_pages = "SELECT COUNT(*) FROM rankme";
											$result_pages = $connect2->query($sql_pages);
											$row_pages = $result_pages->fetch_assoc();

											$total_pages = ceil($row_pages["COUNT(*)"] / $limit);
											
											echo '<div class="test" style="margin-top:10px; margin-left: 2%; width:100%;">';
											
											if ($page_number == 1) 
											{
												 echo '
													<a class="page-item disabled" style="width: 80px;">Previous</a>';
											}
											else 
											{
												$past_page = $page_number - 1;
												echo '<a class="page-item" style="width: 80px;" href="?id=5v5s&page='.$past_page.'">Previous</a>';
											}
											for ($i = max(1, $page_number - 2); $i <= min($page_number + 4, $total_pages); $i++) 
											{
												if ($i == $page_number) 
												{
													 echo '<a class="page-item active" style="">'.$i.'</a>';
												} 
												else 
												{
													echo '<a class="page-item" style="" href="?id=5v5s&page='.$i.'">'.$i.'</a>';
												}
											}
											 if ($page_number == $total_pages) 
											 {
												 echo '<a class="page-item disabled" style="width: 80px;">Next</a>';
											 }
											 else
											 {
												 $next_page = $page_number + 1;
												 echo '<a class="page-item" style="width: 80px;" href="?id=5v5s&page='.$next_page.'">Next</a>';
											 }
											 echo '
											</div>';
										}
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