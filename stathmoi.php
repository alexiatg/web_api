<?php include("header.php"); 

//connect to the database 
$con=mysqli_connect("127.0.0.1","root","","web_api");
// Check connection
if (mysqli_connect_errno()) {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
if (isset($_GET['id'])) {
    mysqli_query($con,"DELETE FROM stathmoi WHERE id = ".$_GET['id']);
}


$result = mysqli_query($con,"SELECT * FROM stathmoi ORDER BY onoma ASC");
echo "<div>";
echo "<br><br><br><br><br>";
echo "<table class='info'>";
echo "<tr><td>";
echo "Όνομα σταθμο";
echo "</td><td>";
echo "Κωδικός σταθμού";
echo "</td><td>";
echo "Longtitude";
echo "</td><td>";
echo "Latitude";
echo "</td><td>";
echo "Διαγραφή";
echo "</td></tr>";

while($row = mysqli_fetch_array($result)) {
  echo "<tr>";
  echo "<td>";
  echo "<a href='dedomena.php?id=".$row['id']."'>".$row['onoma']."</a>";
  echo "</td><td>";
  echo $row['kwdikos'];
  echo "</td><td>";
  echo $row['longtitude'];
  echo "</td><td>";
  echo $row['latitude'];
  echo "</td><td>";
  echo "<a href='stathmoi.php?id=".$row['id']."'>X</a>";
  echo "</td></tr>";

}
echo "</table>";
echo "</div>";
mysqli_close($con);

?>

<a href="add_station.php"><button class="add">+</button></a>

<?php include("footer.php"); ?>