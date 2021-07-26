<?php
session_start();

if (isset($_SESSION['id'])&&isset($_SESSION['username'])&&isset($_SESSION['password'])&&isset($_SESSION['first_name'])&&isset($_SESSION['last_name'])&&isset($_POST['id'])&&isset($_POST['update_address'])&&isset($_POST['update_city'])&&isset($_POST['update_state'])&&isset($_POST['update_zip_code'])&&isset($_POST['update_phone'])) {
	//start connecting server
	$dbhost = "localhost:3306";
	$dbuser = "zersixni_login";
	$dbpass = "cs2010";
	$dbname = "zersixni_ehr";
	
	

	//include('password.php');

	$mysqli = new mysqli($dbhost, $dbuser, $dbpass, $dbname); 

	if (!$mysqli||$mysqli->connect_errno) {
		//echo '<h3 class="err">Failed to connect to MySQL: (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error . '</h3>';
		echo '<h3 class="err">Database error. Please contact database administrator.</h3>';
		exit;
	}

	//----- for debugging purpose only -----
	//echo 'Successfully connected to database';

	$q="UPDATE _patient SET address='".$mysqli->real_escape_string($_POST['update_address'])."', city='".$mysqli->real_escape_string($_POST['update_city'])."', state='".$mysqli->real_escape_string($_POST['update_state'])."', zip_code='".$mysqli->real_escape_string($_POST['update_zip_code'])."', phone='".$mysqli->real_escape_string($_POST['update_phone'])."' WHERE id='".$mysqli->real_escape_string($_POST['id'])."'";

	if (!($stmt = $mysqli->prepare($q))) {
		//echo '<h3 class="err">Prepare failed: (' . $mysqli->errno . ') ' . $mysqli->error . '</h3>';
		echo '<h3 class="err">Database error. Please contact database administrator.</h3>';
		exit;
	}
	if (!$stmt->execute()) {
		//echo '<h3 class="err">Execute failed: (' . $stmt->errno . ') ' . $stmt->error . '<h3>';
		echo '<h3 class="err">Database error. Please contact database administrator.</h3>';
		exit;
	}	
		
	echo '<h3 class="center">Result:</h3>';
	echo '<h3 class="modified">Updated Record:</h3>';
	
	if ($stmt->affected_rows==0) {
		exit;
	}
	
	//display the row that was just updated
	$qq="SELECT p.id AS `Patient ID`, p.first_name AS `First Name`, p.last_name AS `Last Name`, p.address AS `Address`, p.city AS `City`, p.state AS `State`, p.zip_code AS `Zip Code`, p.phone AS `Phone`, d.last_name AS `Doctor` FROM _patient AS p INNER JOIN _doctor AS d ON p.doctor_id=d.id WHERE p.id='".$mysqli->real_escape_string($_POST['id'])."'";
	
	if (!$result = $mysqli->query($qq)) {
		//echo '<h3 class="err">Query failed: (' . $mysqli->errno . ') ' . $mysqli->error . '</h3>';
		echo '<h3 class="err">Database error. Please contact database administrator.</h3>';
		exit;
	}
	
	//fetch data
	while ($row = $result->fetch_assoc()) {
		$data[] = $row;
	}
	$colNames = array_keys(reset($data));
	$len=$result->field_count;
	
	//generate a table (transposed)
	echo '<table>';
	for ($i=0;$i<=$len-1;$i++) {
		echo '<tr>';
		echo '<td>'.$colNames[$i].'</td>';
		echo '<td>'.htmlspecialchars($data[0][$colNames[$i]]).'</td>';
		echo '</tr>';
	}	
	echo '</table>';
}
else {
	include('redirect.php');
}
?>
