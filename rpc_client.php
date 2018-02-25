<?php

require_once __DIR__ . '/vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

if($_POST["action"] == "authenticate")
{
	$name = $_POST["user"];
	$password = $_POST["password"];
	
	$dataToSend = $name . ' ' . $password;
	
	$rpc_confirm = new RpcSend();
	$response = $rpc_confirm->call($dataToSend);
	echo " [.] Got ", $response, "\n";
	
}

class RpcSend {
	private $connection;
	private $channel;
	private $callback_queue;
	private $response;
	private $corr_id;
	public function __construct() {
		$this->connection = new AMQPStreamConnection(
			'localhost', 5672, 'guest', 'guest');
		$this->channel = $this->connection->channel();
		list($this->callback_queue, ,) = $this->channel->queue_declare(
			"", false, false, true, false);
		$this->channel->basic_consume(
			$this->callback_queue, '', false, false, false, false,
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
			      'reply_to' => $this->callback_queue)
			);
		$this->channel->basic_publish($msg, '', 'rpc_queue');
		while(!$this->response) {
			$this->channel->wait();
		}
		return intval($this->response);
	}
};


?>
