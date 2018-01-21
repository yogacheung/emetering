<?php 
$servername = "localhost";
$dbusername = "root";
$dbpassword = "weshallovercomesomeday";
$dbname = "eMeter";

$date = $_GET["date"];
$tlength = $_GET["tlength"];

$res = array();

// Create connection
$conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$enddate = $date;
$newdate = strtotime($enddate);
$startdate = date("Y-m-d", strtotime("-1 month", $newdate));

for($i=$tlength; $i>0; $i--){		
	//echo $startdate.PHP_EOL;
	//echo $enddate.PHP_EOL;	
	
	$sql = 'SELECT r1.`Date` AS StartDate, r2.`Date` AS EndDate, r1.`Unit`, r2.`Reading` - r1.`Reading` AS Reading FROM `daily_last_reading` r1, `daily_last_reading` r2 WHERE r1.`Unit` = r2.`Unit` AND (r1.`Unit`, r1.`Date`) IN (SELECT `Unit`, MIN(`Date`) FROM `daily_last_reading` WHERE `Date` BETWEEN "'.$startdate.'" AND "'.$enddate.'" GROUP BY `Unit`) AND r2.`Date` = "'.$enddate.'" ORDER BY r1.`Unit`;';
	
	$result = $conn->query($sql);

	if ($result->num_rows > 0) {
		//var_dump($result);		
		while($row = $result->fetch_assoc()) {
			$res[] = $row;
        	//echo "StartDate: " . $row["StartDate"]. " - EndDate: " . $row["EndDate"]. " " . $row["Unit"]. $row["Reading"]. PHP_EOL;
    	}
    	
		$newdate = strtotime($enddate);
		$enddate = date("Y-m-d", strtotime("-1 month", $newdate));
		$newdate = strtotime($startdate);
		$startdate = date("Y-m-d", strtotime("-1 month", $newdate));	
		
	}else break;	
}
	$conn->close();
	echo json_encode($res);
?>