<?php
  session_start();
  include 'config.php';
  $connect = new PDO($servername, $username, $password, $options);
  $comment = $_POST['comment'];
  $idDiety = $_POST['idDiety'];
  $login = $_SESSION['login'];
  $sql = sprintf("INSERT INTO opinie values(NULL,(SELECT id_uzytkownika FROM uzytkownicy WHERE login = '$login'),'$idDiety','$comment')");
  $statement = $connect->prepare($sql);
  $statement->execute();
  header("Location: dieta.php?id=$idDiety");
?>
