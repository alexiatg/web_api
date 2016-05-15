<?php

function generateRandomString() {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < 25; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}


	if (isset($_GET['email'])) {
		$key = generateRandomString();
		// Δημιουργούμε μία σύνδεση στη Βάση
		$con=mysqli_connect("127.0.0.1","root","","web_api");

		// Ελέγχουμε αν η σύνδεση έγινε επιτυχώς αλλιώς βγάζουμε
		// μήνυμα λάθους
		if (mysqli_connect_errno()) {
			echo "Failed to connect to MySQL: " . mysqli_connect_error();
		}

		mysqli_query($con,"UPDATE users SET api_key='".$key."' WHERE email='".$_GET['email']."'");

		// Κλείνουμε τη σύνδεση με τη Βάση
		mysqli_close($con);

		header("Location: login.php");
	}
?>