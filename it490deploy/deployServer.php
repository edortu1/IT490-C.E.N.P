#!/usr/bin/php
<?php
require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');
include ('account.php');
	$userdb = mysqli_connect($hostname, $username, $password, $db);
	global $userdb;
	
	if (mysqli_connect_errno())
	{
		echo "failed to connect to mySQL: "."\n". mysqli_connect_error();
		exit();
	}else
	{
		echo "Successfully connected to mySQL"."\n".PHP_EOL;
	}

function versionCheck($machineType)
{
	//set up database
	global $userdb;
	
	$userData = array();
	$query = "select versionNum from deployTable where machineType= '$machineType' order by versionNum desc limit 1";
	$versionNum = mysqli_query($userdb,$query);
	$versionNum= mysqli_fetch_assoc($versionNum);
	echo "Current Version Number is ".$versionNum['versionNum'].PHP_EOL;
	$userData['versionNum']= $versionNum['versionNum'];
	return json_encode($userData);
}
function insertVersion($machineType, $versionNum, $packageName)
{
	//set up database
     global $userdb;
	$date= date("M,d,Y h:i:s A");
	echo "Inserting latest version into table";
	$query= "Insert into deployTable values ('$date','$machineType', $versionNum, '$packageName', 'pending')";
	mysqli_query($userdb,$query);
}
function markGood($machineType)
{
	//set up database
	global $userdb;
	$query = "update deployTable set status = 'good' where machineType= '$machineType' and status='pending' order by versionNum desc limit 1";
	mysqli_query($userdb,$query);
	return true;

}
function markBad($machineType)
{
	//set up database
        global $userdb;
        $query = "update deployTable set status = 'bad' where machineType= '$machineType' order by versionNum desc limit 1";
	mysqli_query($userdb,$query);
	return false;

}
function requestProcessor($request)
{
	echo "received request".PHP_EOL;
	var_dump($request);
	if(!isset($request['type']))
	{
		return "ERROR: unsupported message type";
	}
	switch ($request['type'])
	{
		case "vCheck":
			return versionCheck($request['machineType']);
		case "newPack":
			return insertVersion($request['machineType'],$request['versionNum'], $request['packageName']);
		case "markG":
			return markGood($request['machineType']);
		case "markB":
			return markBad($request['machineType']);
	}
	return array("returnCode"=> '0', 'message'=>"Server received request and processed");
}
$server = new rabbitMQServer("deployRabbitMQ.ini","deployServer");
echo "Deploy Server BEGIN".PHP_EOL;
$server->process_requests('requestProcessor');
echo "Deploy Server END".PHP_EOL;
exit();
?>
