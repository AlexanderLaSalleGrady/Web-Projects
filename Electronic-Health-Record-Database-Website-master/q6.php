<?php
session_start();

if (isset($_SESSION['id'])&&isset($_SESSION['username'])&&isset($_SESSION['password'])&&isset($_SESSION['first_name'])&&isset($_SESSION['last_name'])&&isset($_POST['patient_id'])&&isset($_POST['disease_id'])&&isset($_POST['diagnosis_date'])) {
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

	$q="INSERT INTO _has_disease (patient_id, disease_id, diagnosis_date) VALUES ('".$mysqli->real_escape_string($_POST['patient_id'])."', '".$mysqli->real_escape_string($_POST['disease_id'])."', '".$mysqli->real_escape_string($_POST['diagnosis_date'])."')";

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
	echo '<h3 class="modified">You added ' . $stmt->affected_rows . ' row.</h3>';
	
	//display the row that was just added
	$qq="SELECT * FROM _has_disease WHERE patient_id='".$mysqli->real_escape_string($_POST['patient_id'])."' AND disease_id='".$mysqli->real_escape_string($_POST['disease_id'])."'";
	
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
	
	//generate a table
	echo '<table><tr>';
	//print table header
	foreach($colNames as $colName) {
		echo '<td>'.$colName.'</td>';
	}
    echo '</tr>';
	//print rows
	foreach($data as $row) {
		echo '<tr>';
		foreach($colNames as $colName) {
			echo '<td>'.htmlspecialchars($row[$colName]).'</td>';
		}
		echo '</tr>';
	}
	echo '</table>';
}
else {
	include('redirect.php');
}
?>
