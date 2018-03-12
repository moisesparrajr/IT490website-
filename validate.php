<?php
require_once __DIR__ . '/vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use \Firebase\JWT\JWT;

function validJWT($input_token, $input_id)
{
        $key = "secretKey";
	try
	{	
        	$decoded = JWT::decode($input_token, $key, array('HS256'));
        	if($decoded->{"id"} == $input_id)
        	{
                	return true;

        	}
	}catch(UnexpectedValueException $e)
	{
		return false;
	}
}

if($_POST)
{
        $id = $_POST["id"];
        $token = $_POST["jwt"];
	$response = "kick";
	
	if(validJWT($token, $id))
	{
		$response = "valid";
	}
	echo $response;
}


?>
