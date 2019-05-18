<?php include 'header.php';?>
<style><?php include 'main.css';?></style>
<div class = "row">
  <div class = "col-12 text-center py-2"><h2>
    <?php
        $idDiety = $_GET['id'];
        include 'config.php';
        $connect = new PDO($servername, $username, $password, $options);
        $sql = sprintf("SELECT * FROM diety WHERE id_diety = ($idDiety+1)");
        $statement = $connect->prepare($sql);
        $statement->execute();
        $result = $statement->fetchAll();
        foreach ($result as $row) {
          $result = $row;
        }
        echo $result['nazwa'];
    ?></h2>
  </div>
</div>
<div class = "row">
  <div class = "col-4 text-center">
    <h5 class = "text-center">Co zjesz w diecie <?php echo $result['nazwa'];?> </h5>
    <?php
      $sql = sprintf("SELECT nazwa FROM dieta_danie AS dd INNER JOIN dania AS d ON dd.id_dania = d.id_dania WHERE id_diety = ($idDiety+1);");
      $statement = $connect->prepare($sql);
      $statement->execute();
      $res = $statement->fetchAll();
      echo "<ul class='list-group'>";
      foreach($res as $row){
        echo "<li class='list-group item'>-".$row['nazwa']."</li>";
      }
      echo "</ul>";
    ?>
  </div>
  <div class = "col-4 text-center">
    <form action="zamowienie.php" method="post">
      <div class='form-group'>
        <label for='sel1'>Okres zamówienia:</label>
        <select class='form-control' id='sel1' name='czas'>
          <option value='1'>1 tydzień</option>
          <option value='2'>2 tygodnie</option>
          <option value='3'>3 tygodnie</option>
          <option value='4'>4 tygodnie</option>
        </select>
      </div>
      <div class='form-group'>
        <label for='sel2'>Dokąd dostarczać:</label>
        <input type='text' class='form-control' placeholder="Miasto" name='miasto' id='miasto'>
        <input type='text' class='form-control' placeholder="Ulica" name='ulica'>
        <input type='text' class='form-control' placeholder="Numer domu" name='nrdomu'>
        <input type='text' class='form-control' placeholder="Numer mieszkania" name='nrmieszkania'>
      </div>
      <input type="hidden" name="idDiety" value="<?php echo $idDiety;?>">
      <?php
        if(!isset($_SESSION['login'])){
          echo '<input type="button" name="" value="Musisz być zalogowany" class="btn btn-primary disabled">';
        }else{
       ?>
      <input type="submit" name="submit" value="Zamawiam" class="btn btn-primary"><?php }?>
    </form>
  </div>
</div>
<?php include 'footer.php';?>
