<?php include("header.php"); ?>

<div class=forms>
<form action="login_check.php" method="post" enctype="multipart/form-data" name="form1" id="form1"> 
  <br> Email:<br>
  <input name="email" type="email"/> 
  <br> Κωδικός:<br>
  <input name="password" type="password"/> 
  <br> 
  <input type="submit" name="Submit" value="Είσοδος" /> 
</form> 
</div>

<?php include("footer.php"); ?>