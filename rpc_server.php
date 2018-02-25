<?php
require_once __DIR__ . '/vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

$connection = new AMQPStreamConnection('localhost', 5672, 'guest', 'guest');
$channel = $connection->channel();
$channel->queue_declare('rpc_queue', false, false, false, false);

function validate($n) {
	$userData = explode(' ', $n);
	if($userData[0]=="user" && $userData[1]=="pass")
	{
		echo " login OK \n";
		return 11111;
	}
	else
	{
		echo " login failed \n";
		return 00000;
	}
}

echo " [x] Awaiting RPC requests \n"; 

$callback = function($req) {
	echo " validating on server side \n ";
	$msg = new AMQPMessage(
		(string) validate($req->body),
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
