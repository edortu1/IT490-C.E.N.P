#!/usr/bin/php
<?php
require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');


function markGood($machine)
{
	echo "sending mark good request".PHP_EOL;
	$client = new rabbitMQClient("qaRabbitMQ.ini", "deployServer");
	$request = array();
	$request['type'] = "markG";
	$request['machineType'] = $machine;
	$client->send_request($request);
	echo "successfully sent".PHP_EOL;
}
$machineType = 'deploy';

markGood($machineType);

