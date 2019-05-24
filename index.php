<?php include 'header.php'; ?>
<style>
<?php include 'main.css'; ?>
</style>
<script type="text/javascript">
  var obecne_id = 0;
  function zmienOpis(id){
    console.log("zmieniam");
    document.getElementById("tab-"+obecne_id).classList.add("d-none");
    document.getElementById("btn-"+obecne_id).classList.add("d-none");
    document.getElementById("tab-"+id).classList.remove("d-none");
    document.getElementById("btn-"+id).classList.remove("d-none");
    obecne_id = id;
  }

</script>
<div class = "row">
  <div class = "col-5 pt-5 pb-5">
    Między jednym meetingiem, a kolejnym treningiem i motywacyjnym coachingiem
    jakby mało jest czasu na gotowanie, nieprawda? Nie szkodzi. My mamy czas. I wiedzę.
    Wiemy, jak policzyć te cholerne kalorie i dopasować dietę, żeby wszystkie Twoje zabiegi,
    by zyskać życiową formę, nie poszły na marne. My, czyli doświadczeni dietetycy i renomowani kucharze.
    Wybierz więc swój program i przekonaj się, jak pysznie być fit. Bo, jak twierdzą znawcy:<br>
    <span class = "font-italic font-weight-bold"><h1>you're never too much fit</h1></span>
  </div>
  <div class = "col-7 d-none d-sm-block">
    <img src = "img/45332.png"  class = "img-responsive  pl-5 py-4 ml-5" width="400">
  </div>
</div>
<div class = "container" id="diety">
  <div class = "row" id="dietyHeader">
    <div class = "col-12 text-center display-4"> Nasze diety</div>
  </div>
  <div class = "row">
    <div class = "col-3 text-center">
      <table class = "table table-hover">
        <thead>
          <tr>
            <th>Nazwa</th>
          </tr>
        </thead>
        <tbody>
          <?php
            include 'config.php';
            $connect = new PDO($servername, $username, $password, $options);
            $sql = sprintf("SELECT id_diety, nazwa, opis FROM diety");
            $statement = $connect->prepare($sql);
            $statement->execute();
            $result = $statement->fetchAll();
            $i = 0;
            foreach ($result as $row) {
              $nazwy[$i] = $row['nazwa'];
              $opisy[$i] = $row['opis'];
              echo "<tr>";
              echo "<td onclick='zmienOpis(".$i.")'>".$row['nazwa']."</td>";
              echo "</tr>";
              $i += 1;
            }
          ?>
        </tbody>
      </table>
    </div>
    <div class = "col-9" id = "opis">
      <?php
          for($j = 0; $j < $i; $j++){
            echo "<section id='tab-".$j."' class='align_justify tab d-none'><div class='row'><div class='col-12 display-4'>".$nazwy[$j]."</div></div><div class='col-10'>".$opisy[$j]."</div></section>";
            echo "<a id='btn-".$j."' href='dieta.php?id=".$j."' class='btn btn-sm btn-outline-secondary d-none'>Czytaj więcej</a>";
          }
      ?>
      <script>
        zmienOpis(0);
      </script>
    </div>
  </div>
</div>
<?php include 'footer.php'; ?>
