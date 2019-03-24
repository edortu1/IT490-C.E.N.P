<?php

require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');


$client = new rabbitMQCLient('testRabbitMQ.ini', 'testServer');
if (isset($argv[1]))
{
	$msg = $argv[1];
}
else
{
	$msg = "test message";

}

$request = array();
$request['type'] = "login";
$request['username'] = $_GET["username"];
$request["password"] = $_GET["password"];
$request["message"] = $msg;
$response = $client->send_request($request);

?>
