<?php
  session_start();
  include 'config.php';
  $connect = new PDO($servername, $username, $password, $options);
  $comment = $_POST['comment'];
  $idDiety = $_POST['idDiety'];
  $login = $_SESSION['login'];

  $re = '/kurcze|motyla noga|kurza twarz|psiakość/m';
  $str = mb_strtolower($comment);

  preg_match_all($re, $str, $matches, PREG_SET_ORDER, 0);

  if(sizeof($matches) == 0){
    $date = date("Y-m-d");
    $sql = sprintf("INSERT INTO opinie values(NULL,(SELECT id_uzytkownika FROM uzytkownicy WHERE login = '$login'),'$idDiety','$comment','$date')");
    $statement = $connect->prepare($sql);
    $statement->execute();
  }
  $idDiety -=1;
  header("Location: dieta.php?id=$idDiety");
?>
