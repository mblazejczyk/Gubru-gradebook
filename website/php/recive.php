<?php
session_start();
$login = $_SESSION["login"];

if($login == ""){
  header("Location: ../noAccess.html");
}
if($_SESSION["uprawnienia"] == 1){
  header("Location: mojeOceny.php");
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



?>

<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />



<div class="dziennikTop">Grade book</div>

<div id="ocenyTable"><table class="oceny" border="1">
      <thead>
        <tr><th class="nazwaKlasy">Class name</th><th class="przyciskiKlas">Add / remove grade</th><th class="przyciskiKlas">check attendance</th></tr>


<?php

if($connect === false){
  die("ERROR: Could not connect. " . mysqli_connect_error());
}

$klasyRAW = "";
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

  $sql3 = "SELECT * FROM `klasy` WHERE `idSzkoly` = $idSzkoly";
  $result3 = $connect->query($sql3);
  if ($result3->num_rows > 0) {
    while($row3 = $result3->fetch_assoc()) {
      $klasyRAW = $klasyRAW. $row3["idKlasy"] . '&';
    }
  }
  substr($klasyRAW, 0, -1);
}else{
  $klasyRAW = $_SESSION["uczoneKlasy"];
}

$klasy = explode("&", $klasyRAW);

$sqlWhere = "";
if(count($klasy) != 0){
  for($x = 0; $x < count($klasy); $x++){
    $y = $klasy[$x];
    if($x == count($klasy)-1){
      $sqlWhere = $sqlWhere . "`idKlasy` = '$y'";
    }else{
      $sqlWhere = $sqlWhere . "`idKlasy` = '$y' OR ";
    }
    
  }
}
$sql = "SELECT * FROM `klasy` WHERE $sqlWhere";
$result = $connect->query($sql);
$counter = 0;
if ($result->num_rows > 0) {
  while($row = $result->fetch_assoc()) {
    echo '<tr><th>'.$row["NazwaKlasy"].'</th><th>';

    $przedmiotyUc = explode('&', $row["PrzedmiotyUczone"]);
    for($x = 0; $x < count($przedmiotyUc); $x++){
      $y = $przedmiotyUc[$x];
      $sql1 = "SELECT * FROM `przedmioty` WHERE `IdPrzedmiotu` = $y";
      $result5 = $connect->query($sql1);
      $counter = 0;
      if ($result5->num_rows > 0) {
        while($row1 = $result5->fetch_assoc()) {
          if($row1["Nauczyciel"] == $_SESSION["idUzy"] || $_SESSION["uprawnienia"] >= 3){
            $nazwaPrzedTemp = $row1["Nazwa"];
            echo '<button class="menuButton" onclick="window.open(`/php/klasa.php/'.$row["idKlasy"].'/'.$row1["idPrzedmiotu"].'`,`_self`)">'.$nazwaPrzedTemp.'</button>';
          }
        }
      }
    }

    echo '</th><th><button class="menuButton" onclick="window.open(`/php/sprawdzFrekwencje.php/'.$row["idKlasy"].'`,`_self`)">check attendance</button></th></tr>';
    
  }
} else {
  echo 'list is empty';
}

?>

</thead>
      </table></div>

