<?php

/**
This script is called from a Github WebHook whenever there is a push to the repo.

This causes the server to pull from the repo and update the website.
**/

$REPO_PULL_LOC = "/var/www/gitpull";
$WEB_FOLDER_NAME = "Survenator\ Web\ Page";
$COPY_LOC = "/var/www";
$REPO = "https://github.com/Tarvis451/Survinator.git";

if ( isset($_POST['payload']) )
{
	//Pull from repo
	shell_exec("cd {$REPO_PULL_LOC} && git pull");
	
	//Copy web folder contents to actual web folder on server
	shell_exec("cd {$REPO_PULL_LOC}/{$WEB_FOLDER_NAME} && cp -r * {$COPY_LOC}");

	exit("Recieved payload and updated server");
}
else
	exit("Rejected; no payload");

?>
