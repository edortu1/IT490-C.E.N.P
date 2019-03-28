#!/usr/bin/php
<?php
require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');
include ("account.php");
	$userdb = mysqli_connect($hostname, $username, $password, $db);
global $userdb;

function logger($statement)
{
	$date = date("M,d,Y h:i:s A");
    $logClient = new rabbitMQClient("logger.ini","testServer");
    $request = array();
    $request['type'] = "error";
    $request['LogMessage'] = $statement;
    file_put_contents('/home/nick/Desktop/error.log',"[".$date."]".$request['LogMessage'].PHP_EOL, FILE_APPEND);
    $response = $logClient->publish($request);
}
if (mysqli_connect_errno())
{
	echo "failed to connect to MySQL: "."\n". mysqli_connect_error();
	$error = "Failed to connect to MySQL.".PHP_EOL;
	echo $error;
	logger($error);
	exit();
}else
{
	echo "Successfully connected to MYSQL."."\n".PHP_EOL;
}

function auth ($user, $pass){
	
	global $userdb;
	$s = "SELECT * from testtable where username = \"$user\" && password = \"$pass\"";
	$t = mysqli_query($userdb, $s);
	if (!$t || mysqli_num_rows($t) == 0 )
	{
		echo "User and Password combination not found.".PHP_EOL;
		$error = "User and Password combination not found.".PHP_EOL;
	echo $error;
	logger($error);
		return false;
	}
	else {
		echo "Successfully Authenticated.".PHP_EOL;
		return true;
	}
}

function createSession ($user, $skey)
{
    global $userdb;
    $s = "SELECT userid from testtable where username = \"$user\"";
    $t = mysqli_query($userdb, $s);
    if(mysqli_num_rows($t) > 0)
    {
	$result = mysqli_fetch_row($t);
	$r = $result[0];
	$p = "SELECT sessionKey from session where userID = \"$user\"";
	$q = mysqli_query($userdb, $p);
	if(mysqli_num_rows($t) > 0)
	{
		while($row = mysqli_fetch_assoc($q))
		{
			rmSession($row["sessionKey"]);
		}
	}
	$a = "INSERT INTO session(sessionKey, userID) VALUES (\"$skey\",\"$r\")";
	mysqli_query($userdb, $a);
	echo "Session created!".PHP_EOL;
    }
    else
    {	
	$error = "No Session created for user \"$user\"".PHP_EOL;
	echo $error;
	logger($error);
    }
}

function signup ($user, $pass, $email){
    global $userdb;
    $s = "SELECT * from testtable where username = \"$user\" || email = \"$email\"";
    $t = mysqli_query($userdb, $s);
    
    if (!$t || mysqli_num_rows($t) >= 1)
    {
	echo "User/email is already on database.".PHP_EOL;
	return false;
    }
    else
    {
	$a = "INSERT INTO testtable(username,password,email) VALUES (\"$user\",\"$pass\",\"$email\")";
	mysqli_query($userdb, $a);
	echo "Successfully added User.".PHP_EOL;
	return true;
    }
}

function doValidate($seskey)
{
    global $userdb;
    $s = "Select * from session where sessionKey = \"$seskey\"";
    $t = mysqli_query($userdb, $s);
    if (mysqli_num_rows($t) >= 1)
    {
	echo "Session found!".PHP_EOL;
	return true;
    }
    else
    {
	echo "Session not found!".PHP_EOL;
	return false;
    }
}

function rmSession($seskey) 
{
    global $userdb;
    $s = "Delete from session where sessionKey = \"$seskey\"";
    $t = mysqli_query($userdb, $s);
}

function requestProcessor($request)
{
  echo "received request".PHP_EOL;
  var_dump($request);
  if(isset($request['type']))
  {
 	 switch ($request['type'])
  {
   		 case "login":
			return auth($request['username'], $request['password']);
		 case "signup":
			return signup($request['username'],$request['password'],$request['email']);
    		case "create_session":
      			createSession($request['username'], $request['sessionkey']);
    		case "validate_session":
      			return doValidate($request['sessionID']);
    		case "remove_session":
      			rmSession($request['sessionID']);	
		default:
			echo "try again";
	
}
  }
 }
$server = new rabbitMQServer("testRabbitMQ.ini","testServer");
echo "testRabbitMQServer BEGIN".PHP_EOL;
$server->process_requests('requestProcessor');
echo "testRabbitMQServer END".PHP_EOL;
exit();
?>
