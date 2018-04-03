<?php

require_once __DIR__ . '/vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use \Firebase\JWT\JWT;
include 'connect.php';

$ip_info = parse_ini_file("rpcIP.ini");

$connection = new AMQPStreamConnection($ip_info["rpc_ip"], 5672, $ip_info["user"], $ip_info["password"]);
$channel = $connection->channel();
$channel->queue_declare('db_queue', false, false, false, false);

function getFromIni()
{
	
}

function processRequest($n)
{
	$link = connectDB();
	$sqlResult = $link->query($n);
	//var_dump($sqlResult);
	
	$returnArray = array();
	if(is_bool($sqlResult) === TRUE)
	{
		$returnArray[] = (int)$sqlResult;
	}
	else
	{
		while($row = mysqli_fetch_assoc($sqlResult))
		{
			$returnArray[] = $row;
		}
	}

	$resultJSON = json_encode($returnArray);
	echo " Returning results\n ";
	//echo $resultJSON;
	return $resultJSON;
}

echo " [x] Awaiting DB requests\n"; 

$callback = function($req) {
	echo " Processing on DB server \n";
	$r = processRequest($req->body);
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
$channel->basic_consume('db_queue', '', false, false, false, false, $callback);
while(count($channel->callbacks)) {
    $channel->wait();
}
$channel->close();
$connection->close();
?>
