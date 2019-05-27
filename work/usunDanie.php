<?php
  session_start();
  $nazwa = $_POST['nazwa'];
  include '../config.php';
  $connect = new PDO($servername, $username, $password, $options);
  $sql = sprintf("SELECT dania.nazwa, diety.nazwa as dieta FROM dania NATURAL JOIN dieta_danie INNER JOIN diety on diety.id_diety = dieta_danie.id_dania WHERE dania.nazwa = '{$nazwa}'");
  $statement = $connect->prepare($sql);
  $statement->execute();
  $result = $statement->fetchAll();
  if($result){
    foreach($result as $row){
      header("Location: ../work.php?dieta={$row['dieta']}#usunDanie");
    }
  }else{
    $sql = sprintf("DELETE FROM danie_produkt WHERE id_dania = (SELECT id_dania FROM dania WHERE nazwa = '{$nazwa}');");
    $statement = $connect->prepare($sql);
    $statement->execute();
    $sql = sprintf("DELETE FROM dania WHERE nazwa = '{$nazwa}';");
    $statement = $connect->prepare($sql);
    $statement->execute();
    header("Location: ../work.php#usunDanie");
  }
?>
