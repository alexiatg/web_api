<?php
$email = $_POST['email'];
$pwd = $_POST['password'];

if($email == "admin@example.com" && $pwd == "1234"){
    header("Location: stathmoi.php");
}else{
	header("Location: login.php");
}
?>