<?php 
include("header.php");
		
// Στο σημείο αυτό διαπερνάμε τα στοιχεία του .csv αρχείου μας
// και περνάμε στη βάση τα δεδομένα μας
$con=mysqli_connect("127.0.0.1","root","","web_api");

if (mysqli_connect_errno()) {
	echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
$result = mysqli_query($con,"SELECT api_key FROM users WHERE email='".$_SESSION['email']."'");
$row = mysqli_fetch_array($result);
?> 


<br><br><br><br><br>
<div class=form2>

<?php
	echo "<a href='handler.php?action=stations&key=".$row['api_key']."'><button class='button'>Σταθμοί Καταγραφής</button></a>";
?>

<br><br><br>
<form action="handler.php">
 <input name="key" type="hidden" value="<?php echo $row['api_key']; ?>"></input>
 <select name="rypos">
 <?php
	$result = mysqli_query($con,"SELECT * FROM data GROUP BY rypos ORDER BY rypos ASC");
	while($row = mysqli_fetch_array($result)) {
	 	echo "<option value=".$row['rypos'].">".$row['rypos']."</option>";
	 }

	echo "</select> <select name='kwdikos'>";
	echo "<option value='' selected='selected'></option>";
	$result = mysqli_query($con,"SELECT * FROM stathmoi ORDER BY onoma ASC");
	while($row = mysqli_fetch_array($result)) {
	 	echo "<option value=".$row['id'].">".$row['onoma']."</option>";
	 }

	echo "</select> <select name='date'>";
	$result = mysqli_query($con,"SELECT * FROM data GROUP BY date ORDER BY date ASC");
	while($row = mysqli_fetch_array($result)) {
	 	echo "<option value=".$row['date'].">".$row['date']."</option>";
	 }

	echo "</select> <select name='wra'>";
	for ($i=1; $i < 25; $i++) { 
	 	echo "<option value=".$i.">".$i."</option>";
	 } 
 ?>
</select> 
<input type="submit" value="Απόλυτη τιμή ρύπανσης">
</form>
<br><br><br>
<form action="handler.php">
<?php 
$result = mysqli_query($con,"SELECT api_key FROM users WHERE email='".$_SESSION['email']."'");
$row = mysqli_fetch_array($result);
?>
 <input name="key" type="hidden" value="<?php echo $row['api_key']; ?>"></input>
 <select name="rypos">
 <?php
	$result = mysqli_query($con,"SELECT * FROM data GROUP BY rypos ORDER BY rypos ASC");
	while($row = mysqli_fetch_array($result)) {
	 	echo "<option value=".$row['rypos'].">".$row['rypos']."</option>";
	 }

	echo "</select> <select name='kwdikos'>";
	echo "<option value='' selected='selected'></option>";
	$result = mysqli_query($con,"SELECT * FROM stathmoi ORDER BY onoma ASC");
	while($row = mysqli_fetch_array($result)) {
	 	echo "<option value=".$row['id'].">".$row['onoma']."</option>";
	 }

	echo "</select> <select name='date'>";
	$result = mysqli_query($con,"SELECT * FROM data GROUP BY date ORDER BY date ASC");
	while($row = mysqli_fetch_array($result)) {
	 	echo "<option value=".$row['date'].">".$row['date']."</option>";
	 }
 ?>
</select> 
<input type="submit" value="Μέση τιμή ρύπανσης">
</form>
</div>
<?php include("footer.php"); ?>