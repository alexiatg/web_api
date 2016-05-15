<?php include("header.php"); 

$con=mysqli_connect("127.0.0.1","root","","web_api");

if (mysqli_connect_errno()) {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

// Ελέγχουμε αν έχουμε πάρει κάποιο id σταθμού. Αν ναι, τότε περνάμε στη διαδικάσία
// διαγραφής του σταθμού φτιάχνοντας το κατάλληλο query
if (isset($_GET['id'])) {
    mysqli_query($con,"DELETE FROM stathmoi WHERE id = ".$_GET['id']);
    header("Location: stathmoi.php");
}
?>

<script src="http://maps.googleapis.com/maps/api/js?key=AIzaSyDY0kkJiTPVd2U7aTOAwhc9ySH6oHxOIYM&sensor=false"></script>
<script>

 var map;
 var myCenter=new google.maps.LatLng(38.246437777492105,22.736161867736882);
 function initialize() {

    var mapProp = {
      center: myCenter,
      zoom:6,
      mapTypeId:google.maps.MapTypeId.ROADMAP
      };

    map = new google.maps.Map(document.getElementById('googleMap'),mapProp);
    
    <?php 
    $result = mysqli_query($con,"SELECT * FROM stathmoi ORDER BY onoma ASC"); 

    while($row = mysqli_fetch_array($result)) {
      echo "placeMarker(".$row['latitude'].", ".$row['longtitude'].");";
    }
    ?>
 }

 function placeMarker(lat, lng) {
   var pos=new google.maps.LatLng(lat,lng);

   var marker = new google.maps.Marker({
      position: pos,
      draggable: true,
      map: map,
      title: 'You are here.'
    });


    google.maps.event.addListener(marker, 'dragend', function() {
        map.setCenter(marker.getPosition());
           });
 }

 google.maps.event.addDomListener(window, 'load', initialize);

 </script>

<?php
$result = mysqli_query($con,"SELECT * FROM stathmoi ORDER BY onoma ASC");
echo "<div>";
echo "<br><br><br><br><br>";
echo "<table class='info'>";
echo "<tr><td>";
echo "Όνομα σταθμού";
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

 <br><br>
 <div class="googleMap" id="googleMap"></div>
 <a href="add_station.php"><button class="add">+</button></a>

<?php include("footer.php"); ?>