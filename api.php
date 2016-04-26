<?php
/**
*	Η συνάρτηση stations επιστρέφει όλους τους σταθμούς της Βάσης
*	ταξινομημένους κατα αλφαβητική σειρά.
*/
function stations() {

 // Δημιουργούμε μία σύνδεση στη Βάση
  $con=mysqli_connect("127.0.0.1","root","","web_api");

  // Ελέγχουμε αν η σύνδεση έγινε επιτυχώς αλλιώς βγάζουμε
  // μήνυμα λάθους
  if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }
  // Περνάμε στη Βάση μας το query που θέλουμε και λαμβάνουμε την απάντηση
  // στη μεταβλητή #result
  $result = mysqli_query($con,"SELECT * FROM stathmoi ORDER BY onoma ASC");

  // Δημιουργούμε ένα array στο οποίο θα περάσουμε όλα τα αποτελέσματα για να τα
  // επιστρέψουμε στο χρήστη
  $stathmoi = array();

  // Διαβάζουμε όλες τις σειρές αποτελεσμάτων και περνάμε κάθε αποτέλεσμα
  // στο array που δημιουργήσαμε νωρίτερα 
  while($row = mysqli_fetch_array($result)) {
    $temp = array("onoma" => $row['onoma'], "kwdikos" => $row['kwdikos'], "longtitude" => $row['longtitude'], "latitude" => $row['latitude']);
    // Με την array_push() περνάμε τα δεδομένα μας στο array
    array_push($stathmoi, $temp);
  }

  // Κλείνουμε τη σύνδεση με τη Βάση
  mysqli_close($con);

  // Επιστρέφουμε την απάντηση που δημιουργήσαμε
  return $stathmoi;
}

/**
* Η συνάρτηση abs_rypos επιστρέφει την απόλυτη τιμή ρύπανσης για
* μία συγκεκριμένη ημερομηνία και ώρα, ένα συγκεκριμένο σταθμό και ένα 
* συγκεκριμένο ρύπο. Αν δε δοθεί κωδικός σταθμού τότε επιστρέφει
* για όλους τους σταθμούς.
*/
function abs_rypos($rypos, $kwdikos, $hmeromhnia, $wra){
    $con=mysqli_connect("127.0.0.1","root","","web_api");

  if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }

  // Ελέγχουμε ποιας κατηγορίας αποτελέσματα θέλουμε, με ή χωρίς κωδικό σταθμού, και
  // φτιάχνουμε το κατάλληλο query
  if ($kwdikos) {
  	// Χρησιμοποιούμε τη LIKE για να μπορέσουμε να πάρουμε απο τη Βάση δεδομένα όπου
  	// η ημερομηνία θα είναι της μορφής που θα δώσει ο χρήστης
    $result = mysqli_query($con,"SELECT h".$wra." FROM data WHERE rypos='".$rypos."' AND kwdikos='".$kwdikos."' AND (date LIKE '".$hmeromhnia."' OR date LIKE '%".$hmeromhnia."%')");
  } else {
    $result = mysqli_query($con,"SELECT h".$wra." FROM data WHERE rypos='".$rypos."' AND (date LIKE '".$hmeromhnia."' OR date LIKE '%".$hmeromhnia."%')");
  }

  $apolyth= array();
  while ($row = mysqli_fetch_array($result)) {
    $temp= array("absolute" => $row['h'.$wra]);
    array_push($apolyth, $temp);
  }

  // Ανάλογα με την κατηγορία που επιλέχθηκε παραπάνω, δηλαδή αν δώθηκε κωδικός σταθμού ή όχι, παίρνουμε
  // και τις αντίστοιχες συντεταγμένες
  if ($kwdikos) {
    $result = mysqli_query($con,"SELECT longtitude,latitude FROM stathmoi WHERE id=".$kwdikos);
  } else {
    $result = mysqli_query($con,"SELECT longtitude,latitude FROM stathmoi INNER JOIN data ON stathmoi.id=data.kwdikos AND (date LIKE '".$hmeromhnia."' OR date LIKE '%".$hmeromhnia."%') AND rypos='".$rypos."' GROUP BY data.kwdikos");
  }

  $syntetagmenes= array();
  while ($row = mysqli_fetch_array($result)){
    $temp= array("longtitude" => $row['longtitude'], "latitude" => $row['latitude']);
    array_push($syntetagmenes, $temp);
  }

  // Δημιουργούμε το array που θα επιστρέψει την τελική μας απάντηση, δηλαδή την
  // απόλυτη τιμή ρύπανσης και τις συντεταγμένες
  $apotelesmata = array();
  array_push($apotelesmata, $apolyth, $syntetagmenes);

  // Επιστρέφουμε την απάντηση
  return $apotelesmata;
}

