<?php
$site_name = "ckL-Gaming 10Man Stats"; // Name of Site
$page_title = "ckL-Gaming - 10Man Stats"; // Page title in browser.
$logo = "assets/img/sea8.png";
$limit = 15; // Page Limit for match cards.

$servername = "ckl-gaming.com"; // Server IP
$username = "vdsserver"; // DB Username
$password = "bPgmmZP8qr"; // DB Password
$dbname = "vdsserver_ckl_10man_stats"; // DB Name
$dbname2 = "vdsserver_ckl_5v5_stats";

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

$conn = new mysqli($servername, $username, $password, $dbname);
$conn2 = new mysqli($servername, $username, $password, $dbname2);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
if ($conn2->connect_error) {
    die("Connection failed: " . $conn2->connect_error);
}
?>
