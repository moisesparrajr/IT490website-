<?php

require_once __DIR__ . '/vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;

$connection = new AMQPStreamConnection('localhost', 5672, 'guest', 'guest');
$channel = $connection->channel();
$sqlConnection = NULL;

$channel->queue_declare('hello', false, false, false, false);

echo ' [*] Waiting. CTRL+C', "\n";

function connectDB()
{
	echo "Attempting connection";
	$sqlServer = "server";
	$sqlUser = "admin";
	$sqlPass = "12345";

	$sqlConnection = new mysqli($sqlServer, $sqlUser, $sqlPass);
	if($sqlConnection->connect_error)
	{
		die("Connection failed: " .  $sqlConnection->connect_error);
	}
};

$callback = function($msg)
{	
	connectDB();
	$userData = explode(' ', $msg->body);
	/*echo "user ", $userData[0], "\n";
	echo "pass ", $userData[1], "\n";

	if($userData[0] == "user" && $userData[1] == "password")
	{
		echo " [OK] credentials valid";
	}
	*/
	$sql = "SELECT email, password FROM Users";
	$result = $sqlConnection->query($sql);

	if ($result->num_rows > 0)
	{
    		while($row = $result->fetch_assoc())
		{
			if($row["email"] == $userData[0] && $row["password"] == $userData[1])
			{
				echo " [OK] credentials valid";
			}
   		}
	}
	else 
	{
   		 echo " [FAILED] No results from database";
	}
};

$channel->basic_consume('hello', '', false, true, false, false, $callback);

while(count($channel->callbacks))
{
	$channel->wait();
}

$channel->close();
$connection->close();
$sqlConnection->close();
?>

