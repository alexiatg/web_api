<?php
// This is the API to possibility show the user list, and show a specific user by action.

function get_user_by_id($id)
{
  // Create connection
  $con=mysqli_connect("127.0.0.1","root","","web_api");

  // Check connection
  if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }
  $result = mysqli_query($con,"SELECT name,surname,status FROM diafora WHERE id = ".$id);
  $row = mysqli_fetch_array($result);
  
  $user_info = array("first_name" => $row['name'], "last_name" => $row['surname'], "status" => $row['status']);

  mysqli_close($con);
  return $user_info;
}

function get_user_list()
{
  // Create connection
  $con=mysqli_connect("127.0.0.1","root","","web_api");

  // Check connection
  if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }
  $result = mysqli_query($con,"SELECT name,id FROM diafora ORDER BY name ASC");
  $user_list = array();
  while($row = mysqli_fetch_array($result)) {
    $temp = array("id" => $row['id'], "name" => $row['name']);
    array_push($user_list, $temp);

  }
  mysqli_close($con);

  return $user_list;
}

$possible_url = array("get_user_list", "get_user");

$value = "An error has occurred";

if (isset($_GET["action"]) && in_array($_GET["action"], $possible_url))
{
  switch ($_GET["action"])
    {
      case "get_user_list":
        $value = get_user_list();
        break;
      case "get_user":
        if (isset($_GET["id"]))
          $value = get_user_by_id($_GET["id"]);
        else
          $value = "Missing argument";
        break;
    }
}

exit(json_encode($value));

?>