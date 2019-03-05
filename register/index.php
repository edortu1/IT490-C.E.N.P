<?php
Require_once("../header.html");
?>

<div id="loginbox">
	<h1 style="position:relative;display:block;" align="center">Welcome to Kaplunk</h1>
        
    	<form style="position: relative;" name="register" action="/IT490-C.E.N.P/register/register.php" method="get" onsubmit="return validateForm()">     	
            <p align="center"> Choose a Username:</p>
        	<input placeholder="Username" autocomplete="on" type="text" name="username">
        	<br>
        	<br>
       	 	<p align="center">Please Create a Password: </p>
       	 	<input align="center"placeholder="Password" autocomplete="on" type="password" name="password">
        	<br><br>
            <p align="center">Please Enter E-mail Address:</p>
        	<input placeholder="E-mail" autocomplete="on" type="text" name="email">
        	<br>
        	<br>
            <br>


        <input width="100%" id="submit" name="signin" type="submit" value="Sign In" label="Sign In">
        <br><p align="center" style="color: red;">*** Your E-mail Address will only be ***  used for sending you <br>Notifications about your packages.</p>
            <br>
        </form>  
</div>

<?php
Require_once("../footer.html");
?>
