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
      $sql = sprintf("SELECT count(id_zamowienia) as ilosc from zamowienia where czas_ostatniej_wysylki BETWEEN '$today2' AND '$today' AND czas_kupna <= czas_ostatniej_wysylki");
      $statement = $connect->prepare($sql);
      $statement->execute();
      $result = $statement->fetchAll();
      foreach($result as $row)
      echo "<span class='col-2'>
        Ilość wysłanych diet:<b>".$row['ilosc']."</b>
      </span>";
    }
  ?>
</div>
<?php
  include 'config.php';
  $connect = new PDO($servername, $username, $password, $options);
  $today = date("Y-m-d");

?>
<?php include 'footer.php'?>
