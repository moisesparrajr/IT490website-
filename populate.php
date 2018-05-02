<?php

include 'connect.php';

if($_POST["action"] == "twitch")
{
	$link = connectDB();
	$response = "";

<<<<<<< HEAD
	$sql = "SELECT twitchID FROM Users";
=======
	$sql = "SELECT thumbnailURL FROM Users";
>>>>>>> bf5d35123f7b946dbe61ff7c23b8b7e7d0115513
	$result = $link->query($sql);
        
	if($result->num_rows > 0)
	{
		while($row = $result->fetch_assoc()){
<<<<<<< HEAD
			echo "twitch " . $row["twitchID"] . "\n";
			$response = $response . $row["twitchID"] . " ";
=======
			echo "twitchID " . $row["thumbnailURL"] . "\n";
>>>>>>> bf5d35123f7b946dbe61ff7c23b8b7e7d0115513
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
