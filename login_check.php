<?php
$email = $_POST['email'];
$pwd = $_POST['password'];

// Ελέγχουμε αν τα στοιχεία που μας έδωσε ο χρήστης ταιριάζουν με τα σωστά.
// Αν ναι τότε κάνουμε redirect στην τοποθεσία stathmoi.php αλλιώς τον στέλνουμε
// ξανά στο login page
if($email == "admin@example.com" && $pwd == "1234"){
    header("Location: stathmoi.php");
} else {
	header("Location: login.php");
}
?>