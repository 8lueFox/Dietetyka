<?php
  session_start();
  $nazwa = $_POST['nazwa'];
  include '../config.php';
  $connect = new PDO($servername, $username, $password, $options);
  $sql = sprintf("SELECT produkty.nazwa as produkt, dania.nazwa as dania FROM produkty NATURAL JOIN danie_produkt INNER JOIN dania on dania.id_dania = danie_produkt.id_dania WHERE produkty.nazwa = '".$nazwa."'");
  $statement = $connect->prepare($sql);
  $statement->execute();
  $result = $statement->fetchAll();
  if($result){
    foreach($result as $row){
      header("Location: ../work.php?danie={$row['dania']}#usunProdukt");
    }
  }else{
    $sql = sprintf("DELETE FROM produkty WHERE nazwa = '{$nazwa}';");
    $statement = $connect->prepare($sql);
    $statement->execute();
    header("Location: ../work.php#usunProdukt");
  }
?>
