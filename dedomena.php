<?php 
include("header.php");
if(isset($_POST['Submit'])){
	$rypos = $_POST['rypos'];
	$year = $_POST['etos'];
	$city = $_POST['city'];
	if ($_FILES['csv']['size'] > 0) { 

	    //get the csv file 
	    $file = "files/".basename($_FILES['csv']['name']);
	    $handle = fopen($file,"r");

	    //loop through the csv file and insert into database 
	    //connect to the database 
		  $con=mysqli_connect("127.0.0.1","root","","web_api");
		  // Check connection
		  if (mysqli_connect_errno()) {
		    echo "Failed to connect to MySQL: " . mysqli_connect_error();
		  }
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

<div class=forms>
<form action="" method="post" enctype="multipart/form-data" name="form1" id="form1"> 
  <br> Typos rypou:<br>
  <input name="rypos" type="text" id="rypos" /> 
  <br> Etos:<br>
  <input name="etos" type="text" id="etos" /> 
  <br> Epilogh Arxeiou:<br>
  <input name="csv" type="file" id="csv" /> 
  <br> 
  <input type="hidden" name="city" value="<?php echo $_GET['id']; ?>">
  <input type="submit" name="Submit" value="Submit" /> 
</form> 
</div>

<?php include("footer.php"); ?>


