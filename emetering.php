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
if($startdate < "2017-10-29") $startdate = "2017-10-29";

for($i=$tlength; $i>0; $i--){		
	//echo $startdate.PHP_EOL;
	//echo $enddate.PHP_EOL;	
	
	$sql = 'SELECT "'.$startdate.'" AS "StartDate", "'.$enddate.'" AS "EndDate", r1.`Unit`, MAX(r2.`Reading`) - MAX(r1.`Reading`) AS "Reading" FROM `readings` r1, `readings` r2 WHERE r1.`Remarks` = "R" AND r2.`Remarks` = "R" AND date_format(r1.`Datetime`, "%Y-%m-%d") = "'.$startdate.'" AND date_format(r2.`Datetime`, "%Y-%m-%d") = "'.$enddate.'" AND  r1.`Unit` = r2.`Unit` GROUP BY r1.`Unit`, r2.`Unit`;';
	
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
		if($startdate < "2017-10-29") $startdate = "2017-10-29";
		
	}else break;	
}
	$conn->close();
	echo json_encode($res);
?>