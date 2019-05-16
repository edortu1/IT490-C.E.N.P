#!/usr/bin/php
<?php
require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');


function markBad($machine)
{
	echo "sending mark bad request".PHP_EOL;
	$client = new rabbitMQClient("qaRabbitMQ.ini", "deployServer");
	$request = array();
	$request['type'] = "markB";
	$request['machineType'] = $machine;
	$client->send_request($request);
	echo "successfully sent".PHP_EOL;
}
$machineType = 'deploy';

markBad($machineType);

