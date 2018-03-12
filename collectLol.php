<?php

include 'connectAPI.php';

updateLolData();

function updateLolData()
{
	$link = connectDB();

	$sql = "SELECT personalID, summonerName FROM Users WHERE accountID IS NULL OR lastActivity < NOW() - INTERVAL 1 HOUR";
	$result = $link->query($sql);
	
	echo " Num rows " . $result->num_rows . "\n";

	if(!$result){
		trigger_error('SQL Error: ' . $link->error);
	}
	
	if($result->num_rows > 0)
	{
		while($row = $result->fetch_assoc())
		{
        		echo " personalID " . $row["personalID"] . " summonerName " . $row["summonerName"] . "\n";
                	$summonerData = getSummonerByName($row["summonerName"]);
			if($summonerData != null)
			{
				$insertIDS = "UPDATE Users SET accountID=".$summonerData->{"accountId"}.", summonerID=".$summonerData->{"id"}." WHERE personalID=".$row["personalID"].";";
				//echo $insertIDS;
				$insertIDS_Result = $link->query($insertIDS);
				if(!$insertIDS_Result){
					trigger_error('Insert IDs Error: ' . $link->error);
				}
				
				$data = getSummonerData($summonerData->{"id"});
				$lolLink = connectLol();
				
				if(count($data) == 0) //if result is empty object
				{
					echo " No data, INSERT UPDATE rank, lvl, accountID\n";
					$insertLolEmpty = "INSERT LoL_Data (rank, summonerLvl, accountId) VALUES (0, " . $summonerData->{"summonerLevel"} . ", " . $summonerData->{"accountId"} .") ON DUPLICATE KEY UPDATE rank=0, summonerLvl=" . $summonerData->{"summonerLevel"} . ";"; 
					//echo $insertLolEmpty;
					$insertLolEmpty_result = $lolLink->query($insertLolEmpty);
					if(!$insertLolEmpty_result){
                                  		trigger_error("Insert empty to LOL Error: " . $lolLink->error);
                                	}
				}
				else
				{
					//echo "size " . count($data);
					echo " INSERT UPDATE to LoL_Data\n";
//					$insertLol = "INSERT INTO LoL_Data (rank, wins, losses, veteran, inactive, playerOrTeamName, playerOrTeamID, leaguePoints, summonerLvl, accountID) VALUES (".$data[0]->{"rank"}.", ".$data[0]->{"wins"}.", ".$data[0]->{"losses"}.", 0, 0, ".$data[0]->{"playerOrTeamName"}.", ".$data[0]->{"playerOrTeamId"}.", ".$data[0]->{"leaguePoints"}.", ".$summonerData->{"summonerLevel"}.", ".$summonerData->{"accountId"}.") ON DUPLICATE KEY UPDATE rank='".$data[0]->{"rank"}."', wins='".$data[0]->{"wins"}."', losses='".$data[0]->{"losses"}."', playerOrTeamName='".$data[0]->{"playerOrTeamName"}."', playerOrTeamId='".$data[0]->{"playerOrTeamId"}."', leaguePoints='".$data[0]->{"leaguePoints"}."', summonerLvl='".$summonerData->{"summonerLevel"}."';";

					$insertLol = "REPLACE INTO LoL_Data (rank, wins, losses, veteran, inactive, playerOrTeamName, playerOrTeamID, leaguePoints, summonerLvl, accountID) VALUES ('".$data[0]->{"rank"}."', ".$data[0]->{"wins"}.", ".$data[0]->{"losses"}.", 0, 0,'".$data[0]->{"playerOrTeamName"}."', ".$data[0]->{"playerOrTeamId"}.", ".$data[0]->{"leaguePoints"}.", ".$summonerData->{"summonerLevel"}.", ".$summonerData->{"accountId"}.");";

					echo $insertLol;
					$insertLol_result = $lolLink->query($insertLol);
					if(!$insertLol_result){
						trigger_error("Insert to LOL Error: " . $lolLink->error);
					}
				}
			}
        	}
	}
	else
	{
        	echo "0 results\n";
	}
}

function getSummonerByName($name)
{
	//hit API start
	$curl = curl_init();
	$key_ini = parse_ini_file("apikey.ini");
	$url = sprintf("https://na1.api.riotgames.com/lol/summoner/v3/summoners/by-name/%s?api_key=%s", $name, $key_ini["key"]);
	
	//optional authentication:
	//curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
	//curl_setopt($curl, CURL_USERAGENT);
	curl_setopt($curl, CURLOPT_URL, $url);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	$result_string = curl_exec($curl);
	$status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        echo " status " . $status . "\n";
	curl_close($curl);
	$results = json_decode($result_string);
	//var_dump($results);
	//hit API stop
	if(!property_exists($results, "accountId") && !property_exists($results, "id"))
		echo " failure\n";
	else
		return $results;
	return null;
}

function getSummonerData($id)
{
	echo " input id " . $id . "\n";
	//hit API start
	$curl = curl_init();
	$key_ini = parse_ini_file("apikey.ini");
	$url = sprintf("https://na1.api.riotgames.com/lol/league/v3/positions/by-summoner/%s?api_key=%s", $id, $key_ini["key"]);
	
	//optional authentication:
	//curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
	//curl_setopt($curl, CURL_USERAGENT);
	curl_setopt($curl, CURLOPT_URL, $url);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

	$result_string = curl_exec($curl);
	$status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
	echo "status " . $status . "\n";
	if(curl_error($curl))
	{
		echo " error " . curl_error($curl);
		return null;
	}
	curl_close($curl);
	$results = json_decode($result_string);
	var_dump($results);
	return $results;
}

//query bs
//QUERY: select personalID, summonerName from Users where summonerID=NULL OR lastActivty < NOW() - INTERVAL 1 HOUR;

//$updateList =json_decode($query);

//for each enrty within query up to rate limiter, query for fresh data

///lol/summoner/v3/summoner/{summonerAccount}
///lol/match/v3/matchlists/by_account/{summonerID}
//} 
?>
