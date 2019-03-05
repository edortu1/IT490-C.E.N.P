<?php
Require_once("../header.html");
?>

<div id="loginbox">
	<h1 style="position:relative;display:block;" align="center">Welcome to Kaplunk</h1>
        
    	<form style="position: relative;" name="register" action="/IT490-C.E.N.P/register/register.php" method="get" onsubmit="return validateForm()">     	
            <p align="center"> Choose a Username:</p>
        	<input placeholder="Username" required="required"  autocomplete="on" type="text" name="username">
        	<br>
        	<br>
       	 	<p align="center">Please Create a Password: </p>
       	 	<input align="center"placeholder="Password" required="required"  autocomplete="on" type="password" name="password">
        	<br><br>
            <p align="center">Please Enter E-mail Address:</p>
        	<input placeholder="E-mail" required="required" autocomplete="on" type="text" name="email">
        	<br>
        	<br>
            <br>


        <input width="100%" id="submit" name="signin" type="submit" value="Sign Up" label="Sign Up">
                    <br>
	</form>
<a href="/IT490-C.E.N.P">Sign In</a>
  
</div>

<?php
Require_once("../footer.html");
?>
