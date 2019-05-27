<?php
  session_start();
  $nazwa = $_POST['nazwa'];
  include '../config.php';
  $connect = new PDO($servername, $username, $password, $options);
  $sql = sprintf("DELETE FROM dieta_danie WHERE id_diety = (SELECT id_diety FROM diety WHERE nazwa = '{$nazwa}')");
  $statement = $connect->prepare($sql);
  $statement->execute();
  $sql = sprintf("DELETE FROM diety WHERE nazwa = '{$nazwa}'");
  $statement = $connect->prepare($sql);
  $statement->execute();
  header("Location: ../work.php#usunDanie");
?>
