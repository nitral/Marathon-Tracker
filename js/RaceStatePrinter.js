// Race State Printer

// Race State Printer Magic Values, Global Constants and Variables.

// Functions to get data from Local Storage Database.
function getLocalStorageData() {
	var allData = {};
	allData.numberOfRacers = localStorage.getItem("numberOfRacers");
	allData.raceName = localStorage.getItem("raceName");
	allData.raceStatus = localStorage.getItem("raceStatus");
	allData.startTime = startTime;
	// Prepare Data JSON Object
	var data = [];
	for(var i = 0; i <= localStorage.getItem("numberOfRacers"); i++) {
		data[i] = {"status" : localStorage.getItem("racerStatus" + i), "lap1Time" : localStorage.getItem("racer" + i + "Lap1Time"), "lap2Time" : localStorage.getItem("racer" + i + "Lap2Time")};
	}
	allData.runnersData = data;
	
	return allData;
}

// Printer UI Functions.
function printLocalStorage() {
	var allLocalData = getLocalStorageData();
	
	// Make UI Changes on print-page
	document.getElementById("local-storage-dump").innerHTML = JSON.stringify(allLocalData);
	document.getElementById("print-page").style.display = "block";
	document.getElementById("start-race-page").style.display = "none";
	document.getElementById("racers-buttons-grid").style.display = "none";
}