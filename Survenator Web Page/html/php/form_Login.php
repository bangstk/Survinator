<?php

//Dynamic form for login, included in html
//Actual login info is a separate script

require 'login.php';

//handle sent form, call real login function, do stuff based on return
$error = "";
$userfield = "";

if(isset($_POST['submit']))
{
	$user = $_POST['username'];
	$pass = $_POST['password'];
	
	$res = login($user, $pass);
	
	//successful login
	if ($res == 0)
	{
		$return = "Logged in as {$user}!<br>";
		$url = "/MainOptions.html";
		
    	header("Location: ".$url);
    	die($return);
	}
    
	else if ($res == 91)
		$error = "The specified user does not exist.";
	else if ($res == 92)
		$error = "Incorrect password.";
		
	$userfield = $user;
}

?>
<center><font color='red'><?php echo $error; ?></font></center>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
      Username: <input type="text" name="username" value="<?php echo $userfield; ?>" >
      Password: <input type="password" name="password" value="">
      <input type="submit" name="submit" value="Log In">
</form>
