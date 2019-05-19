<?php
session_start();
if(isset($_SESSION['pracownik'])){
  include '../config.php';
  $connect = new PDO($servername, $username, $password, $options);
  $sql = "DELETE FROM opinie WHERE id_opinii = ".$_GET['id'];
  $statement = $connect->prepare($sql);
  $statement->execute();
  header("Location: ../dieta.php?id=".($_GET['idD']-1));
}
?>
