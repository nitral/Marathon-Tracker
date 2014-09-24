<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
<?php
$con=mysqli_connect("localhost","root","foxfixwagongun","marathon");
if(mysqli_connect_errno()) {
   echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
if(!empty($_POST['bibId']))
{
	$bib_id=$_POST['bibId'];
	$name=$_POST['name'];
	$college=$_POST['college'];
	$address=$_POST['address'];
	$email=$_POST['email'];
	$phno=$_POST['contact'];
	$dob=$_POST['dob'];
	$econtact_name=$_POST['econtactname'];
	$econtact_no=$_POST['econtact'];
	$allergy=$_POST['allergy'];
	$sex=$_POST['sex'];
	//$sex="----";
	$sql="INSERT INTO `participants` (`bibid`, `Name`, `sex`, `email`, `ph_no`, `dob`, `address`, `college`, `econtact_name`, `econtact`, `allergy`) VALUES ('$bib_id', '$name', '$sex', '$email', '$phno', '$dob', '$address', '$college', '$econtact_name', '$econtact_no', '$allergy')";
	if(!mysqli_query($con, $sql)) {
		die('Error: '.mysqli_error($con));
		echo "There was an error registering!<br>";
		echo "<a href=\"reg.html\">Click here to go back to registration page!</a>";
	}
	$sql="UPDATE `race_details` SET `racer_count`=`racer_count`+1 WHERE `name`='bosm'";
	if(!mysqli_query($con, $sql)) {
		die('Error: '.mysqli_error($con));
	}
	$result=mysqli_query($con,"SELECT `no_checkpoint` FROM `race_details` WHERE `name`='bosm'");
	$row = mysqli_fetch_array($result);
	$no_checkpoint=$row['no_checkpoint'];
	for($i=1; $i<=$no_checkpoint; $i++) {
		$sql="INSERT INTO `racers` (`bibid`, `checkpoint_id`, `status`, `lap1_time`, `lap2_time`) VALUES ('$bib_id', '$i', '0', '0', '0')";
		if(!mysqli_query($con, $sql)) {
			die('Error: '.mysqli_error($con));
		}
	}

	echo "Registration successful.\n";
	echo "<a href=\"reg.html\">Click here to go back to registration page!</a>";
}
echo "Data not received!<br>";
echo "<a href=\"reg.html\">Click here to go back to registration page!</a>";
// echo "<br>Entered data: <br>";
// echo "bibId: "+$bib_id+"<br>";
// echo "name: "+$name+"<br>";
// echo "sex: "+$sex+"<br>";
// echo "college: "+$college+"<br>";
// echo "address: "+$address+"<br>";
// echo "email: "+$email+"<br>";
// echo "Contact: "+$phno+"<br>";
// echo "dob: "+$dob+"<br>";
// echo "econtact_name: "+$econtact_name+"<br>";
// echo "econtact_no: "+$econtact_no+"<br>";
// echo "allergy: "+$allergy+"<br>";
mysqli_close($con);
?>
</body>
</html>