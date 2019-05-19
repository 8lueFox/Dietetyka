<?php include "header.php" ?>
<style><?php include "main.css" ?></style>
<?php if(!isset($_SESSION['pracownik']) || !isset($_SESSION['login'])) header("Location: index.php")?>
  <div class="row py-3">
  <?php if($_SESSION['pracownik'] == 2){
    echo'
    <span class="col-sm-12 col-md-4 py-2 text-center border border-succes">
      <label>Nadaj uprawnienia</label>
      <form method="post" action="work/nadajUprawnienia.php">
        <label>Login: </label>
        <input type="text" name="login" class="form-control" placeholder="Wprowadź login nowego pracownika">
        <input type="submit" name="submit" value="Nadaj uprawnienia" class="btn btn-sm btn-outline-secondary my-2">
      </form>
    </span>
    ';
  }?>
  <?php if($_SESSION['pracownik'] == 1){
    echo'
  <span class="col-sm-12 col-md-4 py-2 text-center border border-succes">
    <label>Dodaj produkt</label>
    <form method="post" action="work/dodajProdukt.php">
      <label>Nazwa produktu: </label>
      <input type="text" name="nazwa" class="form-control" placeholder="Wprowadź nazwe produktu">
      <input type="submit" name="submit" value="Dodaj produkt" class="btn btn-sm btn-outline-secondary my-2">
    </form>
  </span>';
}?>
<?php if($_SESSION['pracownik'] == 1){
  echo'
  <span class="col-sm-12 col-md-4 py-2 text-center border border-succes">
    <label>Dodaj dietę</label>
    <form method="post" action="work/dodajDiete.php">
      <label>Nazwa diety: </label>
      <input type="text" name="nazwa" class="form-control" placeholder="Wprowadź nazwę diety">
      <input type="text" name="cena" class="form-control" placeholder="Wprowadź cenę diety">
      <input type="text" name="kalorycznosc" class="form-control" placeholder="Wprowadź kaloryczność diety">
      <textarea class="form-control" rows="3" name="opis" id="opis" placeholder="Wprowadź opis diety"></textarea>
      <label>Dania w diecie:</label>
      <select multiple class="form-control" name="dania[]">';
        include 'config.php';
        $connect = new PDO($servername, $username, $password, $options);
        $sql = sprintf("SELECT * FROM dania");
        $statement = $connect->prepare($sql);
        $statement->execute();
        $result = $statement->fetchAll();
        foreach($result as $row){
          $id = $row['id_dania'];
          $nazwa = $row['nazwa'];
          echo "<option value='$id'>$nazwa</option>";
        }
      echo '
      </select>
      <input type="submit" name="submit" value="Dodaj dietę" class="btn btn-sm btn-outline-secondary my-2">
    </form>
  </span>';
}?>
<?php if($_SESSION['pracownik'] == 1){
  echo'
  <span class="col-sm-12 col-md-4 py-2 text-center border border-succes">
    <label>Dodaj danie</label>
    <form method="post" action="work/dodajDanie.php">
      <label>Nazwa dania: </label>
      <input type="text" name="nazwa" class="form-control" placeholder="Wprowadź nazwę dania">
      <label>Produkty potrzebne do dania:</label>
      <select multiple class="form-control" name="produkty[]">';
        include 'config.php';
        $connect = new PDO($servername, $username, $password, $options);
        $sql = sprintf("SELECT * FROM produkty");
        $statement = $connect->prepare($sql);
        $statement->execute();
        $result = $statement->fetchAll();
        foreach($result as $row){
          $id = $row['id_produktu'];
          $nazwa = $row['nazwa'];
          echo "<option value='$id'>$nazwa</option>";
        }
        echo'
      </select>
      <input type="submit" name="submit" value="Dodaj danie" class="btn btn-sm btn-outline-secondary my-2">
    </form>
  </span>';

}?>
<?php if($_SESSION['pracownik'] == 1){
  echo'
  <span class="col-sm-12 col-md-4 py-2 text-center border border-succes">
    <label class="display-3">Dzienne zamówienia</label>
    <a href="wyslijZamowienia.php" class="btn btn-sm btn-outline-secondary">Wyślij zamówienia</a>
  </span>';}?>
  <?php if($_SESSION['pracownik'] == 2){
    echo'
  <span class="col-sm-12 col-md-4 py-2 text-center border border-succes">
    <label class="display-3">Raporty</label><br>
    <a href="raport.php" class="btn btn-sm btn-outline-secondary">Pokaż raport</a>
  </span>
  </div>';}?>

<?php include "footer.php"?>
