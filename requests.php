<?php include("header.php"); 

$con=mysqli_connect("127.0.0.1","root","","web_api");

if (mysqli_connect_errno()) {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

if ($_SESSION['role'] == "user") {
    $result = mysqli_query($con,"SELECT api_key FROM users WHERE email='".$_SESSION['email']."'");
    $row = mysqli_fetch_array($result);
    $key = $row['api_key'];
    echo $key;
    $result = mysqli_query($con,"SELECT COUNT(category) AS stations FROM requests WHERE (api_key='".$key."' AND category='stations')");
    $row = mysqli_fetch_array($result);
    $stations = $row['stations'];
    $result = mysqli_query($con,"SELECT COUNT(category) AS average FROM requests WHERE (category='average' AND api_key='".$key."')");
    $row = mysqli_fetch_array($result);
    $average = $row['average'];
    $result = mysqli_query($con,"SELECT COUNT(category) AS abs FROM requests WHERE (category='abs_rypos' AND api_key='".$key."')");
    $row = mysqli_fetch_array($result);
    $abs_rypos = $row['abs'];


    echo "<div>";
    echo "<br><br><br><br><br>";
    echo "<table class='info'>";
    echo "<tr><td>";
    echo "Σταθμοί";
    echo "</td><td>";
    echo "Μέση τιμή";
    echo "</td><td>";
    echo "Απόλυτη τιμή";
    echo "</td>";

    echo "<tr>";
    echo "<td>";
    echo $stations;
    echo "</td><td>";
    echo $average;
    echo "</td><td>";
    echo $abs_rypos;
    echo "</td></tr>";

    echo "</table>";
    echo "</div>";
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

    echo "<div>";
    echo "<br><br><br><br><br>";
    echo "<table class='info'>";
    echo "<tr><td>";
    echo "Σταθμοί";
    echo "</td><td>";
    echo "Μέση τιμή";
    echo "</td><td>";
    echo "Απόλυτη τιμή";
    echo "</td><td>";
    echo "Top 10";
    echo "</td><td>";
    echo "Σύνολο Api keys";
    echo "</td>";

    echo "<tr>";
    echo "<td>";
    echo $stations;
    echo "</td><td>";
    echo $average;
    echo "</td><td>";
    echo $abs_rypos;
    echo "</td><td>";
    while ( $row = mysqli_fetch_array($result) ) {
        if ($num > 10) {
            break;
        }
        echo $num.". ".$row['api_key']."<br>";
        $num = $num + 1;
    }
    echo "</td><td>";
    echo $apis;
    echo "</td></tr>";

    echo "</table>";
    echo "</div>";
}

mysqli_close($con);
?>

<?php include("footer.php"); ?>