<?php
require_once 'php/includes/connect.php';
require_once 'php/includes/input_verification.php';
?>
<?php
	$i=session_start();
	if(!$i)
	{
		echo 'error in session contact admin'.'<br/>';
		redirect_to('./index.php');
	}
?>

<?php
	connect();
	global $butt_count;
	$query = "select `racer_count` from `race_details` where `name` = 'bosm'";
	$query_run = mysql_query($query);
	if($query_result = mysql_fetch_array($query_run))
	{
		$butt_count = $query_result['racer_count'];
	}
	else
	{
		die("server is dead");
	}
	
?>
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
	<!-- <span id="checkpoint-id-holder"><!-- php to echo checkpoint ID after validation here </span> -->
	<span id="checkpoint-id-holder" class='hidden_data'><?php echo $_SESSION['checkpointId'] ?></span>

	<div id='left-wrapper'>
		<header>
			<section id = "heading-title">
				BITS Firefox Community - Marathon Tracking System
			</section>
		</header>
		
		<section id = "start-race-page">
			<section>
				<h3 align="center">Welcome <span id="checkpoint-id-welcome"><?php echo $_SESSION['checkpointId'] ?></span></h3>
			</section>
			<div id = "start-page-heading">
				<h1>Waiting for the Start Signal from Server.</h1>
			</div>
			<button id = "force-start-button">
				Force Start Race!
			</button>
		</section>
		
		<section id = "racers-buttons-grid">
			<!-- php to enumerate buttons grid -->
			<!-- Button's ID should be the racer ID it corresponds to -->
			<!-- Button's class name should be racer-grid-button -->
			<?php
				global $butt_count;
				for($i=1;$i<=$butt_count;$i++)
				{
					echo "<button id = '{$i}' class = \"racer-grid-button\">{$i}</button>";
				}
				//<button id = "$racerID" class = "racer-grid-button">$racerID</button>
			?>
		</section>
		
		<section id = "print-page">
			<textarea id = "local-storage-dump"></textarea>
		</section>
		
		<section id = "command-line">
			<input type = "text" id = "command-line-prompt" />
			<button id = "sync-down-button">Sync Down</button>
			<button id = "apply-sync-button">Apply Sync</button>
			<button id = "sync-up-button">Sync Up</button>
			<button id = "print-button">Print</button>
			<button id = "back-checklist-button">Back to Checklist</button>
		</section>
	</div>
	
	<div id = 'right-wrapper'>
		<header id = "start-time-display">
			Start: <span id = "start-time">123 123 123</span>
			<br />
			Current: <span id = "current-time">123 123 123</span>
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