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
<link rel="icon" type="image/png" href="../../assets/logo.png"/>
        <title>Gubru</title>
        <link rel="stylesheet" type="text/css" href="../../style/style.css">
        <div class="loginDiv">
          Logged in as: '.$login.'
        </div> 
<div class="topDiv">
            <img src="../../assets/logo.png" height="50px" width="50px"/>
                Gubru
            <button class="button" onclick='. "'". 'window.open("logout.php","_self")'. "'" .'>Log out</button>
</div>
<div class="menuDiv">
            <button class="menuButton" onclick='. "'". 'window.open("../panel.php","_self")'. "'" .'>User panel</button>
            <button class="menuButton" onclick='. "'". 'window.open("../ogloszenia.php","_self")'. "'" .'>Announcements</button>
            <button class="menuButton" onclick='. "'". 'window.open("../poczta.php","_self")'. "'" .'>Mail</button>
            <button class="menuButton" onclick='. "'". 'window.open("../plikiSzkoly.php","_self")'. "'" .'>School files</button>
            <button class="menuButton" onclick='. "'". 'window.open("../zadania.php","_self")'. "'" .'>Homework</button>
            <button class="menuButton" onclick='. "'". 'window.open("../terminarz.php","_self")'. "'" .'>Timetable</button>
            <button class="menuButton" onclick='. "'". 'window.open("../frekwencja.php","_self")'. "'" .'>Absence</button>
            <button class="menuButton" onclick='. "'". 'window.open("../recive.php","_self")'. "'" .'>Grades</button>
            ';
            if($_SESSION["uprawnienia"] >= 3){
              echo '
              <button class="menuButton" onclick='. "'". 'window.open("../panelAdmin.php","_self")'. "'" .'>Principal panel</button>';
            }
            echo'
</div>

<div class="PocztamenuDiv">
<button class="PocztamenuButton" onclick='. "'". 'window.open("../poczta.php","_self")'. "'" .'>📬Inbox</button>
<button class="PocztamenuButton" onclick='. "'". 'window.open("../wyslane.php","_self")'. "'" .'>📤Outbox</button>
<button class="PocztamenuButton" onclick='. "'". 'window.open("../wysylanie.php","_self")'. "'" .'>✏️New mail</button>
</div>';
$urlPath = $_SERVER["REQUEST_URI"];
$wiadomoscId = array_slice(explode('/', rtrim($urlPath, '/')), -1)[0];



if($connect === false){
  die("ERROR: Could not connect. " . mysqli_connect_error());
}

$mojeId = $_SESSION["idUzy"];
$sql = "SELECT `Temat`, `Wiadomosc`, `DataWyslania`, `CzyOdczytane`, `idAdresata`, `id` FROM `wiadomosci` WHERE `idNadawcy` = $mojeId AND `id` = $wiadomoscId OR `idAdresata` = $mojeId AND `id` = $wiadomoscId";

$result = $connect->query($sql);

?>


<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

<div class="dziennikTop">Message</div>

<div id="ocenyTable">

<?php
$counter = 0;
if ($result->num_rows > 0) {
  while($row = $result->fetch_assoc()) {

    if($row["idAdresata"] == $_SESSION["idUzy"]){
      $sql1 = "UPDATE `wiadomosci` SET `CzyOdczytane` = '1' WHERE `wiadomosci`.`id` = $wiadomoscId";
      $result1 = $connect->query($sql1);
    }

    echo '<input class="tematWiado" type="text" value="'.$row["Temat"].'" disabled><br>';
    echo '<textarea class="wiadomoscWiado" rows="20" disabled>'.$row["Wiadomosc"].'</textarea><br>';
    echo '<input class="dataWiado" type="textarea" value="'.$row["DataWyslania"].'" disabled>';
    if($row["CzyOdczytane"] == 0){
      echo '<input class="odczytanieWiado" type="text" value="DIDN`T READ" disabled>';
    }else{
      echo '<input class="odczytanieWiado" type="text" value="READ" disabled>';
    }
  }
} else {
  echo 'error';
}

?>

</div>


<div id="edytujOcene" style="display: none;">
<div class="loginForm">
  <button onclick="Edycjaoceny(0, 0)" class="closeBtn">X</button><br>
  <a>Edytujesz ocene:  <a id="OcenaEdycji4"/></a><input type="text" id="nieMowOceny" name="OcenaEdycji4" style="display: none;"><br>
  <a>osobie o numerze: <a id="nrEdycji4"/></a><input type="text" id="nieMowNikomu4" name="nrEdycji4" style="display: none;">
  <br><br>
  Ocena po zmianie: <input type="text" name="ocena" id="ocenaDoDod1" size="40" maxlength="1" type="text" class = "inputLogin"><br>
  <button onclick="zedytujOcene()" class="Loginbutton">Edytuj</button>
  <h2>lub</h2>
  <button onclick="usunOcene()"  class="Loginbutton">Usuń ocene</button>
  </div>
</div>