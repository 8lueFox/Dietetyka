<?php include 'header.php' ?>
<style><?php include 'main.css' ?></style>
<div class = "container">
  <div class = "row">
    <div class = "col-3"></div>
      <div class = "col-6 my-5">
        <form method="post" id="formularz">
          <div class="form-group">
  	       <label for="login">Login:</label>
  	       <input type="text" name="login" id="login" class="form-control" placeholder="Wprowadź login">
          </div>
          <div class="form-group">
  	       <label for="pwd">Hasło:</label>
  	       <input type="password" name="password" id="password" class="form-control" placeholder="Wprowadź hasło">
          </div>
          <div class="form-group">
  	       <label for="name">Imie:</label>
  	       <input type="text" name="name" id="name" class="form-control" placeholder="Wprowadź imię">
          </div>
          <div class="form-group">
  	       <label for="surname">Nazwisko:</label>
  	       <input type="text" name="surname" id="surname" class="form-control" placeholder="Wprowadź Nazwisko">
          </div>
          <div class="form-group">
  	       <label for="email">Email:</label>
  	       <input type="email" name="email" id="email" class="form-control" placeholder="Wprowadź email">
          </div>
          <div class="form-group">
  	       <label for="login">Data urodzenia:</label>
  	       <input type="data" name="data" id="data" class="form-control" placeholder="Wprowadź datę urodzin(RRRR-MM-DD)">
          </div>
          <span id="loginError"></span>
  	      <input type="submit" name="submit" value="Zarejestruj się" class="btn btn-sm btn-outline-secondary">
        </form>
      </div>
    <div class = "col-3"></div>
  </div>
</div>
<?php
  if (isset($_POST['submit'])){
    include 'config.php';
    $connect = new PDO($servername, $username, $password, $options);
    $login = $_POST['login'];
    $password = $_POST['password'];
    $name = $_POST['name'];
    $surname = $_POST['surname'];
    $email = $_POST['email'];
    $data = $_POST['data'];
    $plec = 'M';
    if(substr($name, -1) == 'a')
      $plec = 'K';
    $sql = sprintf("INSERT INTO uzytkownicy VALUES (NULL,'$name','$surname','$email',' ',' ',' ',' ','$data','$plec','$login','$password',0)");
    $statement = $connect->prepare($sql);
    $statement->execute();
    $sql = sprintf("SELECT * FROM uzytkownicy WHERE login = '$login'");
    $state = $connect->prepare($sql);
    $state->execute();
    $result = $state->fetchAll();
    if($result){
      foreach ($result as $row) {
        if($row['password'] == $password){
          $_SESSION['login'] = $login;
          ?>
          <script>
            document.getElementById('formularz').innerHTML = "<h1 class = 'text-center'>Zostałeś zalogowany</h1>";
          </script>
          <?php
        }
      }
    }else{
        ?>
        <script>
          document.getElementById('loginError').innerHTML = "Problem z logowaniem<br>";
        </script>
        <?php
      }
    }
?>

<?php include 'footer.php' ?>
