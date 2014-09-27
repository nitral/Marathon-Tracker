// Race State Printer

// Race State Printer Magic Values, Global Constants and Variables.

// Functions to get data from Local Storage Database.
function getLocalStorageData() {
	var allData = {};
	allData.numberOfRacers = document.getElementsByClassName("racer-grid-button").length;
	allData.raceName = localStorage.getItem("raceName");
	allData.raceStatus = localStorage.getItem("raceStatus");
	allData.startTime = startTime;
	// Prepare Data JSON Object
	var data = [];
	for(var i = 0; i < document.getElementsByClassName("racer-grid-button").length; i++) {
		var currentRacerId = document.getElementsByClassName("racer-grid-button")[i].id;
		data[i] = {"racerId": currentRacerId, "status" : localStorage.getItem("racerStatus" + currentRacerId), "lap1Time" : localStorage.getItem("racer" + currentRacerId + "Lap1Time"), "lap2Time" : localStorage.getItem("racer" + currentRacerId + "Lap2Time")};
	}
	allData.runnersData = data;
	
	return allData;
}

// Printer UI Functions.
function printLocalStorage() {
	var allLocalData = getLocalStorageData();
	
	// Make UI Changes on print-page
	document.getElementById("local-storage-dump").innerHTML = JSON.stringify(allLocalData);
	showPrintPageView();
}