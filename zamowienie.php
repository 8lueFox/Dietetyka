<?php
session_start();
$idDiety = $_POST['idDiety'];
$miasto = $_POST['miasto'];
$ulica = $_POST['ulica'];
$nrdomu = $_POST['nrdomu'];
$nrmieszkania = $_POST['nrmieszkania'];
$czas = $_POST['czas'];
$login = $_SESSION['login'];
include 'config.php';
$connect = new PDO($servername, $username, $password, $options);
$sql = sprintf("UPDATE uzytkownicy SET miasto = '$miasto' , ulica = '$ulica', nr_domu = '$nrdomu', nr_mieszkania = '$nrmieszkania' WHERE login = '$login'");
$statement = $connect->prepare($sql);
$statement->execute();
$today = date("Y-m-d");
$today = date("Y-m-d", strtotime($today . '+1 day'));
if($czas == 1){
  $stop_day = date("Y-m-d", strtotime($today . '+7 day'));
}else if($czas == 2){
  $stop_day = date("Y-m-d", strtotime($today . '+14 day'));
}else if($czas == 3){
  $stop_day = date("Y-m-d", strtotime($today . '+21 day'));
}else if($czas == 4){
  $stop_day = date("Y-m-d", strtotime($today . '+30 day'));
}
$sql = sprintf("INSERT INTO zamowienia VALUES (NULL, (SELECT id_uzytkownika FROM uzytkownicy WHERE login = '$login'), ($idDiety+1), '$today', '$stop_day', '$today');");
$statement = $connect->prepare($sql);
$statement->execute();
header("Location: index.php")
?>
