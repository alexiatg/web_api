<?php
// Start the session
session_start();
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
$result = mysqli_query($con,"SELECT * FROM users WHERE email='".$email."' AND password='".$pwd."'");

// Ελέγχουμε αν τα στοιχεία που μας έδωσε ο χρήστης ταιριάζουν με τα σωστά.
// Αν ναι τότε κάνουμε redirect στην τοποθεσία stathmoi.php αλλιώς τον στέλνουμε
// ξανά στο login page
if($email == "admin@example.com" && $pwd == "1234"){
	$_SESSION["role"] = "admin";
	$_SESSION["logged"] = true;
    header("Location: stathmoi.php");
}elseif (mysqli_num_rows($result) > 0) {
	$_SESSION["role"] = "user";
	$_SESSION["logged"] = true;
	$_SESSION["email"] = $email;
    header("Location: demo.php");
} else {
	header("Location: login.php");
}
?>