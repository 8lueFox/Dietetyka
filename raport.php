<?php include 'header.php' ?>
<style><?php include 'main.css'?></style>
<div class="row">
  <div class="col-3"></div>
  <div class="col-2">
    <form action="" method="post">
      <div class="form-check">
        <input class="form-check-input" type="radio" name="which" value="1" checked>
        <label>Raport dzienny</label>
      </div>
      <div class="form-check">
        <input class="form-check-input" type="radio" name="which" value="2">
        <label>Raport miesięczny</label>
      </div>
      <div class="form-check">
        <input class="form-check-input" type="radio" name="which" value="3">
        <label>Raport roczny</label>
      </div>
      <input type="submit" name="submit" value="Pokaż" class="btn btn-sm btn-outline-secondary my-2 pl-5 pr-5 ml-2">
    </form>
  </div>
</div>
<div class="row">
  <?php
    if(isset($_POST['submit'])){
      $today = date("Y-m-d");
      if($_POST['which'] == "1"){
        $today2 = $today;
        echo "<span class='col-12 text-center py-3'>Raport dzienny na dzień $today</span>";
      }else if($_POST['which'] == "2"){
        $today2 = date("Y-m-d", strtotime($today . '-30 day'));
        echo "<span class='col-12 text-center py-3'>Raport miesięczny $today2 - $today</span>";
      }else if($_POST['which'] == "3"){
        $today2 = date("Y-m-d", strtotime($today . '-365 day'));
        echo "<span class='col-12 text-center py-3'>Raport roczny $today2 - $today</span>";
      }

      $sql = sprintf("SELECT count(id_opinii) as ilosc from opinie where data_wstawienia BETWEEN '$today2' AND '$today'");
      $statement = $connect->prepare($sql);
      $statement->execute();
      $result = $statement->fetchAll();
      foreach($result as $row)
      echo "<span class='col-2'>
        Ilość wystawionych komentarzy:<b>".$row['ilosc']."</b>
      </span>";
      $sql = sprintf("SELECT count(id_uzytkownika) as ilosc from uzytkownicy where data_zarejestrowania BETWEEN '$today2' AND '$today'");
      $statement = $connect->prepare($sql);
      $statement->execute();
      $result = $statement->fetchAll();
      foreach($result as $row)
      echo "<span class='col-2'>
        Ilość zarejestrowanych użytkowników:<b>".$row['ilosc']."</b>
      </span>";
      $sql = sprintf("SELECT count(id_zamowienia) as ilosc from zamowienia where czas_kupna BETWEEN '$today2' AND '$today'");
      $statement = $connect->prepare($sql);
      $statement->execute();
      $result = $statement->fetchAll();
      foreach($result as $row)
      echo "<span class='col-2'>
        Ilość sprzedanych diet:<b>".$row['ilosc']."</b>
      </span>";
      $sql = sprintf("SELECT sum(datediff(czas_ostatniej_wysylki+1,czas_kupna)) as ilosc from zamowienia where czas_ostatniej_wysylki BETWEEN '$today2' AND '$today' AND czas_kupna <= czas_ostatniej_wysylki;");
      $statement = $connect->prepare($sql);
      $statement->execute();
      $result = $statement->fetchAll();
      foreach($result as $row)
      echo "<span class='col-2'>
        Ilość wysłanych diet:<b>".$row['ilosc']."</b>
      </span>";
      $today = date("Y-m-d", strtotime($today . '+1 day'));
      $sql = sprintf("SELECT sum(round(d.cena/30*(datediff(czas_zakonczenia,czas_kupna)+1),2)) as cena FROM zamowienia AS z INNER JOIN diety as d on z.id_diety = d.id_diety WHERE czas_kupna BETWEEN '$today2' AND '$today'");
      $statement = $connect->prepare($sql);
      $statement->execute();
      $result = $statement->fetchAll();
      foreach($result as $row){
        if($row['cena'] === NULL)
          $row['cena'] = 0;
        echo "<span class='col-2'>
          Zarobione pieniądzę:<b> ".$row['cena']."zł</b>
        </span>";
      }
      echo "<div class='row'>";
        echo "<span class='col-6'>";
          echo "<table class='table table-striped'>";
            echo "<thead><tr><th>Nazwa</th><th>Sprzedana ilość</th><th>Zarobiona kwota</th></thead>";
            echo "<tbody>";
              $sql = sprintf("SELECT count(czas_kupna) as ilosc, nazwa, sum(round(cena/30*(datediff(czas_zakonczenia,czas_kupna)+1),2)) as cena from zamowienia natural join diety where czas_kupna between '$today2' and '$today' group by id_diety;");
              $statement = $connect->prepare($sql);
              $statement->execute();
              $result = $statement->fetchAll();
              if($result)
                foreach ($result as $row) {
                  echo "<tr><td class='text-center'>".$row['nazwa']."</td><td class='text-center'>".$row['ilosc']."</td><td class='text-center'>".$row['cena']."</td></tr>";
                }
              else
                echo "<tr><td class='text-center'>0</td><td class='text-center'>0</td><td class='text-center'>0</td></tr>";
            echo "</tbody>";
          echo "</table>";
        echo "</span>";
      echo "</div>";
    }
  ?>
</div>
<?php
  include 'config.php';
  $connect = new PDO($servername, $username, $password, $options);
  $today = date("Y-m-d");

?>
<?php include 'footer.php'?>
