<?php

require_once __DIR__ . '/vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use \Firebase\JWT\JWT;
include 'connect.php';
include 'db_producer.php';

$ip_info = parse_ini_file("rpcIP.ini");
$ip_addr = $ip_info["rpc_ip"];
$connection = new AMQPStreamConnection($ip_addr, 5672, $ip_info["user"], $ip_info["password"]);
$channel = $connection->channel();
$channel->queue_declare('rpc_queue', false, false, false, false);

function genJWT($userDataArr)
{
	$cache = parse_ini_file("key.ini");
	$key = $cache['key'];
	$payload = array(
		"id" => $userDataArr[0],
		"exp" => time() + (60 * 60)
		);

	return JWT::encode($payload, $key);
}

function validJWT($input_token, $input_id)
{
        $key = "secretKey";
        $decoded = JWT::decode($input_token, $key, array('HS256'));
	if($decoded->{"id"} == $input_id)
	{
		return true;
	}
}

function validate($n)
{
	$link = connectDB();
	$userData = explode(' ', $n);
	if(count($userData) == 2)
	{
		echo " Attempting login\n";
		$loginQ = "SELECT * FROM Users WHERE email='$userData[0]';";

		$result = send_query($loginQ);
		$resultObj = json_decode($result, true);
		print_r($resultObj);
		var_dump($result);
		var_dump($resultObj);
		if($resultObj > 0) 
		{
			if(password_verify($userData[1], $resultObj[0]["password"]))
			{
				echo " Login OK\n";
				$token = genJWT($userData);
				if(validJWT($token, $userData[0]))
				{
					return $token;
				}
			}else{
				echo "Login failed1\n";
			}
		}
		else
		{
			echo " Login failed2\n";
		}
	}
	if(count($userData) == 3)
	{
		echo " Attempting signup\n";
		$signupQuser = "SELECT * FROM Users WHERE email='$userData[0]'";
                //$resultUser = $link->query($signupQuser);
		$resultUser = send_query($signupQuser);
                $resultObjU = json_decode($resultUser, true);
                //print_r($resultObjU);

		$signupQtwitch = "SELECT * FROM Users WHERE twitchID='$userData[2]'";
                //$resultTwitch = $link->query($signupQtwitch);
		$resultTwitch = send_query($signupQtwitch);
		$resultObjT = json_decode($resultTwitch, true);
		//print_r($resultObjT);
		
		//if($resultUser->num_rows > 0 || $resultTwitch->num_rows > 0)
		if(count($resultObjU) > 1 || count($resultObjT) > 1) 
		{
			echo " Signup failed\n";
		}
                else
                {
                        echo " Signup OK\n";
			
			$insertQ = "INSERT INTO Users (email, password, twitchID) VALUES ('$userData[0]', '".password_hash($userData[1], PASSWORD_DEFAULT)."', '$userData[2]')";
			//if($link->query($insertQ) === TRUE)
			$insertResult = send_query($insertQ);
			$insertResultObj = json_decode($insertResult, true);
			//print_r($insertResultObj);

			if($insertResultObj[0] == 1)
			{
				echo " Insert OK\n";
			}
			else
			{
				echo " Insert failed: " . $insertQ . "\n"; 
				return;
			}

                        $token = genJWT($userData);
                        if(validJWT($token, $userData[0]))
                        {
                                return $token;
                        }
                }

	}
}

echo " [x] Awaiting RPC requests\n"; 

$callback = function($req) {
	echo " Processing on server side\n";
	$r = validate($req->body);
	$msg = new AMQPMessage(
		(string) $r,
		array('correlation_id' => $req->get('correlation_id'))
		);
	$req->delivery_info['channel']->basic_publish(
		$msg, '', $req->get('reply_to'));
	$req->delivery_info['channel']->basic_ack(
		$req->delivery_info['delivery_tag']);
};

$channel->basic_qos(null, 1, null);
$channel->basic_consume('rpc_queue', '', false, false, false, false, $callback);
while(count($channel->callbacks)) {
    $channel->wait();
}
$channel->close();
$connection->close();
?>
