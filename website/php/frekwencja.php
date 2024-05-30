<?php
session_start();
$login = $_SESSION["login"];

if($login == ""){
  header("Location: ../noAccess.html");
}

$connect = mysqli_connect("localhost", "srv38973_dziennik", "password_here", "srv38973_dziennik");

if($connect === false){
  die("ERROR: Could not connect. " . mysqli_connect_error());
}

echo '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';

echo '
<link rel="icon" type="image/png" href="../assets/logo.png"/>
        <title>Gubru</title>
        <link rel="stylesheet" type="text/css" href="../style/style.css">
        <div class="loginDiv">
          Logged in as: '.$login.'
        </div> 
<div class="topDiv">
            <img src="../assets/logo.png" height="50px" width="50px"/>
                Gubru
            <button class="button" onclick='. "'". 'window.open("logout.php","_self")'. "'" .'>Log out</button>
</div>
<div class="menuDiv">
            <button class="menuButton" onclick='. "'". 'window.open("panel.php","_self")'. "'" .'>User panel</button>
            <button class="menuButton" onclick='. "'". 'window.open("ogloszenia.php","_self")'. "'" .'>Announcements</button>
            <button class="menuButton" onclick='. "'". 'window.open("poczta.php","_self")'. "'" .'>Mail</button>
            <button class="menuButton" onclick='. "'". 'window.open("plikiSzkoly.php","_self")'. "'" .'>School files</button>
            <button class="menuButton" onclick='. "'". 'window.open("zadania.php","_self")'. "'" .'>Homework</button>
            <button class="menuButton" onclick='. "'". 'window.open("terminarz.php","_self")'. "'" .'>Timetable</button>
            <button class="menuButton" onclick='. "'". 'window.open("frekwencja.php","_self")'. "'" .'>Absence</button>
            <button class="menuButton" onclick='. "'". 'window.open("recive.php","_self")'. "'" .'>Grades</button>
            ';
            if($_SESSION["uprawnienia"] >= 3){
              echo '
              <button class="menuButton" onclick='. "'". 'window.open("panelAdmin.php","_self")'. "'" .'>Principal panel</button>';
            }
            echo'
</div>
';


if($connect === false){
  die("ERROR: Could not connect. " . mysqli_connect_error());
}

$mojeId = $_SESSION["idUzy"];
$sql = "SELECT * 
FROM `frekwencja` 
WHERE `idUcznia` = $mojeId 
ORDER BY `frekwencja`.`Kiedy` DESC";

if($_SESSION["uprawnienia"] == 2){
  $sql = "SELECT * 
  FROM `frekwencja` 
  WHERE `idNauczyciela` = $mojeId 
  ORDER BY `frekwencja`.`Kiedy` DESC";
}else if ($_SESSION["uprawnienia"] >= 3){
  $sql = "SELECT * 
  FROM `frekwencja`  
  ORDER BY `frekwencja`.`Kiedy` DESC";
}

if(isset($_POST['submit']) && $_POST["jakoKto"] != "---" && $_POST["jakoKto"] != "") 
{
  if($_POST["jakoKto"] == "nauczyciel"){
    if ($_SESSION["uprawnienia"] >= 3){
      $sql = "SELECT * 
      FROM `frekwencja`  
      ORDER BY `frekwencja`.`Kiedy` DESC";
    }else{
      $sql = "SELECT * 
      FROM `frekwencja` 
      WHERE `idNauczyciela` = $mojeId 
      ORDER BY `frekwencja`.`Kiedy` DESC";
    }
  }else{
    $idUcznia = $_POST["klasy"];
    $sql = "SELECT * 
    FROM `frekwencja` 
    WHERE `idUcznia` = $idUcznia 
    ORDER BY `frekwencja`.`Kiedy` DESC";
  }
}

$result = $connect->query($sql);

?>

<script>
  function edytuj(a){
    var mHid = document.getElementById("nieMowNikomu");
    mHid.value = a;

    var x = document.getElementById("ocenyTable");
    var y = document.getElementById("edycjaFrekwencji");

    x.style.display = "none";
    y.style.display = "block";
  }

  function zamknij(){
    var x = document.getElementById("ocenyTable");
    var y = document.getElementById("edycjaFrekwencji");

    x.style.display = "block";
    y.style.display = "none";
  }

  function zmienFrekwencje(){
    var mHid = document.getElementById("nieMowNikomu");
    var idOc = mHid.value;

    var mHid1 = document.getElementById("optionD");
    var idOc1 = mHid1.value;

    var nowa = 0;
    switch(idOc1){
      case "present":
        nowa = 0;
        break;
      case "absent":
        nowa = 1;
        break;
      case "late":
        nowa = 2;
        break;
      case "exempt":
        nowa = 3;
        break;
      case "!!remove frequency!!":
        nowa = 4;
        break;
    }

    var url = "edytujFrekwencje.php/" + idOc + "/" + nowa;
    window.open(url);
    setTimeout(window.location.reload(true), 30000);

  }
</script>


<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

