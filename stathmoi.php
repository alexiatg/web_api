<?php include("header.php"); ?>

<div class=form2>
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