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
	$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
  if(isset($_SESSION["logged"])){
	  if ($_SESSION["logged"] == true) {
	  	?>
		<li><a href="demo.php">Demo</a></li>
		<li><a href="stathmoi.php">Σταθμοί καταγραφής</a></li>
		<li><a href="requests.php">Requests</a></li>
	  	<li><a href="logout.php">Έξοδος</a></li>
	  	<?php
	  }elseif ($actual_link == "http://localhost/web_api/login.php") {
	  	?>
	  	<li><a href="register.php">Εγγραφή</a></li>
	  	<?php
	  } else{
		header("Location: login.php");
	  }
	}else{
		header("Location: logout.php");
	}
  	?>
</ul>