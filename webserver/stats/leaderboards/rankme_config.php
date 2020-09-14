<?php
$site_name = "ckL-Gaming 10Man Stats"; // Name of Site
$page_title = "ckL-Gaming - 10Man Stats"; // Page title in browser.
$logo = "assets/img/sea8.png";
$limit = 15; // Page Limit for players in leaderboards.

$servername = "ckl-gaming.com"; // Server IP
$username = "vdsserver"; // DB Username
$password = "bPgmmZP8qr"; // DB Password
$dbname = "vdsserver_ckl_10man_rankme"; // DB Name
$dbname2 = "vdsserver_ckl_5v5_rankme"; // DB Name

$dbtable = "rankme";

$weaponsArray = array("m4a1_silencer","m4a1","ak47","awp","knife","usp_silencer","hkp2000","elite","p250","fiveseven","cz75a","deagle","glock","tec9","famas","aug","galilar","sg556","hegrenade","flashbang","smokegrenade","inferno","revolver","nova","xm1014","mag7","sawedoff","bizon","mac10","mp9","mp7","ump45","p90","scar20","ssg08","g3sg1","m249","negev","decoy","taser");

$maps = array(
    // "Path/To/Image" => "full_map_name",
    "scoreboards/maps/austria.jpg" => "de_austria",
    "scoreboards/maps/cache.jpg" => "de_cache",
    "scoreboards/maps/cache_new.jpg" => "workshop/1855851320/de_cache_new",
    "scoreboards/maps/cache_new.jpg" => "workshop/1855851320/de_cache",
    "scoreboards/maps/canals.jpg" => "de_canals",
    "scoreboards/maps/cbble.jpg" => "de_cbble",
    "scoreboards/maps/dust.png" => "de_dust",
    "scoreboards/maps/dust2.jpg" => "de_dust2",
    "scoreboards/maps/mirage.jpg" => "de_mirage",
    "scoreboards/maps/nuke.jpg" => "de_nuke",
    "scoreboards/maps/overpass.jpg" => "de_overpass",
    "scoreboards/maps/train.jpg" => "de_train",
    "scoreboards/maps/inferno.jpg" => "de_inferno",
	"scoreboards/maps/vertigo.jpg" => "de_vertigo"
);

$connect = new mysqli($servername, $username, $password, $dbname);
if ($connect->connect_error) {
    die("Connection failed: " . $connect->connect_error);
}

$connect2 = new mysqli($servername, $username, $password, $dbname2);
if ($connect2->connect_error) {
    die("Connection failed: " . $connect2->connect_error);
}
?>
