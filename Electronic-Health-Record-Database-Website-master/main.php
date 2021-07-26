<?php

session_start();

if (isset($_SESSION['username'])&&isset($_SESSION['password'])) {
	
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
		$q="SELECT id, first_name, last_name FROM _doctor WHERE username='".$_SESSION['username']."'";
		if (!($stmt = $mysqli->prepare($q))) {
			//echo '<h3 class="err">Prepare failed: (' . $stmt->errno . ') ' . $stmt->error . '</h3>';
			echo '<h3 class="err">Database error. Please contact database administrator.</h3>';
			exit;
		}
		if (!$stmt->execute()) {
			//echo '<h3 class="err">Execute failed: (' . $stmt->errno . ') ' . $stmt->error . '</h3>';
			echo '<h3 class="err">Database error. Please contact database administrator.</h3>';
			exit;
		}
		if (!$stmt->bind_result($id, $fn, $ln)){
			//echo '<h3 class="err">Binding failed: (' . $stmt->errno . ') ' . $stmt->error . '</h3>';
			echo '<h3 class="err">Database error. Please contact database administrator.</h3>';
			exit;
		}
		while ($stmt->fetch()) {
			$_SESSION['id'] = $id;
			$_SESSION['first_name'] = $fn;
			$_SESSION['last_name'] = $ln;
		}
?>

<!DOCTYPE html> 
<html>

<head>
	<meta charset="UTF-8">
	<title>Electronic Health Record Database</title>
	<link rel="stylesheet" type="text/css" href="main.css">
	<script type="text/javascript" src="hide.js"></script>
	<script type="text/javascript" src="sorttable.js"></script>
	<script type="text/javascript" src="main-ajax.js"></script>
</head>

<body>
<div>
<table class="header" style="width:100%;">
	<tr>
		<td class="header" style="text-align:left;">
			<?php
			echo '<h2>Welcome, Dr. '.$_SESSION['first_name'].' '.$_SESSION['last_name'].' </h2>';
			?>
		</td>
		<td class="header" style="width:18%">
			<h2><a href="<?php echo $_SERVER['PHP_SELF']; ?>">View All Patients</a>&emsp;<a href="logout.php">Log out</a></h2>
		</td>
	</tr>
</table>	
</div>

<!--SQL SELECT patient-->

<h2 class = "header" style = "text-indent: 38px;">Doctor's Options:</h2>

<div>
<fieldset>
	<legend style ="text-align:center;"><b>Search and Display Database Information</b></legend><br>
	
	<input type="radio" name="radio" class="radio" id="s1" value="s1" onclick="hide_all();show('opt1')"> 
	<span class="hand" onclick="hide_all();show('opt1')">
		 View patient information (Search by patient name) 
	</span><p>
	<form class="myform" id="form1" method="POST">
		<div class="hide" id="opt1">
			Patient: 
			<?php
				//fetch data for patient
				$q="SELECT p.id AS `Patient ID`, p.first_name AS `First Name`, p.last_name AS `Last Name` FROM _patient AS p INNER JOIN _doctor AS d ON p.doctor_id=d.id WHERE d.first_name='".$_SESSION['first_name']."' AND d.last_name='".$_SESSION['last_name']."'";
				if (!($stmt = $mysqli->prepare($q))) {
					//echo '<h3 class="err">Prepare failed: (' . $stmt->errno . ') ' . $stmt->error . '</h3>';
					echo '<h3 class="err">Unable to fetch patient list. Please contact database administrator.</h3>';
				}
				if (!$stmt->execute()) {
					//echo '<h3 class="err">Execute failed: (' . $stmt->errno . ') ' . $stmt->error . '</h3>';
					echo '<h3 class="err">Unable to fetch patient list. Please contact database administrator.</h3>';
				}
				if (!$stmt->bind_result($id, $first_name, $last_name)){
					//echo '<h3 class="err">Binding failed: (' . $stmt->errno . ') ' . $stmt->error . '</h3>';
					echo '<h3 class="err">Unable to fetch patient list. Please contact database administrator.</h3>';
				}
				//generate a drop-down list for patient
				echo '<select name="id" id="patientlist" required><option value=""> ID, First Name, Last Name </option>';
				while ($stmt->fetch()) {
					echo '<option value="' . htmlspecialchars($id) . '">' . htmlspecialchars($id) . ' ' . htmlspecialchars($first_name) . ' ' . htmlspecialchars($last_name) . '</option>';
				}
				echo '</select>';
			?>
			<p>
			<input type="button" id="button1" value="Submit" onclick="q1();"><p>
		</div>
	</form>
	
	<input type="radio" name="radio" class="radio" id="s2" value="s2" onclick="hide_all();show('opt2')"> 
	<span class="hand" onclick="hide_all();show('opt2')">
		 View patient information (Search by date of birth) 
	</span><p>
	<form class="myform" id="form2" method="POST">
		<div class="hide" id="opt2">
			Date of Birth
			<select name="before_after" id="before_after">
				<option value="before">Before</option>
				<option value="after">After</option>
			</select>
			<input type="text" name="date_of_birth" id="date_of_birth" maxlength="10" size="10" placeholder="yyyy-mm-dd" minlength="10" class="dateISO required"> 
			<p>
			<input type="button" id="button2" value="Submit" onclick="q2();"><p>
		</div>
	</form>
	
	<input type="radio" name="radio" class="radio" id="s3" value="s3" onclick="hide_all();show('opt3')"> 
	<span class="hand" onclick="hide_all();show('opt3')">
		 Search for patients who have a certain disease 
	</span><p>
	<form class="myform" id="form3" method="POST">
		<div class="hide" id="opt3"> 
			Disease: 
			<?php
				//fetch data for disease
				$q='SELECT id AS `ID`, name AS `Disease Name` FROM _disease ORDER BY id;';
				if (!($stmt = $mysqli->prepare($q))) {
					//echo '<h3 class="err">Prepare failed: (' . $stmt->errno . ') ' . $stmt->error . '</h3>';
					echo '<h3 class="err">Unable to fetch disease list. Please contact database administrator.</h3>';
				}
				if (!$stmt->execute()) {
					//echo '<h3 class="err">Execute failed: (' . $stmt->errno . ') ' . $stmt->error . '</h3>';
					echo '<h3 class="err">Unable to fetch disease list. Please contact database administrator.</h3>';
				}
				if (!$stmt->bind_result($id, $name)){
					//echo '<h3 class="err">Binding failed: (' . $stmt->errno . ') ' . $stmt->error . '</h3>';
					echo '<h3 class="err">Unable to fetch disease list. Please contact database administrator.</h3>';
				}
				//generate a drop-down list for disease
				echo '<select name="id" id="diseaselist" class="required"><option value=""> ID, Disease Name </option>';
				while ($stmt->fetch()) {
					echo '<option value="' . htmlspecialchars($id) . '">' . htmlspecialchars($id) . ' ' . htmlspecialchars($name) . '</option>';
				}
				echo '</select>';
			?>
			<p>
			<input type="button" id="button3" value="Submit" onclick="q3();"><p>
		</div>
	</form>
	
	<input type="radio" name="radio" class="radio" id="s4" value="s4" onclick="hide_all();show('opt4')"> 
	<span class="hand" onclick="hide_all();show('opt4')">
		 Search for patients who are on a certain drug 
	</span><p>
	<form class="myform" id="form4" method="POST">
		<div class="hide" id="opt4"> 
			Drug: 
			<?php
				//fetch data for drug
				$q='SELECT id AS `ID`, trade_name AS `Trade Name`, generic_name AS `Generic Name` FROM _drug ORDER BY id;';
				if (!($stmt = $mysqli->prepare($q))) {
					//echo '<h3 class="err">Prepare failed: (' . $stmt->errno . ') ' . $stmt->error . '</h3>';
					echo '<h3 class="err">Unable to fetch drug list. Please contact database administrator.</h3>';
				}
				if (!$stmt->execute()) {
					//echo '<h3 class="err">Execute failed: (' . $stmt->errno . ') ' . $stmt->error . '</h3>';
					echo '<h3 class="err">Unable to fetch drug list. Please contact database administrator.</h3>';
				}
				if (!$stmt->bind_result($id, $trade_name, $generic_name)){
					//echo '<h3 class="err">Binding failed: (' . $stmt->errno . ') ' . $stmt->error . '</h3>';
					echo '<h3 class="err">Unable to fetch drug list. Please contact database administrator.</h3>';
				}
				//generate a drop-down list for drug
				echo '<select name="id" id="druglist" class="required"><option value=""> ID, Trade Name (Generic Name) </option>';
				while ($stmt->fetch()) {
					echo '<option value="' . htmlspecialchars($id) . '">' . htmlspecialchars($id) . ' ' . htmlspecialchars($trade_name) . ' (' . htmlspecialchars($generic_name) . ')' . '</option>';
				}
				echo '</select>';
			?>
			<p>
			<input type="button" id="button4" value="Submit" onclick="q4();"><p>
		</div>
	</form>
</fieldset>
<br>
</div>

<!--SQL INSERT patient-->
<div>
<fieldset>
	<legend style = "text-align:center;"><b>Add New Entry to Database</b></legend>
	<br>

	<input type="radio" name="radio" class="radio" id="i5" value="i5" onclick="hide_all();show('opt5')"> 
	<span class="hand" onclick="hide_all();show('opt5')">
		 Add new patient 
	</span><p>
	<form class="myform" id="form5" method="POST">
		<div class="hide" id="opt5">
			First Name: 
			<input type="text" name="new_patient_first_name" id="new_patient_first_name" maxlength="20" size="20" minlength="2" class="required">
			<p>
			Last Name: 
			<input type="text" name="new_patient_last_name" id="new_patient_last_name" maxlength="20" size="20" minlength="2" class="required">
			<p>
			Social Security Number: 
			<input type="text" name="ssn" id="ssn" maxlength="11" size="11" placeholder="000-00-0000" minlength="11" class="required">
			<p>
			Date of Birth: 
			<input type="text" name="dob" id="dob" maxlength="10" size="10" placeholder="yyyy-mm-dd" minlength="10" class="dateISO required"> 
			<p>
			Sex:
			<select name="sex" id="sex">
				<option value="M">M</option>
				<option value="F">F</option>
			</select>
			<p>
			Address: 
			<input type="text" name="address" id="address" maxlength="20" size="20" minlength="5" class="required">
			<p>
			City: 
			<input type="text" name="city" id="city" maxlength="20" size="20" minlength="2" class="required">
			<p>
			State: 
			<select name="state" id="state" class="required">
				<option value="">--- Please Select ---</option>
				<option value="AL">Alabama</option>
				<option value="AK">Alaska</option>
				<option value="AZ">Arizona</option>
				<option value="AR">Arkansas</option>
				<option value="CA">California</option>
				<option value="CO">Colorado</option>
				<option value="CT">Connecticut</option>
				<option value="DE">Delaware</option>
				<option value="DC">District Of Columbia</option>
				<option value="FL">Florida</option>
				<option value="GA">Georgia</option>
				<option value="HI">Hawaii</option>
				<option value="ID">Idaho</option>
				<option value="IL">Illinois</option>
				<option value="IN">Indiana</option>
				<option value="IA">Iowa</option>
				<option value="KS">Kansas</option>
				<option value="KY">Kentucky</option>
				<option value="LA">Louisiana</option>
				<option value="ME">Maine</option>
				<option value="MD">Maryland</option>
				<option value="MA">Massachusetts</option>
				<option value="MI">Michigan</option>
				<option value="MN">Minnesota</option>
				<option value="MS">Mississippi</option>
				<option value="MO">Missouri</option>
				<option value="MT">Montana</option>
				<option value="NE">Nebraska</option>
				<option value="NV">Nevada</option>
				<option value="NH">New Hampshire</option>
				<option value="NJ">New Jersey</option>
				<option value="NM">New Mexico</option>
				<option value="NY">New York</option>
				<option value="NC">North Carolina</option>
				<option value="ND">North Dakota</option>
				<option value="OH">Ohio</option>
				<option value="OK">Oklahoma</option>
				<option value="OR">Oregon</option>
				<option value="PA">Pennsylvania</option>
				<option value="RI">Rhode Island</option>
				<option value="SC">South Carolina</option>
				<option value="SD">South Dakota</option>
				<option value="TN">Tennessee</option>
				<option value="TX">Texas</option>
				<option value="UT">Utah</option>
				<option value="VT">Vermont</option>
				<option value="VA">Virginia</option>
				<option value="WA">Washington</option>
				<option value="WV">West Virginia</option>
				<option value="WI">Wisconsin</option>
				<option value="WY">Wyoming</option>
			</select>
			<p>
			Zip Code: 
			<input type="text" name="zip_code" id="zip_code" maxlength="5" size="5" minlength="5" class="digits required">
			<p>
			Phone: 
			<input type="text" name="phone" id="phone" maxlength="12" size="12" placeholder="000-000-0000" minlength="12" class="required">
			<p>
			<input type="button" id="button5" value="Add" onclick="q5();"><p>
		</div>
	</form>

	<input type="radio" name="radio" class="radio" id="i6" value="i6" onclick="hide_all();show('opt6')"> 
	<span class="hand" onclick="hide_all();show('opt6')">
		 Add new patient-disease relationship information 
	</span><p>
	<form class="myform" id="form6" method="POST">
		<div class="hide" id="opt6">
			Patient:
			<?php
				//fetch data for patient
				$q="SELECT p.id AS `Patient ID`, p.first_name AS `First Name`, p.last_name AS `Last Name` FROM _patient AS p INNER JOIN _doctor AS d ON p.doctor_id=d.id WHERE d.first_name='".$_SESSION['first_name']."' AND d.last_name='".$_SESSION['last_name']."'";
				if (!($stmt = $mysqli->prepare($q))) {
					//echo '<h3 class="err">Prepare failed: (' . $stmt->errno . ') ' . $stmt->error . '</h3>';
					echo '<h3 class="err">Unable to fetch patient list. Please contact database administrator.</h3>';
				}
				if (!$stmt->execute()) {
					//echo '<h3 class="err">Execute failed: (' . $stmt->errno . ') ' . $stmt->error . '</h3>';
					echo '<h3 class="err">Unable to fetch patient list. Please contact database administrator.</h3>';
				}
				if (!$stmt->bind_result($id, $first_name, $last_name)){
					//echo '<h3 class="err">Binding failed: (' . $stmt->errno . ') ' . $stmt->error . '</h3>';
					echo '<h3 class="err">Unable to fetch patient list. Please contact database administrator.</h3>';
				}
				//generate a drop-down list for patient
				echo '<select name="patient_id" id="patient6" class="required"><option value=""> ID, First Name, Last Name </option>';
				while ($stmt->fetch()) {
					echo '<option value="' . htmlspecialchars($id) . '">' . htmlspecialchars($id) . ' ' . htmlspecialchars($first_name) . ' ' . htmlspecialchars($last_name) . '</option>';
				}
				echo '</select>';
			?>
			<p>
			Disease:
			<?php
				//fetch data for disease
				$q='SELECT id AS `ID`, name AS `Disease Name` FROM _disease ORDER BY id;';
				if (!($stmt = $mysqli->prepare($q))) {
					//echo '<h3 class="err">Prepare failed: (' . $stmt->errno . ') ' . $stmt->error . '</h3>';
					echo '<h3 class="err">Unable to fetch disease list. Please contact database administrator.</h3>';
				}
				if (!$stmt->execute()) {
					//echo '<h3 class="err">Execute failed: (' . $stmt->errno . ') ' . $stmt->error . '</h3>';
					echo '<h3 class="err">Unable to fetch disease list. Please contact database administrator.</h3>';
				}
				if (!$stmt->bind_result($id, $name)){
					//echo '<h3 class="err">Binding failed: (' . $stmt->errno . ') ' . $stmt->error . '</h3>';
					echo '<h3 class="err">Unable to fetch disease list. Please contact database administrator.</h3>';
				}
				//generate a drop-down list for disease
				echo '<select name="disease_id" id="disease6" class="required"><option value=""> ID, Disease Name </option>';
				while ($stmt->fetch()) {
					echo '<option value="' . htmlspecialchars($id) . '">' . htmlspecialchars($id) . ' ' . htmlspecialchars($name) . '</option>';
				}
				echo '</select>';
			?>
			<p>
			Diagnosis Date: 
			<input type="text" name="diagnosis_date" id="diagnosis_date" maxlength="10" size="10" placeholder="yyyy-mm-dd" minlength="10" class="dateISO required"> 
			<p>
			<input type="button" id="button6" value="Add" onclick="q6();"><p>
		</div>
	</form>
	
	<input type="radio" name="radio" class="radio" id="i7" value="i7" onclick="hide_all();show('opt7')"> 
	<span class="hand" onclick="hide_all();show('opt7')">
		 Add new patient-drug relationship information 
	</span><p>
	<form class="myform" id="form7" method="POST">
		<div class="hide" id="opt7">
			Patient:
			<?php
				//fetch data for patient
				$q="SELECT p.id AS `Patient ID`, p.first_name AS `First Name`, p.last_name AS `Last Name` FROM _patient AS p INNER JOIN _doctor AS d ON p.doctor_id=d.id WHERE d.first_name='".$_SESSION['first_name']."' AND d.last_name='".$_SESSION['last_name']."'";
				if (!($stmt = $mysqli->prepare($q))) {
					//echo '<h3 class="err">Prepare failed: (' . $stmt->errno . ') ' . $stmt->error . '</h3>';
					echo '<h3 class="err">Unable to fetch patient list. Please contact database administrator.</h3>';
				}
				if (!$stmt->execute()) {
					//echo '<h3 class="err">Execute failed: (' . $stmt->errno . ') ' . $stmt->error . '</h3>';
					echo '<h3 class="err">Unable to fetch patient list. Please contact database administrator.</h3>';
				}
				if (!$stmt->bind_result($id, $first_name, $last_name)){
					//echo '<h3 class="err">Binding failed: (' . $stmt->errno . ') ' . $stmt->error . '</h3>';
					echo '<h3 class="err">Unable to fetch patient list. Please contact database administrator.</h3>';
				}
				//generate a drop-down list for patient
				echo '<select name="patient_id" id="patient7" class="required"><option value=""> ID, First Name, Last Name </option>';
				while ($stmt->fetch()) {
					echo '<option value="' . htmlspecialchars($id) . '">' . htmlspecialchars($id) . ' ' . htmlspecialchars($first_name) . ' ' . htmlspecialchars($last_name) . '</option>';
				}
				echo '</select>';
			?>
			<p>
			Drug:
			<?php
				//fetch data for drug
				$q='SELECT id AS `ID`, trade_name AS `Trade Name`, generic_name AS `Generic Name` FROM _drug ORDER BY id;';
				if (!($stmt = $mysqli->prepare($q))) {
					//echo '<h3 class="err">Prepare failed: (' . $stmt->errno . ') ' . $stmt->error . '</h3>';
					echo '<h3 class="err">Unable to fetch drug list. Please contact database administrator.</h3>';
				}
				if (!$stmt->execute()) {
					//echo '<h3 class="err">Execute failed: (' . $stmt->errno . ') ' . $stmt->error . '</h3>';
					echo '<h3 class="err">Unable to fetch drug list. Please contact database administrator.</h3>';
				}
				if (!$stmt->bind_result($id, $trade_name, $generic_name)){
					//echo '<h3 class="err">Binding failed: (' . $stmt->errno . ') ' . $stmt->error . '</h3>';
					echo '<h3 class="err">Unable to fetch drug list. Please contact database administrator.</h3>';
				}
				//generate a drop-down list for drug
				echo '<select name="drug_id" id="drug7" class="required"><option value=""> ID, Trade Name (Generic Name) </option>';
				while ($stmt->fetch()) {
					echo '<option value="' . htmlspecialchars($id) . '">' . htmlspecialchars($id) . ' ' . htmlspecialchars($trade_name) . ' (' . htmlspecialchars($generic_name) . ')' . '</option>';
				}
				echo '</select>';
			?>
			<p>
			Start Date: 
			<input type="text" name="start_date" id="start_date" maxlength="10" size="10" placeholder="yyyy-mm-dd" minlength="10" class="dateISO required"> 
			<p>
			<input type="button" id="button7" value="Add" onclick="q7();"><p>
		</div>
	</form>
</fieldset>
<br>
</div>

<!--SQL UPDATE patient-->
<div>
<fieldset>
	<legend style = "text-align:center;"><b>Update Patient Information</b></legend>
	<br>
	<input type="radio" name="radio" class="radio" id="update" value="update" onclick="hide_all();show('opt8')">
	<span class="hand" onclick="hide_all();show('opt8')">
		 Update patient contact information
	</span>
	<form class="myform" id="form8" method="POST">
		<div class="hide" id="opt8">
			<p> 
			Patient: 
			<?php
				//fetch data for patient
				$q="SELECT p.id AS `Patient ID`, p.first_name AS `First Name`, p.last_name AS `Last Name` FROM _patient AS p INNER JOIN _doctor AS d ON p.doctor_id=d.id WHERE d.first_name='".$_SESSION['first_name']."' AND d.last_name='".$_SESSION['last_name']."'";
				if (!($stmt = $mysqli->prepare($q))) {
					//echo '<h3 class="err">Prepare failed: (' . $stmt->errno . ') ' . $stmt->error . '</h3>';
					echo '<h3 class="err">Unable to fetch patient list. Please contact database administrator.</h3>';
				}
				if (!$stmt->execute()) {
					//echo '<h3 class="err">Execute failed: (' . $stmt->errno . ') ' . $stmt->error . '</h3>';
					echo '<h3 class="err">Unable to fetch patient list. Please contact database administrator.</h3>';
				}
				if (!$stmt->bind_result($id, $first_name, $last_name)){
					//echo '<h3 class="err">Binding failed: (' . $stmt->errno . ') ' . $stmt->error . '</h3>';
					echo '<h3 class="err">Unable to fetch patient list. Please contact database administrator.</h3>';
				}
				//generate a drop-down list for patient
				echo '<select name="patient_id" id="patient8" class="required"><option value=""> ID, First Name, Last Name </option>';
				while ($stmt->fetch()) {
					echo '<option value="' . htmlspecialchars($id) . '">' . htmlspecialchars($id) . ' ' . htmlspecialchars($first_name) . ' ' . htmlspecialchars($last_name) . '</option>';
				}
				echo '</select>';
			?>
			<p>
			New Address: 
			<input type="text" name="address" id="update_address" maxlength="20" size="20" minlength="5" class="required">
			<p>
			City: 
			<input type="text" name="city" id="update_city" maxlength="20" size="20" minlength="2" class="required">
			<p>
			State: 
			<select name="state" id="update_state" class="required">
				<option value="">--- Please Select ---</option>
				<option value="AL">Alabama</option>
				<option value="AK">Alaska</option>
				<option value="AZ">Arizona</option>
				<option value="AR">Arkansas</option>
				<option value="CA">California</option>
				<option value="CO">Colorado</option>
				<option value="CT">Connecticut</option>
				<option value="DE">Delaware</option>
				<option value="DC">District Of Columbia</option>
				<option value="FL">Florida</option>
				<option value="GA">Georgia</option>
				<option value="HI">Hawaii</option>
				<option value="ID">Idaho</option>
				<option value="IL">Illinois</option>
				<option value="IN">Indiana</option>
				<option value="IA">Iowa</option>
				<option value="KS">Kansas</option>
				<option value="KY">Kentucky</option>
				<option value="LA">Louisiana</option>
				<option value="ME">Maine</option>
				<option value="MD">Maryland</option>
				<option value="MA">Massachusetts</option>
				<option value="MI">Michigan</option>
				<option value="MN">Minnesota</option>
				<option value="MS">Mississippi</option>
				<option value="MO">Missouri</option>
				<option value="MT">Montana</option>
				<option value="NE">Nebraska</option>
				<option value="NV">Nevada</option>
				<option value="NH">New Hampshire</option>
				<option value="NJ">New Jersey</option>
				<option value="NM">New Mexico</option>
				<option value="NY">New York</option>
				<option value="NC">North Carolina</option>
				<option value="ND">North Dakota</option>
				<option value="OH">Ohio</option>
				<option value="OK">Oklahoma</option>
				<option value="OR">Oregon</option>
				<option value="PA">Pennsylvania</option>
				<option value="RI">Rhode Island</option>
				<option value="SC">South Carolina</option>
				<option value="SD">South Dakota</option>
				<option value="TN">Tennessee</option>
				<option value="TX">Texas</option>
				<option value="UT">Utah</option>
				<option value="VT">Vermont</option>
				<option value="VA">Virginia</option>
				<option value="WA">Washington</option>
				<option value="WV">West Virginia</option>
				<option value="WI">Wisconsin</option>
				<option value="WY">Wyoming</option>
			</select>
			<p>
			Zip Code: 
			<input type="text" name="zip_code" id="update_zip_code" maxlength="5" size="5" minlength="5" class="digits required"> 
			<p>
			Phone: 
			<input type="text" name="phone" id="update_phone" maxlength="12" size="12" placeholder="000-000-0000" minlength="12" class="required"> 
			<p>
			<input type="button" id="button8" value="Update" onclick="q8();"><br>
		</div>
	</form>
	<br>
</fieldset>
<br>
</div>

<!--SQL DELETE patient-->
<div>
<fieldset>
	<legend style = "text-align:center;"><b>Delete Patient Information</b></legend>
	<br>
	<input type="radio" name="radio" class="radio" id="delete" value="delete" onclick="hide_all();show('opt9')">
	<span class="hand" onclick="hide_all();show('opt9')">
		 Delete a patient from the database
	</span>
	<form class="myform" id="form9" method="POST">
		<div class="hide" id="opt9">
			<p>
			Patient: 
			<?php
				//fetch data for patient
				$q="SELECT p.id AS `Patient ID`, p.first_name AS `First Name`, p.last_name AS `Last Name` FROM _patient AS p INNER JOIN _doctor AS d ON p.doctor_id=d.id WHERE d.first_name='".$_SESSION['first_name']."' AND d.last_name='".$_SESSION['last_name']."'";
				if (!($stmt = $mysqli->prepare($q))) {
					//echo '<h3 class="err">Prepare failed: (' . $stmt->errno . ') ' . $stmt->error . '</h3>';
					echo '<h3 class="err">Unable to fetch patient list. Please contact database administrator.</h3>';
				}
				if (!$stmt->execute()) {
					//echo '<h3 class="err">Execute failed: (' . $stmt->errno . ') ' . $stmt->error . '</h3>';
					echo '<h3 class="err">Unable to fetch patient list. Please contact database administrator.</h3>';
				}
				if (!$stmt->bind_result($id, $first_name, $last_name)){
					//echo '<h3 class="err">Binding failed: (' . $stmt->errno . ') ' . $stmt->error . '</h3>';
					echo '<h3 class="err">Unable to fetch patient list. Please contact database administrator.</h3>';
				}
				//generate a drop-down list for patient
				echo '<select name="patient_id" id="patient9" class="required"><option value=""> ID, First Name, Last Name </option>';
				while ($stmt->fetch()) {
					echo '<option value="' . htmlspecialchars($id) . '">' . htmlspecialchars($id) . ' ' . htmlspecialchars($first_name) . ' ' . htmlspecialchars($last_name) . '</option>';
				}
				echo '</select>';
			?>
			<p>
			<input type="button" id="button9" value="Delete" onclick="q9();"><br>
		</div>
	</form>
	<br>
</fieldset>
<br>
</div>

<div class="ajaxresult" id="ajaxresult">

<?php
		echo '<h2 class="center"><u>List of all patients whose primary care physician is Dr. '.$_SESSION['last_name'].'</u></h2>';

		$q="SELECT p.id AS `Patient ID`, p.first_name AS `First Name`, p.last_name AS `Last Name`, p.ssn AS `SSN`, p.date_of_birth AS `Date of Birth`, p.sex AS `Sex`, p.phone AS `Phone` FROM _patient AS p INNER JOIN _doctor AS d ON p.doctor_id=d.id WHERE d.first_name='".$_SESSION['first_name']."' AND d.last_name='".$_SESSION['last_name']."'";

		if (!$result = $mysqli->query($q)) {
			//echo '<h3 class="err">Query failed: (' . $mysqli->errno . ') ' . $mysqli->error . '</h3>';
			echo '<h3 class="err">Database error. Please contact database administrator.</h3>';
		}
		else if ($result->num_rows==0) {
			echo '<h3 class="center">No record.</h3>';
		}
		else {
			//fetch data
			while ($row = $result->fetch_assoc()) {
				$data[] = $row;
			}
			$colNames = array_keys(reset($data));
			
			//generate a table
			echo '<table class="sortable"><tr>';
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
			if ($result->num_rows>1)
				echo '<h5 class="center">(The above table has clickable headers that sort the table by the clicked column.)</h5>'; 
		}
?>
</div>
<script type="text/javascript" src="formatter.js"></script>
<script type="text/javascript" src="formatter-pattern-9.js"></script>
</body>
</html>
<?php
	}
}
else {
	include('redirect.php');
}
?>

