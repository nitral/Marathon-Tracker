<?php 
	function connect(){
		$db = mysql_connect("localhost","root","foxfixwagongun");//900abhi622
		if(!$db){
			die("connection fail, error 101");
		}
		$db_c=mysql_select_db("marathon",$db);
		if(!$db_c){
			die("connection fails, error 102");
	}
}
?>