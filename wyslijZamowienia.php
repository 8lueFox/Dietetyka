<?php include 'header.php' ?>
<style><?php include 'main.css'?></style>
<?php
  include 'config.php';
  $connect = new PDO($servername, $username, $password, $options);
  $today = date("Y-m-d");
  $sql = sprintf("
    SELECT zam.id_zamowienia, users.imie, users.nazwisko,diety.nazwa, users.miasto, users.ulica, users.nr_domu, users.nr_mieszkania
    FROM zamowienia as zam inner join uzytkownicy as users on zam.id_user = users.id_uzytkownika inner join diety on zam.id_diety = diety.id_diety
    WHERE czas_ostatniej_wysylki != '$today' AND
    czas_zakonczenia >= '$today'
    order by diety.nazwa;
  ");
  $statement = $connect->prepare($sql);
  $statement->execute();
  $result = $statement->fetchAll();
  $i = 0;
  echo '<form method="post">';
  echo "<table class='table table-striped'>";
  echo "<thead><tr><th>Firstname</th><th>Lastname</th><th>Diet</th><th>City</th><th>Street</th><th>House number</th><th>Apartment number</th><th>Sent</th></thead><tbody>";
  foreach ($result as $row) {
    echo "<tr>
      <td>".$row['imie']."</td><td>".$row['nazwisko']."</td><td>".$row['nazwa']."</td><td>".$row['miasto']."</td><td>".$row['ulica']."</td><td>".$row['nr_domu']."</td><td>".$row['nr_mieszkania']."</td>
      <td><input type='checkbox' name=".$row['id_zamowienia']." value='ok'></td>
    </tr>";
    $zam[$i] = $row['id_zamowienia'];
    $i++;
  }
  echo "</tbody></table>";
?>
<input type="submit" name="submit" value="Done" class="btn btn-sm btn-outline-secondary"></form>

<?php
  if(isset($_POST['submit'])){
    for($k = 0; $k < $i; $k++){
      if(!empty($_POST[$zam[$k]])){
        $sql = "UPDATE zamowienia SET czas_ostatniej_wysylki = '$today' WHERE id_zamowienia = $zam[$k]";
        $statement = $connect->prepare($sql);
        $statement->execute();
        header("Location: wyslijZamowienia.php");
      }
    }
  }
?>
<?php include 'footer.php'?>
