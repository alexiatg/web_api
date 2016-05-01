<head>

<link rel="stylesheet" type="text/css" href="mystyle.css">  
  
<meta charset="UTF-8">  
</head>
<body>
<?php
// Start the session
session_start();
?>

<ul>
  <?php
  if(isset($_SESSION["logged"])){
	  if ($_SESSION["logged"] == true) {
	  	?>
		<li><a href="demo.php">Demo</a></li>
		<li><a href="stathmoi.php">Σταθμοί καταγραφής</a></li>
		<li><a href="requests.php">Requests</a></li>
	  	<li><a href="logout.php">Έξοδος</a></li>
	  	<?php
	  }elseif (isset($_GET['red'])) {
	  	?>
	  	<li><a href="register.php">Εγγραφή</a></li>
	  	<?php
	  } else{
		header("Location: login.php?red=true");
	  }
	}else{
		header("Location: logout.php");
	}
  	?>
</ul>