<?php

require_once __DIR__ . '/vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

if($_POST["action"] == "authenticate")
{
	$name = $_POST["user"];
	$password = $_POST["password"];

	$connection = new AMQPStreamConnection('localhost', 5672, 'guest', 'guest');
	$channel = $connection->channel();

	$channel->queue_declare('hello', false, false, false, false);

	$dataToSend = $name . ' ' . $password;
	$msg = new AMQPMessage($dataToSend);
	$channel->basic_publish($msg, '', 'hello');

	echo " [X] Sent $dataToSend \n";

	$channel->close();
	$connection->close();

}

?>
