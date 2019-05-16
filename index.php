<!DOCTYPE html>

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
	window.location.href="http://127.0.0.1/kaplunk/login.php?id_token="+id_token;
      }
    </script>
  </body>
</html>

<html>

	<head>

	<body>

	
		<h1 id="signUp">Kaplunk sign In</h1>

		<form method="get" action="login.php">

                	<input type="hidden" name="action" value="login">
				 
			<input type="text" placeholder="username" required="" id="username" name="username" /></br>
                
			<input type="text" placeholder="Password" required="" id="password" name="password" /></br>

			<input type="submit" id="logIn" class="submit" value="Log in" /></br>
			<input type="hidden" name="action" value="login">

                    	<input type="reset" id="clear" class="submit" value="Clear" />
            

		</form>
       <br>
<br>

<a href="register">Don't Have an Account? Click Here to Register!</a>    

	</body>

</html>
