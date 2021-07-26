<?php
session_start();

if (isset($_SESSION['id'])&&isset($_SESSION['username'])&&isset($_SESSION['password'])&&isset($_SESSION['first_name'])&&isset($_SESSION['last_name'])&&isset($_POST['id'])) {
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

	$q="SELECT p.id AS `Patient ID`, p.first_name AS `First Name`, p.last_name AS `Last Name`, p.ssn AS `SSN`, p.date_of_birth AS `Date of Birth`, p.sex AS `Sex`, p.address AS `Address`, p.city AS `City`, p.state AS `State`, p.zip_code AS `Zip Code`, p.phone AS `Phone`, d.last_name AS `Doctor` FROM _patient AS p INNER JOIN _doctor AS d ON p.doctor_id=d.id WHERE p.id='".$mysqli->real_escape_string($_POST['id'])."' AND d.first_name='".$_SESSION['first_name']."' AND d.last_name='".$_SESSION['last_name']."'";

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
