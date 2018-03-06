<?php
require_once __DIR__ . '/vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use \Firebase\JWT\JWT;

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
	print_r($decoded);
	if($decoded->{"id"} == $input_id)
	{
		return true;
	}
}

function validate($n)
{
	$userData = explode(' ', $n);
	if($userData[0]=="user" && $userData[1]=="pass")
	{
		echo " login OK\n";
		$token = genJWT($userData);
		if(validJWT($token, $userData[0]))
		{
			return $token;
		}
	}
	else
	{
		echo " login failed\n";
	}
}

echo " [x] Awaiting RPC requests \n"; 

$callback = function($req) {
	echo " validating on server side \n ";
	$r = validate($req->body);
	echo $r;
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