/**
* Η συνάρτηση average επιστρέφει την μέση τιμή ρύπανσης για
* μία συγκεκριμένη ημερομηνία, ένα συγκεκριμένο σταθμό και ένα 
* συγκεκριμένο ρύπο. Αν δε δοθεί κωδικός σταθμού τότε επιστρέφει
* για όλους τους σταθμούς.
*/
function average ($rypos, $kwdikos, $hmeromhnia){
  $con=mysqli_connect("127.0.0.1","root","","web_api");

  if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }
  if ($kwdikos) {
    $result = mysqli_query($con,"SELECT * FROM data WHERE rypos='".$rypos."' AND kwdikos='".$kwdikos."' AND (date LIKE '".$hmeromhnia."' OR date LIKE '%".$hmeromhnia."%')");
  } else {
    $result = mysqli_query($con,"SELECT * FROM data WHERE rypos='".$rypos."' AND (date LIKE '".$hmeromhnia."' OR  date LIKE '%".$hmeromhnia."%')");
  }

  // Δηλώνουμε τις μεταβλητές που θα χρειαστούμε και τις αρχικοποιούμε
  $mesh_timh=0;
  $mesh_meras=0;
  $counter = 0;
  $apok=0;

  $apotelesmata = array();
  while($row = mysqli_fetch_array($result)) {
    $temp = $row['h1'] + $row['h2'] + $row['h3'] + $row['h4'] + $row['h5'] + $row['h6'] + $row['h7'] + $row['h8'] + $row['h9'] + $row['h10'] + $row['h11'] + $row['h12'] + $row['h13'] + $row['h14'] + $row['h15'] + $row['h16'] + $row['h17'] + $row['h18'] + $row['h19'] + $row['h20'] + $row['h21'] + $row['h22'] + $row['h23'] + $row['h24'];
    $mesh_meras= $temp/24.0 + $mesh_meras;
    $counter = $counter + 1;
  }

  $mesh_timh = $mesh_meras/$counter;

  $counter = 0;
  if ($kwdikos) {
    $result = mysqli_query($con,"SELECT * FROM data WHERE rypos='".$rypos."' AND kwdikos='".$kwdikos."' AND (date LIKE '".$hmeromhnia."' OR date LIKE '%".$hmeromhnia."%')");
  } else {
    $result = mysqli_query($con,"SELECT * FROM data WHERE rypos='".$rypos."' AND (date LIKE '".$hmeromhnia."' OR  date LIKE '%".$hmeromhnia."%')");
  }

  while($row = mysqli_fetch_array($result)) {
    $temp = $row['h1'] + $row['h2'] + $row['h3'] + $row['h4'] + $row['h5'] + $row['h6'] + $row['h7'] + $row['h8'] + $row['h9'] + $row['h10'] + $row['h11'] + $row['h12'] + $row['h13'] + $row['h14'] + $row['h15'] + $row['h16'] + $row['h17'] + $row['h18'] + $row['h19'] + $row['h20'] + $row['h21'] + $row['h22'] + $row['h23'] + $row['h24'];
    $mesh_meras= $temp/24.0 + $mesh_meras;
    $apok =$apok + pow($mesh_meras - $mesh_timh, 2);
    $counter = $counter + 1;
  }

  $apoklish = sqrt($apok/$counter);

  if ($kwdikos) {
    $result = mysqli_query($con,"SELECT longtitude,latitude FROM stathmoi WHERE id=".$kwdikos);
  } else {
    $result = mysqli_query($con,"SELECT longtitude,latitude FROM stathmoi INNER JOIN data ON stathmoi.id=data.kwdikos AND (date LIKE '".$hmeromhnia."' OR date LIKE '%".$hmeromhnia."%') AND rypos='".$rypos."' GROUP BY data.kwdikos");
  }

  $syntetagmenes = array();
  while ($row = mysqli_fetch_array($result)) {
    $temp = array("longtitude" => $row['longtitude'], "latitude" => $row['latitude']);
    array_push($syntetagmenes, $temp);
  }

  array_push($apotelesmata, $mesh_timh, $apoklish, $syntetagmenes);

  mysqli_close($con);

  return $apotelesmata;  
}

// Το array αυτό έχει όλες τις επιτρεπτές λειτουργίες του API
$possible_url = array("stations", "abs_rypos", "average");

$value = "An error has occurred";

// Ελέγχουμε αν έχει οριστεί η μεταβλητή action, δηλαδή αν έχει δοθεί κάποια
// λειτουργία και αν αυτή η λειτουργία είναι επιτρεπτή
if (isset($_GET["action"]) && in_array($_GET["action"], $possible_url))
{
  // Ανάλογα με το action που λάβαμε μετακινούμαστε και στο κατάλληλο case
  switch ($_GET["action"])
  {
    case "stations":
      // Εκτέλεσε τη συνάρτηση stations()
      $value = stations();
      break;
    case "average":
      // Ελέγχουμε αν έχουν δοθεί τα κατάλληλα ορίσματα αλλιώς επιστρέφουμε μήνυμα λάθους
      if (isset($_GET["rypos"]) && isset($_GET["kwdikos"]) && isset($_GET["hmeromhnia"]))
      	// Εκτέλεσε τη συνάρτηση average()
        $value = average($_GET["rypos"],$_GET["kwdikos"],$_GET["hmeromhnia"]);
      else
        $value = "Missing argument";
        break;
    case "abs_rypos":
      if (isset($_GET["rypos"]) && isset($_GET["kwdikos"]) && isset($_GET["hmeromhnia"]) && isset($_GET["wra"]))
      	// Εκτέλεσε τη συνάρτηση abs_rypos()
        $value = abs_rypos($_GET["rypos"],$_GET["kwdikos"],$_GET["hmeromhnia"],$_GET["wra"]);
      else
        $value = "Missing argument";
        break;
   }
}

// Κωδικοποιούμε την απάντησή μας σε μορφή json και την επιστρέφουμε για να μπορεί 
// να την λάβει ο χρήστης(προγραμματιστής)
exit(json_encode($value));
?>