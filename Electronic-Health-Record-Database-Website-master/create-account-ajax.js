function ajax2() {

	var xhr = new XMLHttpRequest();

	var fn = document.getElementById("first_name").value;
	var ln = document.getElementById("last_name").value;
	var u = document.getElementById("username").value;
	var p = document.getElementById("password").value;
	var p2 = document.getElementById("password2").value;
	
	var isAlphanumeric = /^[A-Za-z0-9]+$/; 
	var isName = /^[a-z ,.'-]+$/i; 
	
	if ((isName.test(fn)==true)&&(fn.length>=2)&&(isName.test(ln)==true)&&(ln.length>=2)&&(isAlphanumeric.test(u)==true)&&(u.length>=4)&&(isAlphanumeric.test(p)==true)&&(p.length>=8)&&(p==p2)) {	
		document.getElementById("message").innerHTML = "<p class='wait'>Creating account, please wait ...</p>";		
		xhr.open("POST", 'create-account.php', true);
		xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		var data = "username="+u+"&password="+p+"&first_name="+fn+"&last_name="+ln;
		xhr.send(data);	
		xhr.onreadystatechange = function() {
			if (xhr.readyState == 4 && xhr.status == 200) {
				document.getElementById("message").innerHTML = xhr.responseText;
			}
		}	
	}
} 