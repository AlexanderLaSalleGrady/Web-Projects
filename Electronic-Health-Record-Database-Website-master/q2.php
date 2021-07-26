<?php
session_start();

if (isset($_SESSION['id'])&&isset($_SESSION['username'])&&isset($_SESSION['password'])&&isset($_SESSION['first_name'])&&isset($_SESSION['last_name'])&&isset($_POST['before_after'])&&isset($_POST['date_of_birth'])) {
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

	$q="SELECT p.id AS `Patient ID`, p.first_name AS `First Name`, p.last_name AS `Last Name`, p.ssn AS `SSN`, p.date_of_birth AS `Date of Birth`, p.sex AS `Sex`, p.phone AS `Phone`, d.last_name AS `Doctor` FROM _patient AS p INNER JOIN _doctor AS d ON p.doctor_id=d.id WHERE p.date_of_birth".($mysqli->real_escape_string($_POST['before_after'])=='after'?'>':'<')."'".$mysqli->real_escape_string($_POST['date_of_birth'])."' AND d.last_name='".$_SESSION['last_name']."'";
	
	echo '<h3 class="center">Result:</h3>';
	if (!$result = $mysqli->query($q)) {
		//echo '<h3 class="err">Query failed: (' . $mysqli->errno . ') ' . $mysqli->error . '</h3>';
		echo '<h3 class="err">Database error. Please contact database administrator.</h3>';
		exit;
	}
	if ($result->num_rows==0) {
		echo '<h3 class="center">No record.</h3>';
		exit;
	}
	
	//fetch data
	while ($row = $result->fetch_assoc()) {
		$data[] = $row;
	}
	$colNames = array_keys(reset($data));
	
	//generate a table
	echo '<table class="sortable" id="ajaxSortTable"><tr>';
	//print table header
	foreach($colNames as $colName) {
		echo '<th>'.$colName.'</th>';
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
	if ($result->num_rows>1) {
		echo '<h5 class="center">(The above table has clickable headers that sort the table by the clicked column.)</h5>';
	}
}
else {
	include('redirect.php');
}
?>
