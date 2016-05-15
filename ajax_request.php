<?php
session_start();

$con=mysqli_connect("127.0.0.1","root","","web_api");

if (mysqli_connect_errno()) {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$ajax_response='';

if ($_SESSION['role'] == "user") {
    $result = mysqli_query($con,"SELECT api_key FROM users WHERE email='".$_SESSION['email']."'");
    $row = mysqli_fetch_array($result);
    $key = $row['api_key'];
    $result = mysqli_query($con,"SELECT COUNT(category) AS stations FROM requests WHERE (api_key='".$key."' AND category='stations')");
    $row = mysqli_fetch_array($result);
    $stations = $row['stations'];
    $result = mysqli_query($con,"SELECT COUNT(category) AS average FROM requests WHERE (category='average' AND api_key='".$key."')");
    $row = mysqli_fetch_array($result);
    $average = $row['average'];
    $result = mysqli_query($con,"SELECT COUNT(category) AS abs FROM requests WHERE (category='abs_rypos' AND api_key='".$key."')");
    $row = mysqli_fetch_array($result);
    $abs_rypos = $row['abs'];

    $ajax_response = $ajax_response."<div><br><br><br><table class='info'><tr><td>Σταθμοί</td><td>Μέση τιμή</td><td>Απόλυτη τιμή</td></tr><tr><td>".$stations."</td><td>".$average."</td><td>".$abs_rypos."</td></tr></table></div>";
}else{
    $result = mysqli_query($con,"SELECT COUNT(category) AS stations FROM requests WHERE category='stations'");
    $row = mysqli_fetch_array($result);
    $stations = $row['stations'];
    $result = mysqli_query($con,"SELECT COUNT(category) AS average FROM requests WHERE category='average'");
    $row = mysqli_fetch_array($result);
    $average = $row['average'];
    $result = mysqli_query($con,"SELECT COUNT(category) AS abs FROM requests WHERE category='abs_rypos'");
    $row = mysqli_fetch_array($result);
    $abs_rypos = $row['abs'];
    $result = mysqli_query($con,"SELECT COUNT(api_key) AS apis FROM users");
    $row = mysqli_fetch_array($result);
    $apis = $row['apis'];
    $result = mysqli_query($con,"SELECT api_key FROM users ORDER BY requests DESC");
    $num = 1;

    $ajax_response = $ajax_response."<div><br><br><br><table class='info'><tr><td>Σταθμοί</td><td>Μέση τιμή</td><td>Απόλυτη τιμή</td><td>Top 10</td><td>Σύνολο Api keys</td><tr><td>".$stations."</td><td>".$average."</td><td>".$abs_rypos."</td><td>";
  
      while ( $row = mysqli_fetch_array($result) ) {
        if ($num > 10) {
            break;
        }
        $ajax_response = $ajax_response.$num.". ".$row['api_key']."<br>";
        $num = $num + 1;
    }

    $ajax_response = $ajax_response."</td><td>".$apis."</td></tr></table></div>";
}

mysqli_close($con);

echo $ajax_response;
?>