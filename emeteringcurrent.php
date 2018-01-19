<?php 
$servername = "localhost";
$dbusername = "root";
$dbpassword = "weshallovercomesomeday";
$dbname = "eMeter";

$res = array();

// Create connection
$conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
	
$sql = 'SELECT `Unit`, MAX(`Reading`) AS "Reading" FROM `readings` WHERE `Remarks` = "R"  GROUP BY `Unit`;';

$result = $conn->query($sql);

if ($result->num_rows > 0) {
	//var_dump($result);		
	while($row = $result->fetch_assoc()) {
		$res[] = $row;        	
	}
	
}

$conn->close();
echo json_encode($res);

?>