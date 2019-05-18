<?php
  session_start();
  $nazwa = $_POST['nazwa'];
  include '../config.php';
  $connect = new PDO($servername, $username, $password, $options);
  $sql = sprintf("SELECT nazwa FROM dania");
  $statement = $connect->prepare($sql);
  $statement->execute();
  $result = $statement->fetchAll();
  $exist = false;
  foreach ($result as $row) {
    if($row['nazwa'] == $nazwa)
      $exist = true;
  }
  if(!$exist){
    $sql = sprintf("INSERT INTO dania VALUES(NULL, '$nazwa')");
    $statement = $connect->prepare($sql);
    $statement->execute();
    foreach ($_POST['produkty'] as $row) {
      $sql = sprintf("INSERT INTO danie_produkt VALUES ((SELECT id_dania FROM dania WHERE nazwa = '$nazwa'),$row)");
      $statement = $connect->prepare($sql);
      $statement->execute();
    }
  }
  header("Location: ../work.php");
?>
