<?php Require_once("../header.html"); ?>

<div id="loginbox">
	<h1 align="center">Welcome to R.O.P.</h1>

<?php
	require_once('../path.inc');
	require_once('../get_host_info.inc');
	require_once('../rabbitMQLib.inc');
	
	$client = new rabbitMQClient("../testRabbitMQ.ini","testServer");
	if (isset($argv[1]))
	{
		$msg = $argv[1];
	}
	else
	{
		$msg = "test message";
	}
	$request = array();
	$request['type'] = "signup";
	$request['username'] = $_GET["username"];
	$request['password'] = $_GET["password"];
	$request['email'] = $_GET["email"];
	$request['message'] = $msg;
	$response = $client->send_request($request);
	if ($response == true)
	{
		echo '<p style="font-size:30px; color: green" align="center">Account Created.</p>';}
	else
	{
		echo '<p style="font-size:30px; color: red" align="center">Username or E-mail is invalid!</p>';
	}
	echo '<p style="font-size:20px; color: blue" align=center>Redirecting to Login Page...</p>';
	header('Refresh: 5; URL=../index.php');
?>

<?php
Require_once("../footer.html");
?>
