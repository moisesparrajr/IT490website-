<?php

require_once __DIR__ . '/vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use \Firebase\JWT\JWT;
include 'connect.php';

$connection = new AMQPStreamConnection('localhost', 5672, 'guest', 'guest');
$channel = $connection->channel();
$channel->queue_declare('req_queue', false, false, false, false);

function processReq($input_data)
{
	$link = connectDB();
	$dataObj = json_decode($input_data);
	echo " Attempting query\n";

        $sqlQuery = "SELECT "; //assign SELECT to query
	foreach($dataObj as $key => $value) //append all non table values followed by coma to query
	{
		$dataArray[$key] = $value;
		if($key != "table"){
			$sqlQuery .= $key . ",";
		}
	}
	$sqlQuery = rtrim($sqlQuery, ","); //trim last coma from query 
	$sqlQuery .= " FROM " . $dataObj->table . ";"; //append FROM tablename ; to  query

	$results = $link->query($sqlQuery);
	$returnArray = array();
	
        if($results->num_rows > 0)
        {
                echo " Got results from DB\n";
		while($row = $results->fetch_assoc())
		{
			$returnArray[] = $row;
		}
        }
        else
        {
                echo " No results from DB\n";
        }

	$returnObj = json_encode($returnArray);
	//return json_stringify($returnObj);
	echo $returnObj;
	return $returnObj;
}

echo " [x] Awaiting requests for DB\n"; 

$callback = function($req) {
	echo " Processing on server side\n";
	$r = processReq($req->body);
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
$channel->basic_consume('req_queue', '', false, false, false, false, $callback);
while(count($channel->callbacks)) {
    $channel->wait();
}
$channel->close();
$connection->close();
?>
