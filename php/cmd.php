<?php
require_once 'includes/input_verification.php';
require_once 'includes/connect.php';
require_once 'includes/var.php';
require_once 'includes/function.php'
?>
<?php
connect();
?>

<?php
/*
$i=session_start();
if(!$i){
	echo 'error in session contact admin'.'<br/>';
	redirect_to('../site.php');
}*/
?>

<?php
if(!empty($_POST['cmd']))
{
	$string = ($_POST['cmd']);
	$array = json_decode($_POST['cmd'], true);
	
	$query = "insert into `cmd_log` (`checkpoint_id`,`cmd`, `status`, `client_time`) values ('{$array['checkpointId']}', '{$string}', '{0}', '{$array['checkpointTime']}')";
	$query_run = mysql_query($query);
	if($query_run){}
	else
	{
		echo "error";
	}
	$flag = 0;
	
	$query = "select `race_status` from `race_details` where `name` = 'bosm'";
	$query_result = mysql_query($query);
	if($var = mysql_fetch_array($query_result))
	{
		if($var['race_status'] == 0)
			$flag = 1;
	}
	if($flag)
	{
		switch ($array['type'])
		{
			case 0: 
				sync_down($array);
				break;
			
			case 1:
				sync_up($array);
				break;
			
			case 2:	
				ping($array);
				break;
			
			case 3:
				check_racer($array);
				break;
			
			case 4:
				clear_all($array);
				break;
			
			case 5:
				all_plus($array);
				break;
			
			case 6:
				all_red($array);
				break;
				
			case 7:
				all_yellow($array);
				break;
			
			case 8:
				all_green($array);
				break;
			
			default:
				echo "fuck off";
		}
	}
	else
	{
		if($array['type'] == 2)	
				ping($array);
		else
			echo "error";
	}
}
?>