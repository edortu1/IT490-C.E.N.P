#!/usr/bin/php
<?php
include('account.php');
global $argv;
$packReq = $argv[1];

//set up database
$userdb = new mysqli($hostname, $username ,$password, $db);
if ($userdb->connect_error)
{
        die('Connect Error');
}
#send latest pending package for testing
if ($packReq == "testing")
{
		global $userdb;
        $query = "select packageName from deployTable where machineType = 'deploy' and status = 'pending' order by versionNum desc limit 1";
        $packName= $userdb->query($query);
        $packName = $packName->fetch_assoc();
        echo $packName['packageName'];
}
#send latest good package for production use only
elseif ($packReq == "prod")
{
        $query = "select packageName from deployTable where machineType = 'deploy' and status = 'good' order by versionNum desc limit 1";
        $packName = $userdb->query($query);
	$packName = $packName->fetch_assoc();
	echo $packName['packageName'];
}
#send latest pending package not marked bad
elseif ($packReq == "rollback")
{
        $query = "select packageName from deployTable where machineType = 'deploy' and status = 'good' order by versionNum desc limit 1";
        $packName = $userdb->query($query);
        $packName = $packName->fetch_assoc();
        echo $packName['packageName'];
}
elseif ($packReq == "deploy")
{
	$query = "select packageName from deployTable where machineType = 'deploy' and status = 'good' order by versionNum desc limit 1";
	$packName = $userdb->query($query);
	$packName = $packName->fetch_assoc();
	echo $packName['packageName'];
}
else
{
	echo "$packReq is not a valid input plese enter (latest,good,rollback, or deploy)";
}

