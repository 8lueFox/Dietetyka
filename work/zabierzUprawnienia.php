<?php
  session_start();
  $login = $_POST['login'];
  include '../config.php';
  $connect = new PDO($servername, $username, $password, $options);
  $sql = sprintf("UPDATE uzytkownicy SET pracownik = 0 WHERE login = '$login'");
  $statement = $connect->prepare($sql);
  $statement->execute();
  header("Location: ../work.php");
?>
