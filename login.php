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
if ($response == true)
{
$key = SHA1($_GET["username"].time());
$sessionkey = $key;

$cookie_name = "sessionkey";
$cookie_value = $sessionkey;

setcookie($cookie_name, $sessionkey);



$request = array();
$request['type'] = "create_session";
$request['username'] = $_GET["username"];
$request['sessionkey'] = $sessionkey;
$response = $client->publish($request);

echo '<p style="font-size:30px; color: green" align="center">Logged In Successfully.';
echo '<p style="font-size:20px; align="center">Redirecting to Search Page.';
header( "Refresh:2; http://25.8.187.190:3000", true, 303);
}
else{
echo '<p style="font-size:30px; color: red" align=center>Login Declined</p>';
echo '<p style="font-size:20px; align="center">Redirecting to Login Page.';
header( "Refresh:2; url=/IT490-C.E.N.P", true, 303);
}
?>
