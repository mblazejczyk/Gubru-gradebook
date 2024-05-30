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

$idKlasy = $_SESSION["idKlasy"];
$sql = "SELECT `terminarz`.`id`, `terminarz`.`idKlasy`, `terminarz`.`termin`, `terminarz`.`nazwa`, `terminarz`.`komentarz`, `terminarz`.`idNauczyciela`, `uzytkownicy`.`Imie`, `uzytkownicy`.`Nazwisko` 
FROM `terminarz` 
INNER JOIN `uzytkownicy`
ON `terminarz`.`idNauczyciela` = `uzytkownicy`.`id`
WHERE `terminarz`.`idKlasy` = $idKlasy 
ORDER BY `terminarz`.`termin` ASC";

$mojeId = $_SESSION["idUzy"];
if($_SESSION["uprawnienia"] == 2){
  $sql = "SELECT `terminarz`.`id`, `terminarz`.`idKlasy`, `terminarz`.`termin`, `terminarz`.`nazwa`, `terminarz`.`komentarz`, `terminarz`.`idNauczyciela`, `uzytkownicy`.`Imie`, `uzytkownicy`.`Nazwisko` 
  FROM `terminarz` 
  INNER JOIN `uzytkownicy`
  ON `terminarz`.`idNauczyciela` = `uzytkownicy`.`id`
  WHERE `terminarz`.`idNauczyciela` = $mojeId
  ORDER BY `terminarz`.`termin` ASC";
}else if($_SESSION["uprawnienia"] >= 3){
  $temp = $_SESSION["idKlasy"];
  $sql2 = "SELECT * FROM `klasy` WHERE `idKlasy` = $temp";
  $result2 = $connect->query($sql2);
  $idSzkoly = "";
  
  if ($result2->num_rows > 0) {
    while($row2 = $result2->fetch_assoc()) {
      $idSzkoly = $row2["idSzkoly"];
    }
  }

  $sql = "SELECT `terminarz`.`id`, `terminarz`.`idKlasy`, `terminarz`.`termin`, `terminarz`.`nazwa`, `terminarz`.`komentarz`, `terminarz`.`idNauczyciela`, `uzytkownicy`.`Imie`, `uzytkownicy`.`Nazwisko` 
  FROM `terminarz` 
  INNER JOIN `uzytkownicy`
  ON `terminarz`.`idNauczyciela` = `uzytkownicy`.`id`
  INNER JOIN `klasy`
  ON `klasy`.`idKlasy` = `uzytkownicy`.`idKlasy`
  WHERE `klasy`.`idSzkoly` = $idSzkoly
  ORDER BY `terminarz`.`termin` ASC";
}

if(isset($_POST['submit']) && $_POST["jakoKto"] != "---" && $_POST["jakoKto"] != "") 
{
  if($_POST["jakoKto"] == "nauczyciel"){
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

      $sql = "SELECT `terminarz`.`id`, `terminarz`.`idKlasy`, `terminarz`.`termin`, `terminarz`.`nazwa`, `terminarz`.`komentarz`, `terminarz`.`idNauczyciela`, `uzytkownicy`.`Imie`, `uzytkownicy`.`Nazwisko` 
      FROM `terminarz` 
      INNER JOIN `uzytkownicy`
      ON `terminarz`.`idNauczyciela` = `uzytkownicy`.`id`
      INNER JOIN `klasy`
      ON `klasy`.`idKlasy` = `uzytkownicy`.`idKlasy`
      WHERE `klasy`.`idSzkoly` = $idSzkoly
      ORDER BY `terminarz`.`termin` ASC";
    }else{
      $sql = "SELECT `terminarz`.`id`, `terminarz`.`idKlasy`, `terminarz`.`termin`, `terminarz`.`nazwa`, `terminarz`.`komentarz`, `terminarz`.`idNauczyciela`, `uzytkownicy`.`Imie`, `uzytkownicy`.`Nazwisko` 
      FROM `terminarz` 
      INNER JOIN `uzytkownicy`
      ON `terminarz`.`idNauczyciela` = `uzytkownicy`.`id`
      WHERE `terminarz`.`idNauczyciela` = $mojeId
      ORDER BY `terminarz`.`termin` ASC";
    }
  }else{
    $idKlasy = $_POST["klasy"];
    $sql = "SELECT `terminarz`.`id`, `terminarz`.`idKlasy`, `terminarz`.`termin`, `terminarz`.`nazwa`, `terminarz`.`komentarz`, `terminarz`.`idNauczyciela`, `uzytkownicy`.`Imie`, `uzytkownicy`.`Nazwisko` 
    FROM `terminarz` 
    INNER JOIN `uzytkownicy`
    ON `terminarz`.`idNauczyciela` = `uzytkownicy`.`id`
    WHERE `terminarz`.`idKlasy` = $idKlasy 
    ORDER BY `terminarz`.`termin` ASC";
  }
}

$result = $connect->query($sql);

