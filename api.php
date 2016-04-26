<?php
// This is the API to possibility show the user list, and show a specific user by action.
function stations() {

 // Create connection
  $con=mysqli_connect("127.0.0.1","root","","web_api");

  // Check connection
  if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }
  $result = mysqli_query($con,"SELECT * FROM stathmoi ORDER BY onoma ASC");
  $stathmoi = array();
  while($row = mysqli_fetch_array($result)) {
    $temp = array("onoma" => $row['onoma'], "kwdikos" => $row['kwdikos'], "longtitude" => $row['longtitude'], "latitude" => $row['latitude']);
    array_push($stathmoi, $temp);

  }
  mysqli_close($con);

  return $stathmoi;
}

function abs_rypos($rypos, $kwdikos, $hmeromhnia, $wra){
    $con=mysqli_connect("127.0.0.1","root","","web_api");

  // Check connection
  if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }
if ($kwdikos) {
    $result = mysqli_query($con,"SELECT h".$wra." FROM data WHERE rypos='".$rypos."' AND kwdikos='".$kwdikos."' AND (date LIKE '".$hmeromhnia."' OR date LIKE '%".$hmeromhnia."%')");
}else {
    $result = mysqli_query($con,"SELECT h".$wra." FROM data WHERE rypos='".$rypos."' AND (date LIKE '".$hmeromhnia."' OR date LIKE '%".$hmeromhnia."%')");    
}

$apolyth= array();
while ($row = mysqli_fetch_array($result)) {
    $temp= array("absolute" => $row['h'.$wra]);
    array_push($apolyth, $temp);
}


  if ($kwdikos) {
    $result = mysqli_query($con,"SELECT longtitude,latitude FROM stathmoi WHERE id=".$kwdikos);
    
  }else{
    $result = mysqli_query($con,"SELECT longtitude,latitude FROM stathmoi INNER JOIN data ON stathmoi.id=data.kwdikos AND (date LIKE '".$hmeromhnia."' OR date LIKE '%".$hmeromhnia."%') AND rypos='".$rypos."' GROUP BY data.kwdikos");
  }

$syntetagmenes= array();
while ($row = mysqli_fetch_array($result)){
    $temp= array("longtitude" => $row['longtitude'], "latitude" => $row['latitude']);
    array_push($syntetagmenes, $temp);
}

$apotelesmata = array();
array_push($apotelesmata, $apolyth, $syntetagmenes);
return $apotelesmata;

}

function average ($rypos, $kwdikos, $hmeromhnia){
  // Create connection
  $con=mysqli_connect("127.0.0.1","root","","web_api");

  // Check connection
  if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }
  if ($kwdikos) {
    $result = mysqli_query($con,"SELECT * FROM data WHERE rypos='".$rypos."' AND kwdikos='".$kwdikos."' AND (date LIKE '".$hmeromhnia."' OR date LIKE '%".$hmeromhnia."%')");
    
  }else{
    $result = mysqli_query($con,"SELECT * FROM data WHERE rypos='".$rypos."' AND (date LIKE '".$hmeromhnia."' OR  date LIKE '%".$hmeromhnia."%')");
  }
  $mesh_timh=0;
  $mesh_meras=0;
  $counter = 0;

  $apotelesmata = array();
  while($row = mysqli_fetch_array($result)) {
    $temp = $row['h1'] + $row['h2'] + $row['h3'] + $row['h4'] + $row['h5'] + $row['h6'] + $row['h7'] + $row['h8'] + $row['h9'] + $row['h10'] + $row['h11'] + $row['h12'] + $row['h13'] + $row['h14'] + $row['h15'] + $row['h16'] + $row['h17'] + $row['h18'] + $row['h19'] + $row['h20'] + $row['h21'] + $row['h22'] + $row['h23'] + $row['h24'];
    $mesh_meras= $temp/24.0 + $mesh_meras;
    $counter = $counter + 1;
  }

  $mesh_timh = $mesh_meras/$counter;

  $apok=0;
  $counter = 0;
  if ($kwdikos) {
    $result = mysqli_query($con,"SELECT * FROM data WHERE rypos='".$rypos."' AND kwdikos='".$kwdikos."' AND (date LIKE '".$hmeromhnia."' OR date LIKE '%".$hmeromhnia."%')");
    
  }else{
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
    
  }else{
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

$possible_url = array("stations", "abs_rypos", "average");

$value = "An error has occurred";

if (isset($_GET["action"]) && in_array($_GET["action"], $possible_url))
{
  switch ($_GET["action"])
    {
      case "stations":
        $value = stations();
        break;
      case "average":
       if (isset($_GET["rypos"]) && isset($_GET["kwdikos"]) && isset($_GET["hmeromhnia"]))
          $value = average($_GET["rypos"],$_GET["kwdikos"],$_GET["hmeromhnia"]);
        else
          $value = "Missing argument";
        break;
      case "abs_rypos":
        if (isset($_GET["rypos"]) && isset($_GET["kwdikos"]) && isset($_GET["hmeromhnia"]) && isset($_GET["wra"]))
          $value = abs_rypos($_GET["rypos"],$_GET["kwdikos"],$_GET["hmeromhnia"],$_GET["wra"]);
        else
          $value = "Missing argument";
        break;
    }
}

exit(json_encode($value));

?>