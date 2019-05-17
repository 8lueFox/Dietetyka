<?php include 'header.php'; ?>
<style><?php include 'main.css'; ?></style>
<?php
  $idDiety = $_GET['id'] + 1;
  include 'config.php';
  $connect = new PDO($servername, $username, $password, $options);
  $sql = sprintf("SELECT * FROM diety WHERE id_diety = $idDiety");
  $idDiety -=1;
  $statement = $connect->prepare($sql);
  $statement->execute();
  $result = $statement->fetchAll();
  if($result){
    foreach ($result as $row) {
      $result = $row;
    }
  }
?>
<div class = "row">
  <div class = "col-12 display-2 text-center"><?php echo "Dieta: ".$result['nazwa'];?></div>
</div>
<div class = "row">
  <div class = "col-3"></div>
  <div class = "col-5 align_justify"><?php echo $result['opis'];?></div>
  <div class = "col-4 text-center">
    <label>Kup teraz<br> JEDYNIE za<br><b> <?php echo $result['cena'];?></b><br> za miesiąc.</label><br>
    <a href='buy.php' class='btn btn-sm btn-outline-secondary'>KUP TERAZ</a>
  </div>
</div>
<div class = "row py-5">
  <div class = "col-12 text-center display-4">
    <span id = "pasek">Komentarze</span>
  </div>
</div>
<form action="sendComment.php" method="post">
    <div class="form-group col-10">
        <label for="comment"><b>Comment:</b></label>
        <textarea class="form-control" rows="3" name="comment" id="comment"></textarea>
    </div>
    <div class="col-2">
    <input type="hidden" id="idDiety" name="idDiety" value="<?php echo $idDiety?>">
    <?php
      if(isset($_SESSION['login'])){
        echo '<input type="submit" name="submit" value="Dodaj komentarz" class="btn btn-sm btn-outline-secondary">';
      } else {
        echo '<input type="button" name="" value="Musisz być zalogowany" class="btn btn-sm btn-outline-secondary disabled ">';
      }?>
        </div>
</form>
<?php
  include 'config.php';
  $sql = sprintf("select u.login, o.tekst from opinie as o inner join uzytkownicy as u on o.id_user = u.id_uzytkownika where o.id_diety=$idDiety");
  $statement = $connect->prepare($sql);
  $statement->execute();
  $result = $statement->fetchAll();
  foreach ($result as $row) {
    echo "<div class='col-2'></div>";
    echo "<div class='col-8 py-2'><div class='col-3'><b>".$row['login']."</b></div><div class='col-12'>".$row['tekst']."</div></div>";
    echo "<span id='pasek'></span>";
    echo "<div class='col-2'></div>";
  }
?>

<?php include 'footer.php'; ?>
