// User Interface Magic Values and Global Constants and Variables.

// User Interface Draw Functions.

// User Interface Time Increment.

function initDrawUI() {
	for(var i = 1; i <= localStorage.getItem("numberOfRacers"); i++) {
		colorButton(i);
	}
}

function redrawUI() {
	redrawButtons();
	
	drawTimeCounter();
}

function redrawButtons() {
	for(var i = 1; i <= localStorage.getItem("numberOfRacers"); i++) {
		colorButton(i);
	}
}

function colorButton(buttonId) {
	var racerState = localStorage.getItem("racerStatus" + buttonId);
	if(racerState == "0") {
		document.getElementById(buttonId).style.backgroundColor = "red";
	} else if (racerState == "1") {
		document.getElementById(buttonId).style.backgroundColor = "yellow";
	} else {
		document.getElementById(buttonId).style.backgroundColor = "green";
	}
}

function drawTimeCounter() {
	var currentDate = new Date();
	var startDate = new Date(startTime);
	
	document.getElementById("current-time").innerHTML = currentDate.toUTCString();
	document.getElementById("start-time").innerHTML = startDate.toUTCString();
}

function showChecklistView() {
	document.getElementById("start-race-page").style.display = "none";
	document.getElementById("racers-buttons-grid").style.display = "block";
	document.getElementById("print-page").style.display = "none";
}