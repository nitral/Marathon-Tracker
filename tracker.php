<!DOCTYPE html>
<html>
<head>
	<title>BITS Firefox Community Marathon Tracking System - Tracker</title>
	<!-- Include Javascript Files -->
	<script type="text/javascript" src="./js/custom.js"></script>
	<script type="text/javascript" src="./js/CommandOperator.js"></script>
	<script type="text/javascript" src="./js/CommandPostman.js"></script>
	<script type="text/javascript" src="./js/CommandQueue.js"></script>
	<script type="text/javascript" src="./js/LogConsole.js"></script>
	<script type="text/javascript" src="./js/ui.js"></script>
	<script type="text/javascript" src="./js/RaceStatePrinter.js"></script>
	
	<!-- Include Cascading Style Sheets -->
	<link rel="stylesheet" type="text/css" href="./css/tracker_style.css">
</head>
<body>
	<span id="checkpoint-id-holder"><!-- php to echo checkpoint ID after validation here --></span>

	<div id='left-wrapper'>
		<header>
			<section id = "heading-title">
				BITS Firefox Community - Marathon Tracking System
			</section>
			
			
		</header>
		
		<section id = "racers-buttons-grid">
			<!-- php to enumerate buttons grid -->
			<!-- Button's ID should be the racer ID it corresponds to -->
			<!-- Button's class name should be racer-grid-button -->
			RACERS BUTTONS GRID
		</section>
		
		<section id = "command-line">
			<input type = "text" id = "command-line-prompt" />
			<button id = "sync-down-button">Sync Down</button>
			<button id = "apply-sync-button">Apply Sync</button>
			<button id = "sync-up-button">Sync Up</button>
			<button id = "print-button">Print</button>
		</section>
	</div>
	
	<div id = 'right-wrapper'>
		<header id = "start-time-display">
			START TIME: <span id = "start-time">123 123 123</span>
		</header>
		<h3 id = "log-terminal-heading">Log Terminal</h3>
		<section id = "log-terminal">
		</section>
	</div>
	
	<footer>
		&copy; BITS Firefox Community
	</footer>
</body>
</html>