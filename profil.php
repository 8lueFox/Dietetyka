<?php include 'header.php' ?>
<style><?php include 'main.css' ?></style>
<div class='row'>
  <div class='col-3 py-5 display-4'><b>
    <?php echo $_SESSION['login']; ?>
  </b></div>
</div>
<div class="row">
  <div class="col-sm-12 col-md-4">
    <b>Twoje dane osobowe:</b>
    <ul class="list-group">
    <?php
    include 'config.php';
    $connect = new PDO($servername, $username, $password, $options);
    $login = $_SESSION['login'];
    $sql = sprintf("SELECT * FROM uzytkownicy WHERE login = '$login'");
    $statement = $connect->prepare($sql);
    $statement->execute();
    $result = $statement->fetchAll();
    foreach($result as $row){
      echo "<li class='list-group item'>Imie: <span class='bold pl-3'>".$row['imie']."</span></li>";
      echo "<li class='list-group item'>Nazwisko: <span class='bold pl-3'>".$row['nazwisko']."</span></li>";
      echo "<li class='list-group item'>Email: <span class='bold pl-3'>".$row['email']."</span></li>";
      echo "<li class='list-group item'>Data urodzenia: <span class='bold pl-3'>".$row['data_urodzenia']."</span></li>";
      echo "<li class='list-group item'>Płeć: <span class='bold pl-3'>".$row['plec']."</span></li>";
      echo "<li class='list-group item'>Data zarejestrowania się: <span class='bold pl-3'>".$row['data_zarejestrowania']."</span></li>";
    }
    ?>
    </ul>
  </div>
  <div class="col-sm-12 col-md-4 ">
    <b>Twoja dieta: </b>
    <?php
      $today = date("Y-m-s");
      $sql = sprintf("select nazwa, round(cena/30*(datediff(czas_zakonczenia,czas_kupna)+1),2) as cena, czas_kupna, czas_zakonczenia
      from zamowienia natural join diety
      where id_user = (select id_uzytkownika from uzytkownicy where login = '$login')
        and czas_zakonczenia >= '$today';");
      $statement = $connect->prepare($sql);
      $statement->execute();
      $result = $statement->fetchAll();
      if($result){
        echo '<ul class="list-group">';
        foreach($result as $row){
          echo "<li class='list-group item'>Nazwa: <span class='bold pl-3'>".$row['nazwa']."</span></li>";
          echo "<li class='list-group item'>Cena: <span class='bold pl-3'>".$row['cena']."zł</span></li>";
          echo "<li class='list-group item'>Data kupna: <span class='bold pl-3'>".$row['czas_kupna']."</span></li>";
          echo "<li class='list-group item'>Data zakończenia: <span class='bold pl-3'>".$row['czas_zakonczenia']."</span></li>";
        }
        echo '</ul>';
      }
    ?>
  </div>
  <div class="col-sm-12 col-md-4">
    <b>Twoje miejsce dostawy:</b>
    <ul class="list-group">
    <?php
      $sql = sprintf("SELECT * FROM uzytkownicy WHERE login = '$login'");
      $statement = $connect->prepare($sql);
      $statement->execute();
      $result = $statement->fetchAll();
      foreach($result as $row){
        if(empty($row['nr_mieszkania']))
          $row['nr_mieszkania'] = "-----";
        echo "<li class='list-group item'>Miasto: <span class='bold pl-3'>".$row['miasto']."</span></li>";
        echo "<li class='list-group item'>Ulica: <span class='bold pl-3'>".$row['ulica']."</span></li>";
        echo "<li class='list-group item'>Numer domu: <span class='bold pl-3'>".$row['nr_domu']."</span></li>";
        echo "<li class='list-group item'>Numer mieszkania: <span class='bold pl-3'>".$row['nr_mieszkania']."</span></li>";
      }
    ?>
    </ul>
  </div>
</div>
<?php include 'footer.php' ?>
