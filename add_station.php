<?php include("header.php"); ?>

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
      <input name="longtitude" type="text"/> 
      <br> Latitude:<br>
      <input name="latitude" type="text"/> 
      <div class="googleMap"> 
      </div>
      <input type="submit" name="Submit" value="Προσθήκη σταθμού" /> 
    </form> 
</div>

<?php include("footer.php"); ?>
