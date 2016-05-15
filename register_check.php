<?php
$email = $_POST['email'];
$pwd = $_POST['password'];


  // Δημιουργούμε μία σύνδεση στη Βάση
  $con=mysqli_connect("127.0.0.1","root","","web_api");

  // Ελέγχουμε αν η σύνδεση έγινε επιτυχώς αλλιώς βγάζουμε
  // μήνυμα λάθους
  if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }
  // Περνάμε στη Βάση μας το query που θέλουμε και λαμβάνουμε την απάντηση
  // στη μεταβλητή #result
  $result = mysqli_query($con,"SELECT * FROM users WHERE email='".$email."'");

	if (mysqli_num_rows($result) > 0){
		// Κλείνουμε τη σύνδεση με τη Βάση
		mysqli_close($con);
	    header("Location: register.php?msg=exists");
	}else{
		mysqli_query($con,"INSERT INTO users (email, password) VALUES ('".$email."', '".$pwd."')");
		// Κλείνουμε τη σύνδεση με τη Βάση
		mysqli_close($con);
		header("Location: obtain_key.php?email=".$email);
	}
?>