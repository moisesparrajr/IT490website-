<?php

require_once __DIR__ . '/vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use \Firebase\JWT\JWT;

if($_POST["action"] == "request")
{
	$dataFromJS = $_POST["data"];
	$dataToSend = $dataFromJS;
	$reqSend = new RpcSend();
	$response = $reqSend->call($dataToSend);
	//return JSON.stringify($response);
	echo $response;
	return $response;
}

class RpcSend {
	private $connection;
	private $channel;
	private $requests_queue;
	private $response;
	private $corr_id;
	public function __construct() {
		$this->connection = new AMQPStreamConnection(
			'localhost', 5672, 'guest', 'guest');
		$this->channel = $this->connection->channel();
		list($this->requests_queue, ,) = $this->channel->queue_declare(
			"", false, false, true, false);
		$this->channel->basic_consume(
			$this->requests_queue, '', false, false, false, false,
			array($this, 'on_response'));
	}
	public function on_response($rep) {
		if($rep->get('correlation_id') == $this->corr_id) {
			$this->response = $rep->body;
		}
	}
	public function call($data) {
		$this->response = null;
		$this->corr_id = uniqid();
		$msg = new AMQPMessage(
			$data,
			array('correlation_id' => $this->corr_id,
			      'reply_to' => $this->requests_queue)
			);
		$this->channel->basic_publish($msg, '', 'req_queue');
		while(!$this->response) {
			$this->channel->wait();
		}
		return $this->response;
	}
};


?>
