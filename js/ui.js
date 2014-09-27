// User Interface Magic Values and Global Constants and Variables.

// User Interface Draw Functions.

// User Interface Time Increment.

function initDrawUI() {
	for(var i = 0; i < document.getElementsByClassName("racer-grid-button").length; i++) {
		var currentRacerId = document.getElementsByClassName("racer-grid-button")[i].id;
		colorButton(currentRacerId);
	}
}

function redrawUI() {
	redrawButtons();
	
	drawTimeCounter();
}

function redrawButtons() {
	for(var i = 0; i < document.getElementsByClassName("racer-grid-button").length; i++) {
		var currentRacerId = document.getElementsByClassName("racer-grid-button")[i].id;
		colorButton(currentRacerId);
	}
}

function colorButton(buttonId) {
	var racerState = localStorage.getItem("racerStatus" + buttonId);
	if(racerState == "0") {
		document.getElementById(buttonId).style.backgroundColor = "red";
	} else if (racerState == "1") {
		document.getElementById(buttonId).style.backgroundColor = "yellow";
	} else if (racerState == "2") {
		document.getElementById(buttonId).style.backgroundColor = "green";
	} else {
		document.getElementById(buttonId).style.backgroundColor = "blue";
	}
}

function drawTimeCounter() {
	var currentDate = new Date();
	var startDate = new Date();
	//startDate.setTime(startTime);
	
	document.getElementById("current-time").innerHTML = currentDate.toLocaleString();
	document.getElementById("start-time").innerHTML = startDate.toLocaleString();
}

function showChecklistView() {
	document.getElementById("start-race-page").style.display = "none";
	document.getElementById("racers-buttons-grid").style.display = "block";
	document.getElementById("print-page").style.display = "none";
}

function showPrintPageView() {
	document.getElementById("print-page").style.display = "block";
	document.getElementById("start-race-page").style.display = "none";
	document.getElementById("racers-buttons-grid").style.display = "none";
}

function onStartPageView() {
	if(document.getElementById("start-race-page").style.display != "none") {
		return true;
	} else {
		return false;
	}
}