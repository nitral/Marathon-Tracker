// Command Operator

// Command Operator Magic Values and Global Constants and Variables.

/* Command Type Dictionary
SYNC_DOWN = 0
SYNC_UP = 1
PING = 2
CHECK_RACER = 3
CLEAR_ALL = 4
PLUS = 5
RED = 6
YELLOW = 7
GREEN = 8
*/

// Command Data Structure
function Command(checkpointId, checkpointTime, commandType, racerId, racerStatus, data) {
	this.checkpointId = checkpointId;
	this.checkpointTime = checkpointTime;
	this.type = commandType;
	this.racerId = racerId;
	this.racerStatus = racerStatus;
	this.data = data;
}

// Command Data Structure Methods
Command.prototype.getCheckpointId = function() {
	return this.checkpointId;
}

Command.prototype.getCheckpointTime = function() {
	return this.checkpointTime;
}

Command.prototype.getType = function() {
	return this.type;
}

Command.prototype.getRacerId = function() {
	return this.racerId;
}

Command.prototype.getRacerStatus = function() {
	return this.racerStatus;
}

Command.prototype.getData = function() {
	return this.data;
}

// Function Definitions.
function commandOperator() {
	var type = null;
	var racer = null;
	if (this.tagName == "BUTTON") {
		if (this.className == "racer-grid-button") {
			type = 3;
			racer = this.id;
		} else if (this.id == "sync-down-button") {
			type = 0;
		}
	} else if (this.tagName == "INPUT" && this.type == "text") {
		var inputValue = this.value;
		if (isNaN(inputValue)) {
			switch (inputValue) {
				case "!*clear-all":
					type = 4;
					break;
				case "!*plus":
					type = 5;
					break;
				case "!*red":
					type = 6;
					break;
				case "!*yellow":
					type = 7;
					break;
				case "!*green":
					type = 8;
					break;
			}
		} else {
			type = 3;
			racer = inputValue;
		}
	}
	
	// Call Local Storage Mutator Functions.
	switch (type) {
		case 3:
			checkRacer(racer);
			break;
		case 4:
			purgeLocalStorage();
			break;
		case 5:
			incrementAllRacerStates();
			break;
		case 6:
			checkAllRed();
			break;
		case 7:
			checkAllYellow();
			break;
		case 8:
			checkAllGreen();
			break;
	}
	
	// Call Command Parcel and En-queueing function.
	parcelCommand(type, racer, null);
}

function checkRacer(racer) {
	var currentDate = new Date();
	var lapTime = currentDate.getTime();
	var currentStatus = localStorage.getItem("racerStatus" + racer);
	var newStatus = (currentStatus + 1) % 3;
	localStorage.setItem("racerStatus" + racer, newStatus);
	localStorage.setItem("racer" + racer + "Lap1Time", lapTime);
	
	// Make UI Changes.
	// Append Log on Log Console
	logConsole.append("Racer ID = " + racer + " Locally Checked!");
}

function purgeLocalStorage() {
	startTime = 0;
	localStorage.setItem("raceStatus", 0);
	for(var i = 1; i <= localStorage.getItem("numberOfRacers"); i++) {
		localStorage.setItem("racerStatus" + i, 0);
		localStorage.setItem("racer" + i + "Lap1Time", 0);
		localStorage.setItem("racer" + i + "Lap2Time", 0);
	}
	localStorage.setItem("numberOfRacers", 0);
	
	// Make UI Changes.
	// Append Log on Log Console
	logConsole.append("Local Storage Purged!");
}

function incrementAllRacerStates() {
	for(var i = 1; i <= localStorage.getItem("numberOfRacers"); i++) {
		var currentState = localStorage.getItem("racerStatus" + i);
		var newState = (currentState + 1) % 3;
		var currentDate = new Date();
		var lapTime = currentDate.getTime();
		localStorage.setItem("racerStatus" + i, newState);
		localStorage.setItem("racer" + i + "Lap" + newState + "Time", lapTime);
	}
	// Make UI Changes.
	// Append Log on Log Console
	logConsole.append("All Racers' Statuses Incremented Locally!");
}

