<?php
require_once 'php/includes/connect.php';
require_once 'php/includes/input_verification.php';
?>

<?php
connect();
if(isset($_POST['checkpointId']))
{
	$query = "select *	from `checkpoints` where `checkpoint_id` = '{$_POST['checkpointId']}' and 'password' = '{$_POST['password']}'";
	$query_run = mysql_query($query);
	if($query_run)
	{
		echo "true";
		session_start();
		$q = "select `racer_count` from `race_details` where `name` = 'bosm'";
		$q_run = mysql_query($q);
		if($row = mysql_fetch_array($q_run))
		{
			$_SESSION['checkpointId'] = $_POST['checkpointId'];
			$_SESSION['numberOfRacers'] = $row['racer_count'];
			redirect_to('./tracker.php');
		}
		else
		{
			echo "no go";
			session_destroy();
		}
	}
	else
	{
		echo "false";
	}
	
}
?>


<!DOCTYPE html>
<head>
	<meta charset="UTF-8">
    <title>MozaThon</title>
    <link rel="stylesheet" type="text/css" href="stylelog.css">
</head>
<body>
	<div class="container">
	<div id="top" align="center">
		MOZATHON 2k14
	</div>
	<div id="middle">

	<form  action="index.php"  method="post"> 
    	<h1 align="center">Log in</h1>
        <fieldset>       
            <div class="module" align="center">
            <div class="form-group"> 
                <label for="Checkpoint_Id" class="checkpoint_Id" data-icon="u" >Checkpoint ID:</label>
                <input autofocus class="form-control" name="checkpointId" type="text" placeholder="Checkpoint Name"/>
            </div>
            <br>
            
            <div class="form-group"> 
                <label for="password" class="youpasswd" data-icon="p">Password:</label>
                <input class="form-control" name="password" type="password" placeholder="Password" /> 
            </div>
         
        
            <p class="login button"> 
               <input type="submit"/>
               <input type="reset"/>
               </p>
        </fieldset>
	</form>
	</div>
	<div id="bottom">
	</div>
    <div class="footer">Copyright</div>
    </div>
</body>
</html>