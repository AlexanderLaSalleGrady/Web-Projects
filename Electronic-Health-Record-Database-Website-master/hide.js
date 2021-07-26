function show(id) {
	document.getElementById(id).style.display = "block";
}
function hide(id) {
	document.getElementById(id).style.display = "none";
}
function hide_all() {
	for (var i=1; i<=9; i++) {
		hide("opt" + i);
	}
} 