<head>

<link rel="stylesheet" type="text/css" href="mystyle.css">  
  
<meta charset="UTF-8">  
</head>
<body>

<?php
	if (isset($_GET['msg'])) {
		if ($_GET['msg'] == "exists") {
			echo "<br><br><br>Το email που δώσατε χρησημοποιείται ήδη.";
		}
	}
?>



<div class=forms>
<form action="register_check.php" method="post" enctype="multipart/form-data" name="form1" id="form1"> 
  <br> Email:<br>
  <input name="email" type="email"/> 
  <br> Κωδικός:<br>
  <input name="password" type="password"/> 
  <br> 
  <input type="submit" name="Submit" value="Εγγραφή" /> 
</form> 
</div>

<?php include("footer.php"); ?>