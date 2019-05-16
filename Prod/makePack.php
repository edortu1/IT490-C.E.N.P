#!/usr/bin/php
<?php
require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');

global $argv;

function checkVersion($machine)
{
	echo "Checking versionNumber for ".$machine.PHP_EOL;
	$client = new rabbitMQClient("deployRabbitMQ.ini","deployServer");
	$request= array();
	$request['type'] = "vCheck";
	$request['machineType']= $machine;
	$response = $client->send_request($request);
	$sessionData = json_decode($response,true);
	$currentVersion = $sessionData['versionNum'];
	$nextVersion = $currentVersion+1;
	echo "New version number for ".$machine." is ".$nextVersion.PHP_EOL; 
	return $nextVersion;
}

function createNewV($machine)
{

	$client = new rabbitMQClient("deployRabbitMQ.ini","deployServer");

	$nextVersion = checkVersion($machine);
	shell_exec('./package.sh '.$machine.' '.$nextVersion);
	$request= array();
	$request['type'] = "newPack";
	$request['machineType'] = $machine;
	$request['versionNum'] = $nextVersion;
	$request['packageName'] = $machine.'_'.$nextVersion.'.tar';
	$client->send_request($request);
}
$machineType = $argv[1];

echo "Creating new version for ". $machineType.PHP_EOL;
createNewV($machineType);
echo "Version created successfully".PHP_EOL;
