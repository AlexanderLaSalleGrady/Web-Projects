<?php	
if ((isset($_POST['username']))&&(isset($_POST['password']))) {

	//start connecting server
	$dbhost = "localhost:3306";
	$dbuser = "zersixni_login";
	$dbpass = "cs2010";
	$dbname = "zersixni_ehr";

	

	//include('password.php');

	$mysqli = new mysqli($dbhost, $dbuser, $dbpass, $dbname); 

	if (!$mysqli||$mysqli->connect_errno) {
		//----- for debugging purpose only -----
		//echo '<h3 class="err">Failed to connect to MySQL: (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error . '</h3>';
	}
	else {
		//----- for debugging purpose only -----
		//echo 'Successfully connected to database';
		
		$q="SELECT username, password FROM _doctor WHERE username='".$mysqli->real_escape_string($_POST['username'])."' AND password='".$mysqli->real_escape_string($_POST['password'])."'";

		if (!$result = $mysqli->query($q)) {
			//----- for debugging purpose only -----
			//echo '<h3 class="err">Query failed: (' . $mysqli->errno . ') ' . $mysqli->error . '</h3>';
		}
		else {
			if ($result->num_rows==0) {
				echo '<p class="error">Sorry, login was unsuccessful. <br>Please try again or <a href="create-account.html">create a new account</a>.</p>';
			}
			else {					
				session_start(); 
				$_SESSION['username'] = $mysqli->real_escape_string($_POST['username']);
				$_SESSION['password'] = $mysqli->real_escape_string($_POST['password']);	
				
				header("HTTP/1.0 202 Accepted");
				//echo '<p class="success">Login successful...</p>';//this echo will never echo, because it is after header.
			}
		}
	}
}
else {
	include('redirect.php');
}
?>