<?php
  session_start();
  $nazwa = $_POST['nazwa'];
  $cena = $_POST['cena'];
  $kalorycznosc = $_POST['kalorycznosc'];
  $opis = $_POST['opis'];
  include '../config.php';
  $connect = new PDO($servername, $username, $password, $options);
  $sql = sprintf("SELECT nazwa FROM diety");
  $statement = $connect->prepare($sql);
  $statement->execute();
  $result = $statement->fetchAll();
  $exist = false;
  foreach ($result as $row) {
    if($row['nazwa'] == $nazwa)
      $exist = true;
  }
  if(!$exist){
    $sql = sprintf("INSERT INTO diety VALUES(NULL, '$nazwa', $cena, '$opis',$kalorycznosc)");
    $statement = $connect->prepare($sql);
    $statement->execute();
    foreach ($_POST['dania'] as $row) {
      $sql = sprintf("INSERT INTO dieta_danie VALUES ((SELECT id_diety FROM diety WHERE nazwa = '$nazwa'),$row)");
      $statement = $connect->prepare($sql);
      $statement->execute();
    }
  }
  header("Location: ../work.php");
?>
