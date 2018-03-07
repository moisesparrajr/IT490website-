<?php

require_once __DIR__ . '/vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use \Firebase\JWT\JWT;
include 'connect.php';

$connection = new AMQPStreamConnection('localhost', 5672, 'guest', 'guest');
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
		$loginQ = "SELECT * FROM Users WHERE email='$userData[0]' AND password='$userData[1]'";
		$result = $link->query($loginQ);
		if($result->num_rows > 0)
		{
			echo " Login OK\n";
			$token = genJWT($userData);
			if(validJWT($token, $userData[0]))
			{
				return $token;
			}
		}
		else
		{
			echo " Login failed\n";
		}
	}
	if(count($userData) == 3)
	{
		echo " Attempting signup\n";
		$signupQuser = "SELECT * FROM Users WHERE email='$userData[0]'";
                $resultUser = $link->query($signupQuser);
		$signupQtwitch = "SELECT * FROM Users WHERE twitchID='$userData[2]'";
                $resultTwitch = $link->query($signupQtwitch);
		
		if($resultUser->num_rows > 0 || $resultTwitch->num_rows > 0)
		{
			echo " Signup failed\n";
		}
                else
                {
                        echo " Signup OK\n";
			
			$insertQ = "INSERT INTO Users (email, password, twitchID) VALUES ('$userData[0]', '$userData[1]', '$userData[2]')";
			if($link->query($insertQ) === TRUE)
			{
				echo " Insert OK\n";
			}
			else
			{
				echo " Insert failed: " . $insertQ . "<br>" . $link->error;
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
