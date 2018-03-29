<?php
include 'connect.php';

if($_POST)
{
	$link = connectDB();
	
	$userID = $_POST["Streamer];
	$sql = "SELECT * FROM Twitch_Data WHERE UserID=" . $userID . " FOR JSON AUTO;";
        $result = $link->query($sql);
	
	return $result;
}

?>
