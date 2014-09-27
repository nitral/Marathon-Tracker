// Command Postman
var COMMAND_POSTMAN_URL = "./php/cmd.php";

// Command Postman Object Declaration.
	// Include instance of Log Console.
function CommandPostman(logConsole, commandQueue) {
	this.commandQueue = commandQueue;
	this.logConsole = logConsole;
	this.isLocked = false;
	this.lastCommand = "";
	this.lastCommandResponse = "";
	this.xmlhttp = "";
}

// Command Postman Object Methods Definition.
CommandPostman.prototype.sendCommand = function(command, successCallback, failureCallback) {
	console.log("Command Message = #" + JSON.stringify(command) + "#")
	if (window.XMLHttpRequest) {
		this.xmlhttp = new XMLHttpRequest();
	} else {
		this.xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
	}
	this.xmlhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			successCallback.call(commandPostman, command);
		} else if (this.readyState == 4 && this.status == 404) {
			failureCallback.call(commandPostman, command);
		}
	};
	this.xmlhttp.open("POST", COMMAND_POSTMAN_URL, true);
	this.xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	this.xmlhttp.send("cmd=" + JSON.stringify(command));
}

CommandPostman.prototype.getLastCommand = function() {
	return this.lastCommand;
}

CommandPostman.prototype.getLastCommandResponse = function() {
	return this.lastCommandResponse;
}

CommandPostman.prototype.manageSuccessResponse = function(command) {
	this.lastCommand = command;
	this.lastCommandResponse = this.xmlhttp.responseText.trim();
	console.log(this.lastCommandResponse);
	var responseData;
	try {
		responseData = JSON.parse(this.lastCommandResponse);
	} catch (e) {
		this.logConsole.append("Server Error: " + e.message);
		console.log("Command Type = " + this.lastCommand.type + " Response = #" + this.lastCommandResponse + "#");
	}
	
	if(command.type == 0) {
		SYNC_DOWN_DATA = this.lastCommandResponse;
	} else if (command.type == 2 && responseData != null) {
		if (responseData.raceStatus == "0" && localStorage.getItem("raceStatus") != "0") {
			startRace();
		} else if (responseData.raceStatus == "0" && localStorage.getItem("raceStatus") == "0" && onStartPageView()) {
			continueRace();
		}
		localStorage.setItem("raceStatus", responseData.raceStatus);
		startTime = responseData.startTime;
		localStorage.setItem("numberOfRacers", responseData.numberOfRacers);
	}
		
	this.pollCommandQueue();
	this.writeSuccessLog();
	this.isLocked = false;
}

CommandPostman.prototype.manageFailureResponse = function (command) {
	this.lastCommand = command;
	this.lastCommandResponse = null;
	
	this.logConsole.append("Command Type Code: " + this.lastCommand.type + " Failed to be sent!");
	this.isLocked = false;
}

CommandPostman.prototype.processQueue = function() {
	if(!this.isLocked && !commandQueue.isEmpty()) {
		var command = this.commandQueue.peek();
		this.isLocked = true;
		this.sendCommand(command, this.manageSuccessResponse, this.manageFailureResponse);
	}
}

CommandPostman.prototype.pollCommandQueue = function() {
	return commandQueue.poll();
}

// Command Postman Object Methods - Log Display.
CommandPostman.prototype.writeSuccessLog = function() {
	var responseData;
	try {
		responseData = JSON.parse(this.lastCommandResponse);
	} catch (e) {
		return ;
	}
	
	if(this.lastCommand.type == 2) {
		this.logConsole.append("Ping Successful! Race Status, Start Time and Number of Racers Synced.");
	} else {
		if(responseData.commandStatus == "0") {
			// Write Success Append Data using this.logConsole.append()
			this.logConsole.append("Command Type Code: " + this.lastCommand.type + " Successfully Accepted!" );
		} else {
			// Write Failure Append Data using this.logConsole.append()
			this.logConsole.append("Command Type Code: " + this.lastCommand.type + " Not Accepted!" );
		}
	}
}