<div class="dziennikTop">Attendance</div>
<div class="formTermin">
  <form action="<?php echo $_SERVER["PHP_SELF"];?>" method="post" enctype="multipart/form-data" id="usrform">
  <center>
    <?php
      if($_SESSION["uprawnienia"] > 1){
        echo '<br>
        <select name="jakoKto" id="klasy" class="loginorregister" style="width: 33.3%;">
          <option value="---">---</option>
          <option value="nauczyciel">See as teacher</option>
          <option value="uczen">See as student: </option>
        </select>
        
        <select name="klasy" id="klasy" class="loginorregister" style="width: 33.3%;">
          <option value="---">---</option>
        ';

          $myId = $_SESSION["idUzy"];
          $sql2 = "SELECT `uczoneKlasy` FROM `uzytkownicy` WHERE `id` = $myId";

          if($_SESSION["uprawnienia"] >= 3){
            $temp = $_SESSION["idKlasy"];
            $sql2 = "SELECT * FROM `klasy` WHERE `idKlasy` = $temp";
            $result2 = $connect->query($sql2);
            $idSzkoly = "";
            
            if ($result2->num_rows > 0) {
              while($row2 = $result2->fetch_assoc()) {
                $idSzkoly = $row2["idSzkoly"];
              }
            }

            $sql4 = "SELECT * 
            FROM `uzytkownicy` 
            INNER JOIN `klasy`
            ON `uzytkownicy`.`idKlasy` = `klasy`.`idKlasy`
            WHERE `klasy`.`idSzkoly` = $idSzkoly";

            $result4 = $connect->query($sql4);

            if ($result4->num_rows > 0) {
              while($row1 = $result4->fetch_assoc()) {
                echo '<option value="'.$row1["id"].'">'.$row1["Imie"].' '.$row1["Nazwisko"].'</option>';
              }
            } 
          }else{

            $result2 = $connect->query($sql2);

            if ($result2->num_rows > 0) {
              while($row = $result2->fetch_assoc()) {
                $klasy = explode('&', $row["uczoneKlasy"]);
                $sql3 = "SELECT * FROM `uzytkownicy` WHERE `idKlasy` = ".$klasy[0];

                for($z = 0; $z < count($klasy); $z++){
                  $sql3 = $sql3 . " OR `idKlasy` = ". $klasy[$z];
                }

                $result3 = $connect->query($sql3);


                if ($result3->num_rows > 0) {
                  while($row1 = $result3->fetch_assoc()) {
                    echo '<option value="'.$row1["id"].'">'.$row1["Imie"].' '.$row1["Nazwisko"].'</option>';
                  }
                }    


              }
            }
          }
          echo '
          </select>
          <br><input value="Filter" type="submit" name="submit" class="Loginbutton" style="width: 66.6%;">

          ';
      }
    ?>
  </center>
  </form>
</div>
<div id="ocenyTable"><table class="oceny" border="1">
<thead>
  <tr><th class="dataFrekwe">Date</th><th class="nieobeFrekwe">Attendance</th></tr>


<?php
$result4 = $connect->query($sql);
$typyNieo = array('present', 'absent', 'late', 'exempt');
$kolory = array('#00b300', '#800000', '#999900', '#0033cc');

if ($result4->num_rows > 0) {
  $prevDate;
  while($row2 = $result4->fetch_assoc()) {
    $temp = strtotime($row2["Kiedy"]);
    $date = date('Y-m-d H:i:s', $temp);

    if($prevDate != $temp){
      echo '</th></tr><tr><th>'.date('Y-m-d', $temp).'</th><th>';
      
      if($_SESSION["uprawnienia"] > 1){
        echo '<button class="nieobecnosc" style="background-color: '.$kolory[$row2["Typ"]].';" onclick="edytuj('.$row2["id"].')">'.$typyNieo[$row2["Typ"]]." (".date('H:i', $temp).")</button>";
      }else{
        echo '<div class="nieobecnosc" style="background-color: '.$kolory[$row2["Typ"]].';">'.$typyNieo[$row2["Typ"]]." (".date('H:i', $temp).")</div>";
      }

      $prevDate = $temp;
    }else{
      if($_SESSION["uprawnienia"] > 1){
        echo '<button class="nieobecnosc" style="background-color: '.$kolory[$row2["Typ"]].';" onclick="edytuj('.$row2["id"].')">'.$typyNieo[$row2["Typ"]]." (".date('H:i', $temp).")</button>";
      }else{
        echo '<div class="nieobecnosc" style="background-color: '.$kolory[$row2["Typ"]].';">'.$typyNieo[$row2["Typ"]]." (".date('H:i', $temp).")</div>";
      }    }
  }
}

?>

</thead>
</table></div>


<div id="edycjaFrekwencji" style="display: none;">
  <div  class="loginForm">
    <button onclick="zamknij()" class="closeBtn">X</button><br>
    <input type="text" id="nieMowNikomu" name="nrEdycji" style="display: none;">
    
    Nowy typ frekwencji:<br>
    <select name="optionD" class="loginorregister" id="optionD">
      <option>present</option>
      <option>absent</option>
      <option>late</option>
      <option>exempt</option>
      <option style="background-color: red; color: white;">!!remove frequency!!</option>
    </select>

    <button onclick="zmienFrekwencje()" class="Loginbutton">Edit</button>
  </div>
</div>