<?php
// if the get parameter action is get_user and if the id is set, call the api to get the user information
if (isset($_GET["action"]) && isset($_GET["id"]) && $_GET["action"] == "get_user") 
{
  $user_info = file_get_contents('http://localhost/web_api/api.php?action=get_user&id=' . $_GET["id"]);
  $user_info = json_decode($user_info, true);

  // THAT IS VERY QUICK AND DIRTY !!!!!
  ?>
    <table>
      <tr>
        <td>Last Name: </td><td> <?php echo $user_info["last_name"] ?></td>
      </tr>
      <tr>
        <td>First Name: </td><td> <?php echo $user_info["first_name"] ?></td>
      </tr>
      <tr>
        <td>Status: </td><td> <?php echo $user_info["status"] ?></td>
      </tr>
    </table>
    <a href="http://localhost/web_api/client.php?action=get_userlist" alt="user list">Return to the user list</a>
  <?php
}
else // else take the user list
{
  $user_list = file_get_contents('http://localhost/web_api/api.php?action=get_user_list');
  $user_list = json_decode($user_list, true);
  // THAT IS VERY QUICK AND DIRTY !!!!!
  ?>
    <ul>
    <?php foreach ($user_list as $user): ?>
      <li>
        <a href=<?php echo "http://localhost/web_api/client.php?action=get_user&id=" . $user["id"]  ?>  > <?php echo $user["name"] ?> </a>
    </li>
    <?php endforeach; ?>
    </ul>
  <?php
}

?>