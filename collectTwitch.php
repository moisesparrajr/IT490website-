#!/usr/bin/php
<?php

include 'connect.php';

updateTwitchData();

function updateTwitchData()
{
	$link = connectDB();

	$sql = "SELECT twitchID FROM Users";
	$result = $link->query($sql);
	
	echo " Num rows " . $result->num_rows . "\n";

	if(!$result){
		trigger_error('SQL Error: ' . $link->error);
	}
	
	if($result->num_rows > 0)
	{
		while($row = $result->fetch_assoc())
		{
			$twitchID = $row["twitchID"];
			if($twitchID !== NULL)
			$stream = getStream($twitchID);

			if($stream) //
			{
				var_dump($stream);
				//$twitchQuery = "INSERT INTO Twitch_Data (userID, thumbnailURL) VALUES (" . $twitchID . ", " . $stream[ 
                       		//echo $twitchQuery . "\n";
				//$insert_result = $link->query($twitchQuery);
			}
//                        if(!$insert_result){
  //                                   trigger_error('Insert Error: ' . $link->error);
    //                    }

        	}
	}
	else
	{
        	echo "0 results\n";
	}
}

function getStream($id)
{
	//hit API start
	$curl = curl_init();
	$key_ini = parse_ini_file("apikey.ini");
	
	$streams = 'https://api.twitch.tv/kraken/streams/';
	$channelId = $id;
	$clientId = $key_ini["twitchClient"];

	//optional authentication:
	//curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
	//curl_setopt($curl, CURL_USERAGENT);

	 curl_setopt_array($curl, array(
        CURLOPT_HTTPHEADER => array(
        'Client-ID: ' . $clientId
         ),
         CURLOPT_RETURNTRANSFER => true,
         CURLOPT_URL => $streams . $channelId
         ));

        $response = curl_exec($curl);

  	$status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        echo " status " . $status . "\n";
	curl_close($curl);
	$results = json_decode($response);
	return $results;
}

?>
