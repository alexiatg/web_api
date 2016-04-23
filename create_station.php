<?php
$stathmos = $_POST['stathmos'];
$pwd = $_POST['m_kwdikos'];
$longtitude = $_POST['longtitude'];
$latitude = $_POST['latitude'];

// Create connection
$con=mysqli_connect("127.0.0.1","root","","web_api");

// Check connection
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

mysqli_query($con, "INSERT INTO stathmoi (id,onoma,kwdikos,longtitude,latitude) VALUES ( 0,'".$stathmos."','".$pwd."','".$longtitude."','".$latitude."')");

mysqli_close($con);

header("Location: stathmoi.php");
?>