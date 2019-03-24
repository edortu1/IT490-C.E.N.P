#!/usr/bin/php
<?php
require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');

function writeErrors($date, $errorMSG)
{
    file_put_contents('/home/nick/Desktop/error.log', "[".$date."]".$errorMSG.PHP_EOL, FILE_APPEND);
}

function requestProcessor($request)
{
    echo "received request".PHP_EOL;
    var_dump($request);
    writeErrors($request["date"],$request["msg"]);
    return array("returnCode" => '0', 'message'=>"Server received request and processed");
}

$server = new rabbitMQServer("logger.ini","testServer");
echo "Error Server has started.".PHP_EOL;
$server->process_requests('requestProcessor');
echo "Error Server has stopped.".PHP_EOL;
exit();
?>
