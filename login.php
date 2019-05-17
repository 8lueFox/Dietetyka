<?php include 'header.php' ?>
<style><?php include 'main.css' ?></style>
<div class = "container">
  <div class = "row">
    <div class = "col-3"></div>
      <div class = "col-6 my-5">
        <form method="post">
          <div class="form-group">
  	       <label for="login">Login:</label>
  	       <input type="text" name="login" id="login" class="form-control" placeholder="Wprowadź login">
          </div>
          <div class="form-group">
  	       <label for="pwd">Hasło:</label>
  	       <input type="password" name="password" id="password" class="form-control" placeholder="Wprowadź hasło">
          </div>
          <span id="loginError"></span>
  	      <input type="submit" name="submit" value="Zaloguj" class="btn btn-sm btn-outline-secondary">
        </form>
        <h6><a href = "register.php">Nie masz konta? Zarejestruj się!<a></h6>
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
    $sql = sprintf("SELECT * FROM uzytkownicy WHERE login = :login");
    $statement = $connect->prepare($sql);
    $statement->bindParam(':login', $login , PDO::PARAM_STR);
    $statement->execute();
    $result = $statement->fetchAll();
    if($result){
      foreach ($result as $row) {
        if($row['password'] == $password){
          $_SESSION['login'] = $login;
          header("Location: index.php");
          exit;
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
