<?php
include("header.php");


if (isset($_GET['action']) && $_GET['action']=="stations" && isset($_GET['key'])) {

  $station = file_get_contents('http://localhost/web_api/api.php?action=stations&key='.$_GET['key']);
  $station = json_decode($station, true);
  ?>
  	<br><br><br><br><br>
    <table class="info">
      <tr>
        <td>Όνομα σταθμού</td>
        <td>Κωδικός σταθμού</td>
        <td>Longtitude</td>
        <td>Latitude</td>
      </tr>
      <?php foreach ($station as $value) { ?>
      <tr>
        <td> <?php echo $value["onoma"] ?></td>
        <td> <?php echo $value["kwdikos"] ?></td>
        <td> <?php echo $value["longtitude"] ?></td>
        <td> <?php echo $value["latitude"] ?></td>
      </tr>
      <?php } ?>
    </table>
    <a href="http://localhost/web_api/demo.php">Επιστροφή στο Demo</a>
<?php
}

if (isset($_GET['rypos']) && isset($_GET['kwdikos']) && isset($_GET['date']) && isset($_GET['wra'])) {

  $absolute = file_get_contents("http://localhost/web_api/api.php?action=abs_rypos&rypos=".$_GET['rypos']."&kwdikos=".$_GET['kwdikos']."&hmeromhnia=".$_GET['date']."&wra=".$_GET['wra']."&key=".$_GET['key']);
  $absolute = json_decode($absolute, true);
  ?>
  	<br><br><br><br><br>
    <table class="info">
      <tr>
        <td>Απόλυτη τιμή</td>
        <td>Longtitude</td>
        <td>Latitude</td>
      </tr>
      <tr>
        <td> <?php echo $absolute[0]["absolute"] ?></td>
        <td> <?php echo $absolute[1]["longtitude"] ?></td>
        <td> <?php echo $absolute[2]["latitude"] ?></td>
      </tr>
    </table>
    <a href="http://localhost/web_api/demo.php">Επιστροφή στο Demo</a>
<?php
}elseif (isset($_GET['rypos']) && isset($_GET['kwdikos']) && isset($_GET['date'])) {

  $average = file_get_contents("http://localhost/web_api/api.php?action=average&rypos=".$_GET['rypos']."&kwdikos=".$_GET['kwdikos']."&hmeromhnia=".$_GET['date']."&key=".$_GET['key']);
  $average = json_decode($average, true);
  ?>
  	<br><br><br><br><br>
    <table class="info">
      <tr>
        <td>Μέση τιμή</td>
        <td>Τυπική απόκλιση</td>
        <td>Longtitude</td>
        <td>Latitude</td>
      </tr>
      <tr>
        <td> <?php echo $average[0]["average"]?></td>
        <td> <?php echo $average[1]["apoklish"] ?></td>
        <td> <?php echo $average[2]["longtitude"] ?></td>
        <td> <?php echo $average[3]["latitude"] ?></td>
      </tr>
    </table>
    <a href="http://localhost/web_api/demo.php">Επιστροφή στο Demo</a>
<?php
}

include("footer.php");
?>