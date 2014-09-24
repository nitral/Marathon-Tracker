// Magic Values and Global Constants and Variables.
var SYNC_DOWN_DATA = "";
var startTime = 0;
var startDate = new Date();
var PING_INTERVAL = 10000;
var POSTMAN_INTERVAL = 2000;
var checkpointId = -1;

// Environment Objects Instantiation and Setup.
var commandQueue, logConsole, commandPostman;

// Event functions definitions.
window.onload = function() {
	// Fix Checkpoint ID
	checkpointId = parseInt(document.getElementById("checkpoint-id-holder").innerHTML);
	
	// Fix Preliminary Start Time
	startTime = startDate.getTime();

	// Fix Number of Racers
	localStorage.setItem("numberOfRacers", document.getElementById("numberOfRacers-holder").innerHTML);
	
	// Fix Initial Race Status as 1
	localStorage.setItem("raceStatus", 1);
	
	commandQueue = new CommandQueue();
	logConsole = new LogConsole(document.getElementById("log-terminal"));
	commandPostman = new CommandPostman(logConsole, commandQueue);
	
	// Set TimeInterval Callback to Postman
	
	setInterval(function() {
		commandPostman.processQueue();
		}, POSTMAN_INTERVAL);

	// Set TimeInterval Callback to Ping Server
	setInterval(pingServer, PING_INTERVAL);
	
	pingServer();

	// Set TimeInterval Callback to Draw Time Counter
	setInterval(drawTimeCounter, 1000);
	
	// Event Listeners declarations.
	// Grid Buttons Click Event
	for(var i = 0; i < parseInt(localStorage.getItem("numberOfRacers")); i++) {
		document.getElementsByClassName("racer-grid-button")[i].addEventListener("click", commandOperator);
	}
	
	// Sync Up Event Listener
	document.getElementById("sync-up-button").addEventListener("click", syncUp);
	
	// Apply Sync Button Listener
	document.getElementById("apply-sync-button").addEventListener("click", applySync);
	
	// Sync Down Event Listener
	document.getElementById("sync-down-button").addEventListener("click", commandOperator);
	
	// Command Line Issue Event Listener
	document.getElementById("command-line-prompt").addEventListener("keyup", 
		function() {
			if(event.keyCode == 13 || event.which == 13) {
				commandOperator.call(document.getElementById("command-line-prompt"));
				this.value = "";
			}
		}
	);
	
	// Printer Event Listener
	document.getElementById("print-button").addEventListener("click", printLocalStorage);
	
	// Force Start Button Event Listener
	document.getElementById("force-start-button").addEventListener("click", startRace);
	
	// Back to Checklist Event Listener
	document.getElementById("back-checklist-button").addEventListener("click", showChecklistView);
	
	// Initialize all Local Storage
	//initLocalStorage();
	
	// Draw Everything Once
	redrawUI();
}

function startRace() {
	document.getElementById("start-race-page").style.display = "none";
	document.getElementById("racers-buttons-grid").style.display = "block";
	document.getElementById("print-page").style.display = "none";
}

function initLocalStorage() {
	localStorage.setItem("raceStatus", 1);
	
	// Fix Number of Racers
	localStorage.setItem("numberOfRacers", document.getElementById("numberOfRacers-holder").innerHTML);
}