<?php 
//120.86.116.195
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
	
	$sql = 'SELECT MIN(date_format(`Datetime`, "%Y-%m-%d")) AS "StartDate", MAX(date_format(`Datetime`, "%Y-%m-%d")) AS "EndDate", `Unit`, MAX(`Reading`) - MIN(`Reading`) AS "Reading"FROM `readings` WHERE `Remarks` = "R" AND date_format(`Datetime`, "%Y-%m-%d") BETWEEN "'.$startdate.'" AND "'.$enddate.'" GROUP BY `Unit`;';
	
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