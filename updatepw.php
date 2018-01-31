<?php 
$servername = "localhost";
$dbusername = "root";
$dbpassword = "weshallovercomesomeday";
$dbname = "eMeter";

$name = $_GET["name"];
$oldpassword = $_GET["oldpassword"];
$newpassword = $_GET["newpassword"];

$res = array();

// Create connection
$conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
		
	$sql = 'UPDATE `account` SET `password`= "'.$newpassword.'" WHERE `name` = "'.$name.'" AND `password` = "'.$oldpassword.'";';
	
	$result = $conn->query($sql);
	if ($result > 0) {
		//var_dump($result);		
		$conn->close();	
    	echo "./index.html";
	}else{
		echo "no";
	}
?>