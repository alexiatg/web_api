<?php
// Δημιουργούμε τις μεταβλητές που θα μας χρειαστούν και τις
// αρχικοποιούμε με τις τιμές που πήραμε απο τη φόρμα
$stathmos = $_POST['stathmos'];
$pwd = $_POST['m_kwdikos'];
$longtitude = $_POST['longtitude'];
$latitude = $_POST['latitude'];

// Δημιουργούμε τη σύνδεση στη Βάση
$con=mysqli_connect("127.0.0.1","root","","web_api");

// Ελέγχουμε αν η σύνδεση έγινε επιτυχώς αλλιώς επιστρέφουμε μήνυμα λάθους
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

// Περνάμε στη Βάση το query που θέλουμε να τρέξουμε
mysqli_query($con, "INSERT INTO stathmoi (id,onoma,kwdikos,longtitude,latitude) VALUES ( 0,'".$stathmos."','".$pwd."','".$longtitude."','".$latitude."')");

// Κλείνουμε τη σύνδεση
mysqli_close($con);

// Με τη συνάρτηση header() της PHP και το tag Location: μπορούμε να κάνουμε 
// redirect πίσω στη σελίδα που θέλουμε
header("Location: stathmoi.php");
?>