function checkAllRed() {
	for(var i = 1; i <= localStorage.getItem("numberOfRacers"); i++) {
		localStorage.setItem("racerStatus" + i, 0);
	}
	// Make UI Changes.
	// Append Log on Log Console
	logConsole.append("All Racers' Statuses Forced to Red Locally!");
}

function checkAllYellow() {
	for(var i = 1; i <= localStorage.getItem("numberOfRacers"); i++) {
		var currentDate = new Date();
		var lapTime = currentDate.getTime();
		localStorage.setItem("racerStatus" + i, 1);
		localStorage.setItem("racer" + i + "Lap1Time", lapTime);
	}
	// Make UI Changes.
	// Append Log on Log Console
	logConsole.append("All Racers' Statuses Forced to Yellow Locally!");
}

function checkAllGreen() {
	for(var i = 1; i <= localStorage.getItem("numberOfRacers"); i++) {
		var currentDate = new Date();
		var lapTime = currentDate.getTime();
		localStorage.setItem("racerStatus" + i, 2);
		localStorage.setItem("racer" + i + "Lap2Time", lapTime);
	}
	// Make UI Changes.
	// Append Log on Log Console
	logConsole.append("All Racers' Statuses Forced to Green Locally!");
}

function parcelCommand(type, racer, data) {
	var currentDate = new Date();
	var currentTime = currentDate.getTime();
	var command = new Command(checkpointId, currentTime, type, racer, localStorage.getItem("racerStatus" + racer), data);
	
	commandQueue.add(command);
	
	// Append Log on Log Console
	logConsole.append("Command Type ID = " + command.type + " ID = " + currentTime + " Queued!");
}

function pingServer() {
	var currentDate = new Date();
	var currentTime = currentDate.getTime();
	parcelCommand(2, null, null);
	// Append Log on Log Console
	logConsole.append("Server Ping Request Appended to Command Queue!");
}

function applySync() {
	if(SYNC_DOWN_DATA == "") {
		return;
	}
	
	// Retrieve and parse SYNC_DOWN_DATA.
	var syncData = JSON.parse(SYNC_DOWN_DATA);
	
	// Apply parsed data.
	
	// Apply Race Details
	// Apply Name
	localStorage.setItem("raceName", syncData.raceDetails.name);
	// Apply Number of Racers
	localStorage.setItem("numberOfRacers", syncData.raceDetails.racers);
	// Apply Race Status
	localStorage.setItem("raceStatus", syncData.raceDetails.raceStatus);
	
	// Apply Checkpoints Details
	// Apply Start Time
	startTime = syncData.checkpointDetails.startTime;
	
	// Apply Runners Data
	// Loop through all numberOfRacers records in syncData and apply to LocalStorage
	for(var i = 1; i <= localStorage.getItem("numberOfRacers"); i++) {
		localStorage.setItem("racerStatus" + i, syncData.runner[i].status);
		localStorage.setItem("racer" + i + "Lap1Time", syncData.runner[i].lap1Time);
		localStorage.setItem("racer" + i + "Lap2Time", syncData.runner[i].lap2Time);
	}
	
	// Append Log on Log Console
	logConsole.append("Latest Downloaded Sync Data Applied!");
}

function syncUp() {
	// Prepare Data JSON Object
	var data = {};
	for(var i = 1; i <= localStorage.getItem("numberOfRacers"); i++) {
		data[i].status = localStorage.getItem("racerStatus" + i);
		data[i].lap1Time = localStorage.getItem("racer" + i + "Lap1Time");
		data[i].lap2Time = localStorage.getItem("racer" + i + "Lap2Time");
	}
	
	// Parcel and Send
	var currentDate = new Date();
	var currentTime = currentDate.getTime();
	parcelCommand(1, null, data);
	
	// Append Log on Log Console
	logConsole.append("Server Sync-Up Request Queued!");
}

/* Function Skeleton:-
function commandXYZ(params) {
	
	// Execute command on local memory/storage.
	
	// Write on LogConsole.
	
	// Make changes to UI.
}
*/