if($_SESSION["uprawnienia"] == 2){
echo '<button class="Button" onclick='. "'". 'window.open("dodajWydarzenie.php","_self")'. "'" .'>Add new</button><br>';
}else if($_SESSION["uprawnienia"] >= 3){
  echo '<button class="Button" style="background-color: gray;" onclick='. "'". 'window.open("dodajWydarzenie.php","_self")'. "'" .' disabled>Add new</button><a style="color: red;">*only teachers can do that</a>';
}
?>

<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

<div class="dziennikTop">Timetable</div>
<div class="formTermin">
  <form action="<?php echo $_SERVER["PHP_SELF"];?>" method="post" enctype="multipart/form-data" id="usrform">
  <center>
    <?php
      if($_POST["miesiac"] != ""){
        $miesiace = array("Jan", "Feb", "March", "Apr", "May", "Jun", "July", "Aug", "Sep", "Oct", "Nov", "Dec");
        echo '<select name="miesiac" id="miesiac" class="loginorregister" style="width: 33.3%;">';
        for($x = 1; $x < 13; $x++){
          if($_POST["miesiac"] == $x){
            echo '<option value="'.$x.'" selected="selected">'.$miesiace[$x-1].'</option>';
          }else{
            echo '<option value="'.$x.'">'.$miesiace[$x-1].'</option>';
          }
        }
        echo '</select>';
      }else{
        $miesiace = array("Jan", "Feb", "March", "Apr", "May", "Jun", "July", "Aug", "Sep", "Oct", "Nov", "Dec");
        echo '<select name="miesiac" id="miesiac" class="loginorregister" style="width: 33.3%;">';
        for($x = 1; $x < 13; $x++){
          if(date("m") == $x){
            echo '<option value="'.$x.'" selected="selected">'.$miesiace[$x-1].'</option>';
          }else{
            echo '<option value="'.$x.'">'.$miesiace[$x-1].'</option>';
          }
        }
        echo '</select>';
      }


      echo '<select name="rok" id="rok" class="loginorregister" style="width: 33.3%;">';

      if($_POST["rok"] != ""){
        if($_POST["rok"] == date("Y", mktime(0, 0, 0, date('m'), date('d'), date('Y')-1))){
          echo '<option value="'.date("Y", mktime(0, 0, 0, date('m'), date('d'), date('Y')-1)).'" selected="selected">'.date("Y", mktime(0, 0, 0, date('m'), date('d'), date('Y')-1)).'</option>';
          echo '<option value="'.date("Y", mktime(0, 0, 0, date('m'), date('d'), date('Y'))).'">'.date("Y", mktime(0, 0, 0, date('m'), date('d'), date('Y'))).'</option>';
          echo '<option value="'.date("Y", mktime(0, 0, 0, date('m'), date('d'), date('Y')+1)).'">'.date("Y", mktime(0, 0, 0, date('m'), date('d'), date('Y')+1)).'</option>';
        }else if($_POST["rok"] == date("Y", mktime(0, 0, 0, date('m'), date('d'), date('Y')))){
          echo '<option value="'.date("Y", mktime(0, 0, 0, date('m'), date('d'), date('Y')-1)).'">'.date("Y", mktime(0, 0, 0, date('m'), date('d'), date('Y')-1)).'</option>';
          echo '<option value="'.date("Y", mktime(0, 0, 0, date('m'), date('d'), date('Y'))).'" selected="selected">'.date("Y", mktime(0, 0, 0, date('m'), date('d'), date('Y'))).'</option>';
          echo '<option value="'.date("Y", mktime(0, 0, 0, date('m'), date('d'), date('Y')+1)).'">'.date("Y", mktime(0, 0, 0, date('m'), date('d'), date('Y')+1)).'</option>';
        }else{
          echo '<option value="'.date("Y", mktime(0, 0, 0, date('m'), date('d'), date('Y')-1)).'">'.date("Y", mktime(0, 0, 0, date('m'), date('d'), date('Y')-1)).'</option>';
          echo '<option value="'.date("Y", mktime(0, 0, 0, date('m'), date('d'), date('Y'))).'">'.date("Y", mktime(0, 0, 0, date('m'), date('d'), date('Y'))).'</option>';
          echo '<option value="'.date("Y", mktime(0, 0, 0, date('m'), date('d'), date('Y')+1)).'" selected="selected">'.date("Y", mktime(0, 0, 0, date('m'), date('d'), date('Y')+1)).'</option>';  
        }
      }else{
        echo '<option value="'.date("Y", mktime(0, 0, 0, date('m'), date('d'), date('Y')-1)).'">'.date("Y", mktime(0, 0, 0, date('m'), date('d'), date('Y')-1)).'</option>';
        echo '<option value="'.date("Y", mktime(0, 0, 0, date('m'), date('d'), date('Y'))).'" selected="selected">'.date("Y", mktime(0, 0, 0, date('m'), date('d'), date('Y'))).'</option>';
        echo '<option value="'.date("Y", mktime(0, 0, 0, date('m'), date('d'), date('Y')+1)).'">'.date("Y", mktime(0, 0, 0, date('m'), date('d'), date('Y')+1)).'</option>';
      }
      echo '</select>';

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
            FROM `klasy` 
            WHERE `klasy`.`idSzkoly` = $idSzkoly";

            $result4 = $connect->query($sql4);

            if ($result4->num_rows > 0) {
              while($row1 = $result4->fetch_assoc()) {
                echo '<option value="'.$row1["idKlasy"].'">'.$row1["NazwaKlasy"].'</option>';
              }
            } 
          }else{
            $myId = $_SESSION["idUzy"];
            $sql2 = "SELECT `uczoneKlasy` FROM `uzytkownicy` WHERE `id` = $myId";
            $result2 = $connect->query($sql2);
            if ($result2->num_rows > 0) {
              while($row = $result2->fetch_assoc()) {
                $uczoneKlasy = explode('&', $row["uczoneKlasy"]);
                $uczoneTemp = $uczoneKlasy[0];
                $sql1 = "SELECT `NazwaKlasy`, `idKlasy` FROM `klasy` WHERE `idKlasy` = $uczoneTemp";
          
                for($x = 1; $x < count($uczoneKlasy); $x++){
                  $uczoneTemp = $uczoneKlasy[$x];
                  $sql1 = $sql1 . " OR `idKlasy` = $uczoneTemp";
                }
          
                $result1 = $connect->query($sql1);
                if ($result1->num_rows > 0) {
                  while($row1 = $result1->fetch_assoc()) {
                    echo '<option value="'.$row1["idKlasy"].'">'.$row1["NazwaKlasy"].'</option>';
                  }
                }
              }
            }
          }
        
          
          echo '
          </select>';
      }
    ?>
    <br><input value="See" type="submit" name="submit" class="Loginbutton" style="width: 66.6%;">
  </center>
  </form>
