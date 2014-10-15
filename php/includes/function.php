<?php
/* Compulsory Input:- checkpointTime, checkpointId */
	
	/* In all the commands if getting status then its the new status */
	
	/* sends all the data back to the respective client in sorted order according to the time stamp */
	/* Method:- fetch all the queries corresponding to the client and add it to an array */
	/* Return Value:- a json object created using json_encode() on previously generated array */
	function sync_down($array)
	{
		$result = array();
		$runner = array();
		$raceDetail = array();
		$checkpointDetails = array();

		/* setting raceDetails array */
		$query = "select * from `race_details` where `name` = 'bosm'";
		$query_run = mysql_query($query);
		if($row = mysql_fetch_array($query_run))
		{
			$raceDetails['name'] = $row['name'];
			$raceDetails['racers'] = $row['racer_count'];
			$raceDetails['numberOfCheckmate'] = $row['no_checkpoint'];
			$raceDetails['raceStatus'] = $row['race_status'];
			$raceDetails['serverTime'] = $row['server_time'];
		}
		/* setting checkpointDetails array */
		$query = "select * from `checkpoints` where `checkpoint_id` = '{$array['checkpointId']}'";
		$query_run = mysql_query($query);
		if($row = mysql_fetch_array($query_run))
		{
			$checkpointDetails['checkpointId'] = $row['checkpoint_id'];
			$checkpointDetails['status'] = $row['status'];
			$checkpointDetails['startTime'] = $row['time_init'];
		}
		/* getting all racers details */
		$query = "select * from `racers` where checkpoint_id = '{$array['checkpointId']}'"; //order by `client_time` asc";
		$query_run = mysql_query($query);
		while($row = mysql_fetch_array($query_run))
		{
			$temp = array();
			$temp['status'] = $row['status'];
			$temp['lap1Time'] = $row['lap1_time'];
			$temp['lab2Time'] = $row['lap2_time'];
			$runner["{$row['bibid']}"] = $temp;
		}
		$result['checkpointDetails'] = $checkpointDetails;
		$result['raceDetails'] = $raceDetails;
		$result['runner'] = $runner;
		$result['commandStatus'] = 0;
		echo json_encode($result);
	}
	
	/* moves all the current client data to the backup table and inserts the given requests into the table */
	/* Method:- execute the queries on the respective client_name */
	/* Return Value:- 0:- for success. others for failure */
	function sync_up($array)
	{
		$sqlite_timestamp = date('Y-m-d H:i:s');

		$query = "select * from `racers` where `checkpoint_id` = '{$array['checkpointId']}'";
		$query_run = mysql_query($query);
		if($query_run)
		{
			while($row = mysql_fetch_array($query_run))
			{
				$q = "insert into `backup_runner` values ('{$row['checkpoint_id']}', '{$row['bibid']}', '{$row['lap1_time']}', '{$row['lap2_time']}', '{$row['status']}', '{$sqlite_timestamp}')";
				$q_run = mysql_query($q);
				if(!$q_run)
				{
					echo "we are fucked";
				}
			}
		}
		else
		{
			echo "error.";
		}
		
		$query = "delete from `racers` where `checkpoint_id` = '{$array['checkpointId']}'";
		$query_run = mysql_query($query);
		if(!$query_run)
		{
			echo "error";
		}
		$object = $array['data'];
		foreach ($object as $key => $value)
		{
			$query = "insert into `racers` values ('{$key}', '{$array['checkpointId']}', '{$value['status']}', '{$value['lap1Time']}', '{$value['lap2Time']}')";
			$query_run = mysql_query($query);
			if(!$query)
			{
				echo "we are fucked";
			}
		}
		
		$result = array();
		$result['commandStatus'] = 0;
		echo json_encode($result);
	}
	
	/* The last respond time in the database */
	/* Method:- updates the record in the database */
	/* Return Value:- numberOfRacers => number of user, raceStatus, startTime => starting time of the client. other for failure */
	function ping($array)
	{
		$result;
		$query = "select count(*) from `participants`";
		$query_run = mysql_query($query);
		if($temp = mysql_fetch_array($query_run))
		{
			$result['numberOfRacers'] = $temp[0];
			$query = "select `race_status` from `race_details` where `name` LIKE 'bosm'";
			$query_run = mysql_query($query);
			if($temp = mysql_fetch_array($query_run))
			{
				$result['raceStatus'] = $temp[0];
				$q = "select `time_init`, `server_init` from `checkpoints` where `checkpoint_id` = '{$array['checkpointId']}'";
				$q_run = mysql_query($q);
				if($temp = mysql_fetch_array($q_run))
				{
					if($temp['time_init'] == 0)
					{
						$time = microtime(true);
						$q = "update `checkpoints` set `time_init`='{$array['checkpointTime']}',`server_init`='{$time}' where `checkpoint_id` = '{$array['checkpointId']}'";
						$q_t = mysql_query($q);
						if($q_t)
						{
							//do nothing
						}
						else
						{
							echo "error";
						}
					}
					$result['startTime'] = $temp['time_init'];
					$result['commandStatus'] = 0;
					echo(json_encode($result));
				}
				else
				{
					print_r($result);
					echo 3;
					echo "error.";
				}
			}
			else
			{
				echo 2;
				echo "error.";
			}
		}
		else
		{
			echo 1;
			echo "error.";
		}
	}
	
	/* Increments the current status of the racer */
	/* Input:- bib_id, checkpoint_id, bib_status */
	/* Return:- 0=> Success, 1=> Failure */
	function check_racer($array)
	{
		$string = implode(" ", $array);
		$query = "insert into `cmd_log` values ('{$array['checkpointId']}', '{$string}}', '0', '{$array['checkpointTime']}')";
		$query_result = mysql_query($query);
		if($query_result)
		{
			if($array['racerStatus'] == 0)
			{
				$query = "update `racers` set `status` = 0 where `bibid` = '{$array['racerId']}' and `checkpoint_id` = '{$array['checkpointId']}' ";
			}
			else if($array['racerStatus'] == 1)
			{
				$query = "update `racers` set `status` = '{$array['racerStatus']}',`lap1_time` = '{$array['checkpointTime']}' where `bibid` = '{$array['racerId']}' and `checkpoint_id` = '{$array['checkpointId']}'";
			}
			else
			{
				$query = "update `racers` set `status` = '{$array['racerStatus']}',`lap2_time` = '{$array['checkpointTime']}' where `bibid` = '{$array['racerId']}' and `checkpoint_id` = '{$array['checkpointId']}'";
			}
			$query_result = mysql_query($query);
			confirm_query($query_result);
			if($query_result)
			{
				$result = array();
				$result['commandStatus'] = 0;
				echo json_encode($result);
			}
			else
			{
					echo "error";
			}
		}
		else
		{
			echo "error";
		}
	}	
	
	/* Sets all the client status to red and resets Tco */
	/* Input :- NULL */
	/* Output :- 0=> Success 1=> Failure */
	function clear_all($array)
	{
		$query = "select * from `racers` where `checkpoint_id` = '{$array['checkpointId']}'";
		$query_run = mysql_query($query);
		while($row = mysql_fetch_array($query_run))
		{
			$q = "update `racers` set `status` = 0 where `bibid` = '{$row['bibid']}'";
			$q_run = mysql_query($q);
			if(confirm_query($q_run))
			{
				echo "error";
				break;
			}
		}
		$result = array();
		$result['commandStatus'] = 0;
		
		$query = "update `checkpoints` set `time_init` = '{$array['checkpointTime']}' where `checkpoint_id` = '{$array['checkpointId']}'";
		$query_run = mysql_query($query);
		if($query_run)
		{
			$result = array();
			$result['commandStatus'] = 0;
			echo json_encode($result);
		}
		else
		{
			echo "error.\n";
		}
	}
	
	/* Increases the status of all the racers by 1 for the client */
	/* Input:- NULL */
	/* Output:- 0=> Success 1=> Failure */
	function all_plus($array)
	{
		$query = "select * from `racers` where `checkpoint_id` = '{$array['checkpointId']}'";
		$query_run = mysql_query($query);
		while($row = mysql_fetch_array($query_run))
		{
			$q = "update `racers` set `status` = (`status` + 1)%3 where `bibid` = '{$row['bibid']}'";
			$q_run = mysql_query($q);
			if(!$q_run)
			{
				
				echo "error";
				break;
			}
		}
		$result = array();
		$result['commandStatus'] = 0;
		echo json_encode($result);
	}
	
	/* Sets all the racers on the client to red */
	/* Input:- NULL */
	/* Output:- 0=> Success 1=> Failure */
	function all_red($array)
	{
		$query = "select * from `racers` where `checkpoint_id` = '{$array['checkpointId']}'";
		$query_run = mysql_query($query);
		while($row = mysql_fetch_array($query_run))
		{
			$q = "update `racers` set `status` = 0 where `bibid` = '{$row['bibid']}'";
			$q_run = mysql_query($q);
			if(confirm_query($q_run))
			{
				echo "error";
				break;
			}
		}
		$result = array();
		$result['commandStatus'] = 0;
		echo json_encode($result);
	}
	
	/* Sets all the racers on the client to yellow */
	/* Input:- NULL */
	/* Output:- 0=> Success 1=> Failure */
	function all_yellow($array)
	{
		$query = "select * from `racers` where `checkpoint_id` = '{$array['checkpointId']}'";
		$query_run = mysql_query($query);
		while($row = mysql_fetch_array($query_run))
		{
			$q = "update `racers` set `status` = 1 where `bibid` = '{$row['bibid']}'";
			$q_run = mysql_query($q);
			if(!$q_run)
			{
				echo "error";
				break;
			}
		}
		$result = array();
		$result['commandStatus'] = 0;
		echo json_encode($result);
	}
	
	/* Sets all the racers on the client to green */
	/* Input:- NULL */
	/* Output:- 0=> Success 1=> Failure */
	function all_green($array)
	{
		$query = "select * from `racers` where `checkpoint_id` = '{$array['checkpointId']}'";
		$query_run = mysql_query($query);
		while($row = mysql_fetch_array($query_run))
		{
			$q = "update `racers` set `status` = 2 where `bibid` = '{$row['bibid']}'";
			$q_run = mysql_query($q);
			if(!$q_run)
			{
				echo "error";
				break;
			}
		}
		$result = array();
		$result['commandStatus'] = 0;
		echo json_encode($result);
	}
?> 