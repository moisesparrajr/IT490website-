<?php

include 'connect.php';

if($_POST["action"] == "twitch")
{
	$link = connectDB();
	$response = "";

	$sql = "SELECT thumbnailURL FROM Users";
	$result = $link->query($sql);
        
	if($result->num_rows > 0)
	{
		while($row = $result->fetch_assoc()){
			echo "twitchID " . $row["thumbnailURL"] . "\n";
		}
	}
	else 
	{
        	echo "0 results\n";
	}

	$response = trim($response);
	echo $response;
}

?>
