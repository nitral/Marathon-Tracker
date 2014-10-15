<?php
require_once '../includes/connect.php';

?>
<!DOCTYPE html>
<head>
	<meta charset="UTF-8">
    <title>MozaThon</title>
    <link rel="stylesheet" type="text/css" href="stylereg.css">
</head>
<body>
	<div class="container">
	<div id="top" align="center">
		MOZATHON 2k14
	</div>
	<div id="middle">

	<form  action="start_server.php"  method="post"> 
    	<h1 align="center">Server Access</h1>
        <fieldset>       
            <div class="module" align="center">
            <div class="form-group"> 
                <label for="Checkpoint_Id" class="checkpoint_Id" data-icon="u" >Admin ID:</label>
                <input autofocus class="form-control" name="adminId" type="text" placeholder="Admin Name"/>
            </div>
            <br>
            
            <div class="form-group"> 
                <label for="password" class="youpasswd" data-icon="p">Password:</label>
                <input class="form-control" name="password" type="password" placeholder="Password" /> 
            </div>
         
        
            <p class="Start Server"> 
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


<?php
connect();
if(isset($_POST['adminId']))
{
	$pass = 'SHA!';
	$admin = "host";
	$check = $_POST['password'];
	if($admin == $_POST['adminId'] && $pass == $check)
	{
		$query = "update `race_details` set `race_status` = '0' where `name` = 'bosm'";
		$query_run = mysql_query($query);
		if($query_run)
		{
			//echo "server started";
			$q = "select `checkpoint_id` from `checkpoints` where 1";
			$q_run = mysql_query($q);
			if($q_run)
			{
				while($row = mysql_fetch_array($q_run))
				{
					$q1 = "update `checkpoints` set `server_init` = '0', `time_init` = '0'";
					$q1_run = mysql_query($q1);
					if($q1_run)
					{
						
					}
					else
					{
						echo "error1";
					}
				}
				echo "YOU ARE THE TRUE ADMIN :P.<br/>";
						
				//update on  race_start ie server_time from race_details
				$time = microtime(true);
				$q2 = "update `race_details` set `server_time`='{$time}' where `name` = 'bosm'";
				$q2_run = mysql_query($q2);
				if($q2_run)
				{
					echo "GoGoGo";
				}
				else
				{
					echo "Error.";
				}
			}
			else
			{
				echo "error2";
			}
		}
		else
		{
			echo "failure";
		}
	}
}
?>
