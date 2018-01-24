#!/usr/bin/php
<?php 
$servername = "localhost";
$dbusername = "root";
$dbpassword = "weshallovercomesomeday";
$dbname = "eMeter";

// Create connection
$conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$sql = 'INSERT INTO `daily_last_reading`(`Date`, `Unit`, `Reading`) SELECT date_format(`Datetime`, "%Y-%m-%d"), `Unit`, MAX(`Reading`) FROM `readings` WHERE `Remarks` = "R" AND date_format(`Datetime`, "%Y-%m-%d") = CURRENT_DATE - INTERVAL 1 DAY GROUP BY `Unit`';

$result = $conn->query($sql);

if ($result->num_rows > 0) {
	//var_dump($result->num_rows);		
}

$conn->close();
?>