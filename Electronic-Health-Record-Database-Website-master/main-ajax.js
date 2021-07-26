var isNumber = /^[0-9]+$/; 
var isName = /^[a-z ,.-]+$/i;
var isAddress = /^[^!@#$%^&*'"?|\t\n\r\\\/]+$/;
var isDate = /((19|20)[0-9]{2})[\/-](0[13578]|1[02])[\/-](0[1-9]|[12][0-9]|3[01])|((19|20)[0-9]{2}[\/-](0[469]|11)[\/-](0[1-9]|[12][0-9]|30))|((19|20)[0-9]{2}[\/-](02)[\/-](0[1-9]|1[0-9]|2[0-8]))|((((19|20)(04|08|[2468][048]|[13579][26]))|2000)[\/-](02)[\/-]29)/;
	 
function q1() {

	var xhr = new XMLHttpRequest();

	var id = document.getElementById("patientlist").value;
	
	if ((isNumber.test(id)==true)&&(id.length==5)) {	
		document.getElementById("ajaxresult").innerHTML = "<p class='wait'>Submitting query, please wait ...</p>";		
		xhr.open("POST", 'q1.php', true);
		xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		var data = "id="+id;
		xhr.send(data);	
		xhr.onreadystatechange = function() {
			if (xhr.readyState == 4 && xhr.status == 200) {
				document.getElementById("ajaxresult").innerHTML = xhr.responseText;
			}
		}		
	}
	else {
		alert("Please select a patient.");
	}
}

function q2() {

	var xhr = new XMLHttpRequest();

	var before_after = document.getElementById("before_after").value;
	var date_of_birth = document.getElementById("date_of_birth").value;
	
	if (date_of_birth.length==10&&isDate.test(date_of_birth)==true) {
		document.getElementById("ajaxresult").innerHTML = "<p class='wait'>Submitting query, please wait ...</p>";		
		xhr.open("POST", 'q2.php', true);
		xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		var data = "before_after="+before_after+"&date_of_birth="+date_of_birth;
		xhr.send(data);	
		xhr.onreadystatechange = function() {
			if (xhr.readyState == 4 && xhr.status == 200) {
				document.getElementById("ajaxresult").innerHTML = xhr.responseText;
				var ajaxSortTableObject=document.getElementById("ajaxSortTable");
				sorttable.makeSortable(ajaxSortTableObject);
			}
		}		
	}
	else {
		alert("Please enter a valid date.");
	}
}

function q3() {

	var xhr = new XMLHttpRequest();

	var id = document.getElementById("diseaselist").value;
	
	if ((isNumber.test(id)==true)&&(id.length==3)) {	
		document.getElementById("ajaxresult").innerHTML = "<p class='wait'>Submitting query, please wait ...</p>";		
		xhr.open("POST", 'q3.php', true);
		xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		var data = "id="+id;
		xhr.send(data);	
		xhr.onreadystatechange = function() {
			if (xhr.readyState == 4 && xhr.status == 200) {
				document.getElementById("ajaxresult").innerHTML = xhr.responseText;
			}
		}		
	}
	else {
		alert("Please select a disease.");
	}
}

function q4() {

	var xhr = new XMLHttpRequest();

	var id = document.getElementById("druglist").value;
	
	if ((isNumber.test(id)==true)&&(id.length==3)) {	
		document.getElementById("ajaxresult").innerHTML = "<p class='wait'>Submitting query, please wait ...</p>";		
		xhr.open("POST", 'q4.php', true);
		xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		var data = "id="+id;
		xhr.send(data);	
		xhr.onreadystatechange = function() {
			if (xhr.readyState == 4 && xhr.status == 200) {
				document.getElementById("ajaxresult").innerHTML = xhr.responseText;
			}
		}		
	}
	else {
		alert("Please select a drug.");
	}
}

function q5() {

	var xhr = new XMLHttpRequest();

	var new_patient_first_name = document.getElementById("new_patient_first_name").value;
	var new_patient_last_name = document.getElementById("new_patient_last_name").value;
	var ssn = document.getElementById("ssn").value;
	var dob = document.getElementById("dob").value;
	var sex = document.getElementById("sex").value;
	var address = document.getElementById("address").value;
	var city = document.getElementById("city").value;
	var state = document.getElementById("state").value;
	var zip_code = document.getElementById("zip_code").value;
	var phone = document.getElementById("phone").value;	
	
	if (new_patient_first_name.length<=20&&new_patient_last_name.length<=20&&ssn.length==11&&dob.length==10&&sex.length==1&&address.length<=20&&city.length<=20&&state.length==2&&zip_code.length==5&&phone.length==12) {
		if (isName.test(new_patient_first_name)==false||isName.test(new_patient_last_name)==false) {
			alert("Please enter a valid name.");
		}
		else if (isDate.test(dob)==false) {
			alert("Please enter a valid date.");
		}
		else if (isAddress.test(address)==false||isAddress.test(city)==false) {
			alert("Please enter a valid address.");
		}
		else {
			document.getElementById("ajaxresult").innerHTML = "<p class='wait'>Submitting query, please wait ...</p>";		
			xhr.open("POST", 'q5.php', true);
			xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			var data = "new_patient_first_name="+new_patient_first_name+"&new_patient_last_name="+new_patient_last_name+"&ssn="+ssn+"&dob="+dob+"&sex="+sex+"&address="+address+"&city="+city+"&state="+state+"&zip_code="+zip_code+"&phone="+phone;
			xhr.send(data);	
			xhr.onreadystatechange = function() {
				if (xhr.readyState == 4 && xhr.status == 200) {
					document.getElementById("ajaxresult").innerHTML = xhr.responseText;
				}
			}
		}
	}
	else {
		alert("Please fill out the form completely.");
	}
}

function q6() {

	var xhr = new XMLHttpRequest();

	var patient_id = document.getElementById("patient6").value;
	var disease_id = document.getElementById("disease6").value;
	var diagnosis_date = document.getElementById("diagnosis_date").value;

	if ((isNumber.test(patient_id)==true)&&(patient_id.length==5)&&(isNumber.test(disease_id)==true)&&(disease_id.length==3)&&diagnosis_date.length==10) {
		if (isDate.test(diagnosis_date)==true) {
			document.getElementById("ajaxresult").innerHTML = "<p class='wait'>Submitting query, please wait ...</p>";		
			xhr.open("POST", 'q6.php', true);
			xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			var data = "patient_id="+patient_id+"&disease_id="+disease_id+"&diagnosis_date="+diagnosis_date;
			xhr.send(data);	
			xhr.onreadystatechange = function() {
				if (xhr.readyState == 4 && xhr.status == 200) {
					document.getElementById("ajaxresult").innerHTML = xhr.responseText;
				}
			}	
		}
		else {
			alert("Please enter a valid date.");
		}
	}
	else {
		alert("Please fill out the form completely.");
	}
}

function q7() {

	var xhr = new XMLHttpRequest();

	var patient_id = document.getElementById("patient7").value;
	var drug_id = document.getElementById("drug7").value;
	var start_date = document.getElementById("start_date").value;

	if ((isNumber.test(patient_id)==true)&&(patient_id.length==5)&&(isNumber.test(drug_id)==true)&&(drug_id.length==3)&&start_date.length==10) {
		if (isDate.test(start_date)==true) {
			document.getElementById("ajaxresult").innerHTML = "<p class='wait'>Submitting query, please wait ...</p>";		
			xhr.open("POST", 'q7.php', true);
			xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			var data = "patient_id="+patient_id+"&drug_id="+drug_id+"&start_date="+start_date;
			xhr.send(data);	
			xhr.onreadystatechange = function() {
				if (xhr.readyState == 4 && xhr.status == 200) {
					document.getElementById("ajaxresult").innerHTML = xhr.responseText;
				}
			}	
		}
		else {
			alert("Please enter a valid date.");
		}
	}
	else {
		alert("Please fill out the form completely.");
	}
}

function q8() {

	var xhr = new XMLHttpRequest();

	var id = document.getElementById("patient8").value;
	var update_address = document.getElementById("update_address").value;
	var update_city = document.getElementById("update_city").value;
	var update_state = document.getElementById("update_state").value;
	var update_zip_code = document.getElementById("update_zip_code").value;
	var update_phone = document.getElementById("update_phone").value;	

	if (isNumber.test(id)==true&&id.length==5&&update_address.length<=20&&update_city.length<=20&&update_state.length==2&&update_zip_code.length==5&&update_phone.length==12) {
		if (isAddress.test(update_address)==false||isAddress.test(update_city)==false) {
			alert("Please enter a valid address.");
		}
		else {
			document.getElementById("ajaxresult").innerHTML = "<p class='wait'>Submitting query, please wait ...</p>";		
			xhr.open("POST", 'q8.php', true);
			xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			var data = "id="+id+"&update_address="+update_address+"&update_city="+update_city+"&update_state="+update_state+"&update_zip_code="+update_zip_code+"&update_phone="+update_phone;
			xhr.send(data);	
			xhr.onreadystatechange = function() {
				if (xhr.readyState == 4 && xhr.status == 200) {
					document.getElementById("ajaxresult").innerHTML = xhr.responseText;
				}
			}		
		}
	}
	else {
		alert("Please fill out the form completely.");
	}
}

function q9() {

	var xhr = new XMLHttpRequest();

	var id = document.getElementById("patient9").value;

	if ((isNumber.test(id)==true)&&(id.length==5)) {	
		document.getElementById("ajaxresult").innerHTML = "<p class='wait'>Submitting query, please wait ...</p>";		
		xhr.open("POST", 'q9.php', true);
		xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		var data = "id="+id;
		xhr.send(data);	
		xhr.onreadystatechange = function() {
			if (xhr.readyState == 4 && xhr.status == 200) {
				document.getElementById("ajaxresult").innerHTML = xhr.responseText;
			}
		}		
	}
	else {
		alert("Please select a patient.");
	}
}