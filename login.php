<?php 
$servername = "localhost";
$dbusername = "root";
$dbpassword = "weshallovercomesomeday";
$dbname = "eMeter";

$name = $_GET["name"];
$password = $_GET["password"];

$res = array();

// Create connection
$conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
		
	$sql = 'SELECT `user_id` FROM `account` WHERE `name` = "'.$name.'" AND `password` = "'.$password.'";';
	
	$result = $conn->query($sql);

	if ($result->num_rows > 0) {
		//var_dump($result);		
		$conn->close();	
    	echo "./reading.html";
	}else{
		echo "no";
	}
?>