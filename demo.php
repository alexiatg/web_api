<?php 
include("header.php");
		
// Στο σημείο αυτό διαπερνάμε τα στοιχεία του .csv αρχείου μας
// και περνάμε στη βάση τα δεδομένα μας
$con=mysqli_connect("127.0.0.1","root","","web_api");

if (mysqli_connect_errno()) {
	echo "Failed to connect to MySQL: " . mysqli_connect_error();
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
    $result = mysqli_query($con,"SELECT * FROM stathmoi"); 

    while($row = mysqli_fetch_array($result)) {
      $id = $row['id'];
      $rypos = "";
		$result2 = mysqli_query($con,"SELECT rypos FROM data WHERE kwdikos=".$id." GROUP BY rypos ORDER BY rypos ASC");
		while($row2 = mysqli_fetch_array($result2)) {
		 	$rypos = $rypos." ".$row2['rypos'];
		 }
      echo "placeMarker(".$row['latitude'].", ".$row['longtitude'].", '".$row['onoma']."', '".$rypos."');";
    }
    ?>
 }

 function placeMarker(lat, lng, name, rypos) {
   var pos=new google.maps.LatLng(lat,lng);

   var marker = new google.maps.Marker({
      position: pos,
      map: map,
      title: 'You are here.'
    });
	marker.addListener('click', function() {
		infowindow.open(map, marker);
	});

	var contentString = '<h1>' + name + '</h1><h2>Οι ρύποι του σταθμού είναι:<br>' + rypos + '</h2>';

	  var infowindow = new google.maps.InfoWindow({
	    content: contentString
	  });

    google.maps.event.addListener(marker, 'click', function() {
        map.setCenter(marker.getPosition());
           });
 }

 google.maps.event.addDomListener(window, 'load', initialize);

 </script>

<br><br>
<div class="row">
    <div class="col-3">
    	Με επιλογή ενός από τα παρακάτω buttons γίνονται οι αντίστοιχες διαδικασίες στο API. 
			<?php			
				$result = mysqli_query($con,"SELECT api_key FROM users WHERE email='".$_SESSION['email']."'");
				$row = mysqli_fetch_array($result);
				echo "<a href='handler.php?action=stations&key=".$row['api_key']."'><button class='button'>Σταθμοί Καταγραφής</button></a>";
			?>

			<br><br><br>
			<form action="handler.php">
			 <input name="key" type="hidden" value="<?php echo $row['api_key']; ?>"></input>
			 <select name="rypos">
			 <?php
				$result = mysqli_query($con,"SELECT * FROM data GROUP BY rypos ORDER BY rypos ASC");
				while($row = mysqli_fetch_array($result)) {
				 	echo "<option value=".$row['rypos'].">".$row['rypos']."</option>";
				 }

				echo "</select> <select name='kwdikos'>";
				echo "<option value='' selected='selected'></option>";
				$result = mysqli_query($con,"SELECT * FROM stathmoi ORDER BY onoma ASC");
				while($row = mysqli_fetch_array($result)) {
				 	echo "<option value=".$row['id'].">".$row['onoma']."</option>";
				 }

				echo "</select> <select name='date'>";
				$result = mysqli_query($con,"SELECT * FROM data GROUP BY date ORDER BY date ASC");
				while($row = mysqli_fetch_array($result)) {
				 	echo "<option value=".$row['date'].">".$row['date']."</option>";
				 }

				echo "</select> <select name='wra'>";
				for ($i=1; $i < 25; $i++) { 
				 	echo "<option value=".$i.">".$i."</option>";
				 } 
			 ?>
			</select> 
			<input type="submit" value="Απόλυτη τιμή ρύπανσης">
			</form>
			<br><br><br>
			<form action="handler.php">
			<?php 
			$result = mysqli_query($con,"SELECT api_key FROM users WHERE email='".$_SESSION['email']."'");
			$row = mysqli_fetch_array($result);
			?>
			 <input name="key" type="hidden" value="<?php echo $row['api_key']; ?>"></input>
			 <select name="rypos">
			 <?php
				$result = mysqli_query($con,"SELECT * FROM data GROUP BY rypos ORDER BY rypos ASC");
				while($row = mysqli_fetch_array($result)) {
				 	echo "<option value=".$row['rypos'].">".$row['rypos']."</option>";
				 }

				echo "</select> <select name='kwdikos'>";
				echo "<option value='' selected='selected'></option>";
				$result = mysqli_query($con,"SELECT * FROM stathmoi ORDER BY onoma ASC");
				while($row = mysqli_fetch_array($result)) {
				 	echo "<option value=".$row['id'].">".$row['onoma']."</option>";
				 }

				echo "</select> <select name='date'>";
				$result = mysqli_query($con,"SELECT * FROM data GROUP BY date ORDER BY date ASC");
				while($row = mysqli_fetch_array($result)) {
				 	echo "<option value=".$row['date'].">".$row['date']."</option>";
				 }
			 ?>
			</select> 
			<input type="submit" value="Μέση τιμή ρύπανσης">
			</form>
		
	</div>

    <div class="col-5">
    	Επιλέξτε marker στο χάρτη για να δείτε τους ρύπους του.
 		<div class="googleMap" id="googleMap"></div>
	</div>
</div>
<?php include("footer.php"); ?>