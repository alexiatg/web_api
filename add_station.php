<?php include("header.php"); ?>


<script src="http://maps.googleapis.com/maps/api/js?key=AIzaSyDY0kkJiTPVd2U7aTOAwhc9ySH6oHxOIYM&sensor=false"></script>
 <script>

 var map;
 var myCenter=new google.maps.LatLng(38.246437777492105,21.736161867736882);
 function initialize() {

    var mapProp = {
      center: myCenter,
      zoom:10,
      mapTypeId:google.maps.MapTypeId.ROADMAP
      };

    map = new google.maps.Map(document.getElementById('googleMap'),mapProp);

    placeMarker(38.246437777492105, 21.736161867736882);
    
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
        var a = marker.getPosition().lat();
        var b = marker.getPosition().lng();
        document.getElementById("latitude").value = a;
        document.getElementById("longtitude").value = b;
    });
 }

 google.maps.event.addDomListener(window, 'load', initialize);
 </script>


<div class=form2>
    <!-- Θέλουμε η φόρμα μας να σταλεί με τη μέθοδο post, method="post". Επίσης
    χρησιμοποιούμε το tag enctype="miltipart/form-data" γιατί θέλουμε να περάσουμε
    και δεδομένα μέσα απο τη φόρμα, σε αυτή την περίπτωση τη φωτογραφία -->
    <form action="create_station.php" method="post" enctype="multipart/form-data"> 
      <br> Όνομα σταθμού:<br>
      <input name="stathmos" type="text"/> 
      <br> Κωδικός σταθμού:<br>
      <input name="m_kwdikos" type="text"/> 
      <br> Συντεταγμένες<br>
      <br> Longtitude:<br>
      <input name="longtitude" id="longtitude" type="text"/> 
      <br> Latitude:<br>
      <input name="latitude" id="latitude" type="text"/> 
      <div class="googleMap" id="googleMap"></div>


      <input type="submit" name="Submit" value="Προσθήκη σταθμού" /> 
    </form> 
</div>

<?php include("footer.php"); ?>
