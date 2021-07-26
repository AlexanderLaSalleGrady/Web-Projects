<?php
session_start();
if (isset($_SESSION['username'])&&isset($_SESSION['password'])) {
	$_SESSION['username']=NULL;
	$_SESSION['password']=NULL;

	echo '<!DOCTYPE html>';
	echo '<html>';
	echo '<head>';
	echo '<meta charset="UTF-8">';
	echo '<meta http-equiv="refresh" content="2; URL=index.html">';
	echo '<title>Log out successful </title>';
	echo '</head>';
	echo '<body>';
	echo '<h3>You have successfully logged out. </h3>';
	echo '<h3>The page will be redirected to the <a href="index.html">login page</a> after 2 seconds. </h3>';
	echo '</body>';
	echo '</html>';
}
else {
	include('redirect.php');
}
?>