<?php
session_start();
$login = $_SESSION["login"];

if($login == ""){
  header("Location: ../../noAccess.html");
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
            <button class="button" onclick='. "'". 'window.open("../logout.php","_self")'. "'" .'>Log out</button>
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
</div>';
$urlPath = $_SERVER["REQUEST_URI"];
$zadanieId = array_slice(explode('/', rtrim($urlPath, '/')), -1)[0];



if($connect === false){
  die("ERROR: Could not connect. " . mysqli_connect_error());
}

$mojeId = $_SESSION["idUzy"];
$sql = "SELECT `zadania`.`id`, `zadania`.`idKlasy`, `zadania`.`Termin`, `zadania`.`Temat`, `zadania`.`Tresc`, `uzytkownicy`.`Imie`, `uzytkownicy`.`Nazwisko`
        FROM `zadania` 
        INNER JOIN `uzytkownicy`
        ON `zadania`.`idNauczyciela` = `uzytkownicy`.`id`
        WHERE `zadania`.`id` = $zadanieId";

$result = $connect->query($sql);

?>


<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

<div class="dziennikTop">Homework</div>

<div id="ocenyTable">

<?php
$counter = 0;
if ($result->num_rows > 0) {
  while($row = $result->fetch_assoc()) {
    echo '<input class="tematWiado" type="text" value="'.htmlspecialchars($row["Temat"]).'" disabled><br>';
    echo '<textarea class="wiadomoscWiado" rows="20" disabled>'.htmlspecialchars($row["Tresc"]).'</textarea><br>';
    echo '<input class="dataWiado" type="textarea" value="Termin: '.$row["Termin"].'" disabled>';
    echo '<input class="odczytanieWiado" type="text" value="'.$row["Imie"].' '.$row["Nazwisko"].'" disabled>';
  }
} else {
  echo 'error';
}

?>

</div>