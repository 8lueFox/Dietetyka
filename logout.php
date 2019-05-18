<?php
session_start();
unset($_SESSION['login']);
unset($_SESSION['pracownik']);
header("Location: index.php");
?>
