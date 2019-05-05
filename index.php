<html lang="en">
  <head>
    <meta name="google-signin-scope" content="profile email">
    <meta name="google-signin-client_id" content="453852442951-cm9v1fe4110mgmi8hlee71vq42jffvo1.apps.googleusercontent.com">
    <script src="https://apis.google.com/js/platform.js" async defer></script>
  </head>
  <body>
    <div class="g-signin2" data-onsuccess="onSignIn" data-theme="dark"></div>
    <script>
      function onSignIn(googleUser) {
        // Useful data for your client-side scripts:
        var profile = googleUser.getBasicProfile();
        console.log("ID: " + profile.getId()); // Don't send this directly to your server!
        console.log('Full Name: ' + profile.getName());
        console.log('Given Name: ' + profile.getGivenName());
        console.log('Family Name: ' + profile.getFamilyName());
        console.log("Image URL: " + profile.getImageUrl());
        console.log("Email: " + profile.getEmail());
        // The ID token you need to pass to your backend:
        var id_token = googleUser.getAuthResponse().id_token;
        console.log("ID Token: " + id_token);
	window.location.href="http://127.0.0.1/IT490-C.E.N.P/login.php?id_token="+id_token;
      }
    </script>
  </body>
</html>
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
    		header("Location: http://25.8.187.190/IT490-C.E.N.P/movieSearch.php");
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
