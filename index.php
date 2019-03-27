<?php
if(isset($_COOKIE["sessionkey"])) {
	require_once('path.inc');
	require_once('get_host_info.inc');
	require_once('rabbitMQLib.inc');
	$client = new rabbitMQClient("testRabbitMQ.ini","testServer");
	if (isset($argv[1]))
	{
		$msg = $argv[1];
	}
	else
	{
	  $msg = "test message";
	}
	$request = array();
	$request['type'] = "validate_session";
	$request['sessionID'] = $_COOKIE["sessionkey"];
	$response = $client->send_request($request);
	if ($response == true){
    		header("Location: http://25.8.187.190:3000");
	} 
}
?>
	<div id="loginbox">
	<h1 id="header" align="center">Please Log In</h1><br>
                
    	<form name="login" action="login.php" method="get">     	
		Enter User:
        	<br><input placeholder="Username" autocomplete="on" type="text" name="username">
        	<br>
        	<br>
       	 	Enter Password: 
       	 	<br><input placeholder="Password" autocomplete="on" type="password" name="password">
        	<br><br>
            <a align="center" style="font-size: 12px;" href="/IT490-C.E.N.P/register">Don't have an account? Sign up Here.</a>
        	<br><br>

        <input align="center" id="submit" name="signin" type="submit" value="Sign In" label="Sign In">
	
        </form>  
        
</div>
