<?php
//input:- nothing
//output:- nothing
//anything else:- error due to improper input or some other cause
?>


<?php
require_once 'php/includes/input_verification.php';

$i=session_start();
if(!$i){
	echo 'error in session contact admin'.'<br/>';
	redirect_to('./index.php');
}
?>

<?php
	session_destroy();
	echo "You are logged out...";
	redirect_to('./index.php?q=1');
?>