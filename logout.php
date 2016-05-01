<?php
// Start the session
session_start();

$_SESSION["role"] = "";
$_SESSION["logged"] = false;
$_SESSION["email"] = "";
header("Location: login.php");
?>