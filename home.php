<?php 
include("header.php");

// Θέλουμε να μπούμε σε αυτή την if() μόνο αν ο χρήστης έχει κάνει
// submit τη φόρμα 
if(isset($_POST['Submit'])){
	// Η $_FILES[][] κρατάει όλα τα αρχεία που προσπαθούμε να περάσουμε στον
	// server μας και κάποια στοιχεία γι' αυτά όπως το size
	if ($_FILES['csv']['size'] > 0) { 
		// Βρίσκουμε το αρχείο που θέλουμε να χρησιμοποιήσουμε
	    $file = "files/".basename($_FILES['csv']['name']);
	    $name = basename($_FILES['csv']['name']);
	    // Ανοίγουμε το αρχείο με τη fopen() για να μπορέσουμε να διαβάσουμε τα 
	    // δεδομένα του. Το flag "r" σημαίνει read
	    $handle = fopen($file,"r");

	    $split = str_split($name, 3);
	    if(strlen($name) == 14){
	    	$rypos = $split[0];
	    	$city = $split[1];
	    	$temp = str_split($split[3], 1);
	    	$year = $split[2].$temp[0];
	    }else{
	    	$rypos = $split[0];
	    	$temp = $split[1].$split[2].$split[3];
	    	$split = str_split($temp, 4);
	    	$city = $split[0];
	    	$year = $split[1];

	    }

	    // Στο σημείο αυτό διαπερνάμε τα στοιχεία του .csv αρχείου μας
	    // και περνάμε στη βάση τα δεδομένα μας
		$con=mysqli_connect("127.0.0.1","root","","web_api");

		if (mysqli_connect_errno()) {
			echo "Failed to connect to MySQL: " . mysqli_connect_error();
		}

		// Χρησιμοποιούμε την fgetcsv() για να πάρουμε όλα τα δεδομένα που χρειαζόμαστε 
		// απο το αρχείο
	    while ($data = fgetcsv($handle,1000,",","'")){ 
	 		if ($data[0]) { 
	            mysqli_query($con, "INSERT INTO data (id,rypos,kwdikos,year,date,h1,h2,h3,h4,h5,h6,h7,h8,h9,h10,h11,h12,h13,h14,h15,h16,h17,h18,h19,h20,h21,h22,h23,h24) VALUES 
	                ( 
	                    0,
	                    '".$rypos."',
	                    '".$city."',
	                    '".$year."',
	                    ".$data[0].", 
	                    ".$data[1].", 
	                    ".$data[2].",
	                    ".$data[3].", 
	                    ".$data[4].", 
	                    ".$data[5].",
	                    ".$data[6].", 
	                    ".$data[7].", 
	                    ".$data[8].",
	                    ".$data[9].", 
	                    ".$data[10].", 
	                    ".$data[11].",
	                    ".$data[12].", 
	                    ".$data[13].", 
	                    ".$data[14].",
	                    ".$data[15].", 
	                    ".$data[16].", 
	                    ".$data[17].",
	                    ".$data[18].", 
	                    ".$data[19].", 
	                    ".$data[20].",
	                    ".$data[21].", 
	                    ".$data[22].", 
	                    ".$data[23].", 
	                    ".$data[24]."
	                ) 
	            "); 
	        } 
	    } 

	} 
}
?> 

<!-- Αν δεν έχει γίνει submit της φόρμας, δηλαδή αν ο χρήστης επισκέπτεται για πρώτη
	 φορά τη σελίδα τότε θέλουμε να του εμφανίζει τη φόρμα για να διαλέξει αρχείο csv -->
<div class=forms>
<form action="" method="post" enctype="multipart/form-data" name="form1" id="form1"> 
  <br> Typos rypou:<br>
  <input name="rypos" type="text" id="rypos" /> 
  <br> Etos:<br>
  <input name="etos" type="text" id="etos" /> 
  <br> Epilogh Arxeiou:<br>
  <input name="csv" type="file" id="csv" /> 
  <br> 
  <input type="submit" name="Submit" value="Submit" /> 
</form> 
</div>

<?php include("footer.php"); ?>