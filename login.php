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
	$curl = curl_init();
                curl_setopt_array($curl, array(
                CURLOPT_URL => "https://api.themoviedb.org/3/authentication/token/new?api_key=7ccdb5d63255684fcdd0634087e88578",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "GET",
                CURLOPT_POSTFIELDS => "{}",
        ));
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);      
        if ($err) {
                echo "cURL Error #:" . $err;
        } else {
                global $token;
                $token = json_decode($response);
                echo $token->request_token;
                echo $response;
        }
	global $token;
	$url = "http://10.0.2.15:3000";
                header('Location: '.$url); 
}else
{
	echo "you're wrong";
}
