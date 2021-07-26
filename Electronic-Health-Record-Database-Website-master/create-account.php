<?php

if ((isset($_POST['username']))&&(isset($_POST['password']))&&(isset($_POST['first_name']))&&(isset($_POST['last_name']))) {

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
		
		$q="SELECT * FROM _doctor WHERE username='".$mysqli->real_escape_string($_POST['username'])."'";

		if (!$result = $mysqli->query($q)) {
			//----- for debugging purpose only -----
			//echo '<h3 class="err">Query failed: (' . $mysqli->errno . ') ' . $mysqli->error . '</h3>';
		}
		else {		
			if ($result->num_rows==1) {
				echo '<p class="error">Sorry, the username "'.htmlspecialchars($mysqli->real_escape_string($_POST['username'])).'" is already taken.<br>Please try a different username.</p>';				
			}
			else {
				$qq="INSERT INTO _doctor (username, password, first_name, last_name) VALUES ('".$mysqli->real_escape_string($_POST['username'])."','".$mysqli->real_escape_string($_POST['password'])."','".$mysqli->real_escape_string($_POST['first_name'])."','".$mysqli->real_escape_string($_POST['last_name'])."');";
				if (!($stmt = $mysqli->prepare($qq))) {
					//echo '<h3 class="err">Prepare failed: (' . $stmt->errno . ') ' . $stmt->error . '</h3>';
					echo '<h3 class="err">Database error. Please contact database administrator.</h3>';
				}
				else if (!$stmt->execute()) {
					//echo '<h3 class="err">Execute failed: (' . $stmt->errno . ') ' . $stmt->error . '</h3>';
					echo '<h3 class="err">Database error. Please contact database administrator.</h3>';
				}
				else {
					echo '<p class="success">Your new account has been created! Please <a href="index.html">login</a>.</p>';
				}
			}
		}
	}
}
else {
	echo '<!DOCTYPE html><html><head><meta charset="UTF-8"><meta http-equiv="refresh" content="0; URL=create-account.html"><title> </title></head><body></body></html>';
}
?>