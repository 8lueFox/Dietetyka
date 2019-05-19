<?php
session_start();
?>
<!DOCTYPE html>
<html lang="pl" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Dietetyka online</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </head>
  <body>
    <div class = "container">
      <header class =  "blog-header py-3">
        <div class = "row">
          <div class = "col-4 pt-2 text-success"><h2>Change your life!</h2></div>
          <div class = "col-4 display-4 text-center">Dietetyka online</div>
          <div class = "col-3"></div>
          <div class = "col-1 justify-content-end pt-2">
            <?php
            if(isset($_SESSION['login'])){
              echo "Witaj, <b><a href='profil.php'>".$_SESSION['login']."</a></b>";
              echo '<a class = "btn btn-sm btn-outline-secondary" href = "logout.php">Logout</a>';
            }
              else{
                echo '<a class = "btn btn-sm btn-outline-secondary" href = "login.php">Sign up</a>';
              }
            ?>
          </div>
        </div>
      </header>

      <div class = "nav-scroller">
        <nav class = "nav d-flex justify-content-between">
          <a class = "p-2 nav_span" href = "index.php"><h4>Home</h4></a>
          <a class = "p-2 nav_span" href = "index.php#diety"><h4>Diety</h4></a>
          <a class = "p-2 nav_span" href = "kontakt.php"><h4>Kontakt</h4></a>
          <?php
            if(isset($_SESSION['login'])){
              include 'config.php';
              $connect = new PDO($servername, $username, $password, $options);
              $login = $_SESSION['login'];
              $sql = sprintf("SELECT pracownik FROM uzytkownicy WHERE login = '$login'");
              $statement = $connect->prepare($sql);
              $statement->execute();
              $result = $statement->fetchAll();
              foreach($result as $row){
                if($row['pracownik'] == 1 | $row['pracownik'] == 2){
                  echo '<a class = "p-2 nav_span" href = "work.php"><h4>Pracuj</h4></a>';
                  $_SESSION['pracownik'] = $row['pracownik'];
                }
              }
            }
          ?>
        </nav>
      </div>
      <div class = "row">
        <div class = "col-12">
          <span id = "pasek"></span>
        </div>
      </div>