</div>
<div id="ocenyTable"><table class="oceny" border="1">
<thead>
  <tr><th class="dzienTyg">Mo</th><th class="dzienTyg">Tu.</th><th class="dzienTyg">We.</th><th>Th.</th><th class="dzienTyg">Fr.</th><th class="dzienTyg">Sa.</th><th class="dzienTyg">Su.</th></tr>
  <tr>


<?php

$final = array();
while($row = $result->fetch_assoc()) {
  array_push($final, array($row["id"], $row["idKlasy"], $row["termin"], $row["nazwa"], $row["komentarz"], $row["idNauczyciela"], $row["Imie"], $row["Nazwisko"]));
}

$choosenDate = mktime(0, 0, 0, date('m'), 1, date('Y'));
$lastDayM = date('t', mktime(0, 0, 0, date('m')-1, 1, date('Y')));

if(isset($_POST['submit'])){
  $choosenDate = mktime(0, 0, 0, $_POST["miesiac"], 1, $_POST["rok"]);
  $lastDayM = date('t', mktime(0, 0, 0, $_POST["miesiac"]-1, 1, $_POST["rok"]));
}

$firstDay = date('l', $choosenDate);
$lastDayT = date('t', $choosenDate);
$leftD = 0;
switch($firstDay){
  case 'Monday':
    $leftD = 0;
    break;
  case 'Tuesday':
    $leftD = 1;
    break;
  case 'Wednesday':
    $leftD = 2;
    break;
  case 'Thursday':
    $leftD = 3;
    break;
  case 'Friday':
    $leftD = 4;
    break;
  case 'Saturday':
    $leftD = 5;
    break;
  case 'Sunday':
    $leftD = 6;
    break;
}

for($y = 0; $y < $leftD; $y++){
  $temp = (int)$lastDayM - (int)$leftD + $y + 1;
  echo '<th bgcolor="gray">'.$temp.'</th>';
}

for($z = 1; $z < $lastDayT+1; $z++){
  echo '<th>'.$z;

  for($a = 0; $a < count($final); $a++){
    if($final[$a][2] == date('Y-m-d', mktime(0, 0, 0, date('m', $choosenDate), $z, date('Y', $choosenDate)))){
      echo '<br><div class="wydarzenie">Name: <a class="aWyda">'.htmlspecialchars($final[$a][3]).'</a><br>Comment: <a class="aWyda">'.htmlspecialchars($final[$a][4]).'</a><br>Added by: <a class="aWyda">'.$final[$a][6].' '.$final[$a][7].'</a>';

      if($final[$a][5] == $_SESSION["idUzy"] || $_SESSION["uprawnienia"] >= 3){
        echo '<br><a href="usunWydarzenie.php/'.$final[$a][0].'" target="_blank">❌</a>';
      }

      echo '</div>';
    }
  }

  echo '</th>';
  if(date('l', mktime(0, 0, 0, date('m', $choosenDate), $z, date('Y', $choosenDate))) == 'Sunday'){
    echo '</tr><tr>';
  }
}

$count = 1;
while(true){
  echo '<th bgcolor="gray">'.$count.'</th>';
  if(date('l', mktime(0, 0, 0, date('m', $choosenDate)+1, $count, date('Y', $choosenDate))) == 'Sunday'){
    break;
  }
  $count++;
}
?>

</thead>
</table></div>