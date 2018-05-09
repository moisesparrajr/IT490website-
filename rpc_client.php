<?php
require_once __DIR__ . '/vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use \Firebase\JWT\JWT;
if($_POST["action"] == "authenticate")
{
	$name = $_POST["user"];
	$password = $_POST["password"];
	
	$dataToSend = $name . ' ' . $password;
	
	$rpc_confirm = new RpcSend();
	$response = $rpc_confirm->call($dataToSend);
	echo $response;
}
if($_POST["action"] == "signup")
{
        $name = $_POST["user"];
        $password = $_POST["password"];
	$twitchID = $_POST["twitchID"];
        $dataToSend = $name . ' ' . $password . ' ' . $twitchID;
        $rpc_confirm = new RpcSend();
        $response = $rpc_confirm->call($dataToSend);
        echo $response;
}
function validJWT($token)
{
	$key = "secretKey";
	$decoded = JWT::decode($token, $key);
	return $decoded;
}
class RpcSend {
	private $connection;
	private $channel;
	private $callback_queue;
	private $response;
	private $corr_id;
	public function __construct() {
		$ip_info = parse_ini_file("rpcIP.ini");
		$ip_addr = $ip_info["rpc_ip"];
		$this->connection = new AMQPStreamConnection(
			$ip_addr, 5672, $ip_info["user"], $ip_info["password"]);
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
			(string) $data,
			array('correlation_id' => $this->corr_id,
			      'reply_to' => $this->callback_queue)
			);
		$this->channel->basic_publish($msg, '', 'rpc_queue');
		while(!$this->response) {
			$this->channel->wait();
		}
		return $this->response;
	}
};
?>