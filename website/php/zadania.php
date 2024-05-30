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

$myId = $_SESSION["idUzy"];
$sql = "SELECT `idKlasy`, `uczoneKlasy`, `czyAdmin` FROM `uzytkownicy` WHERE `id` = $myId";
$result = $connect->query($sql);
$idKlasy = "";

if ($result->num_rows > 0) {
  while($row = $result->fetch_assoc()) {
    
    if($row["czyAdmin"] == 1){
      $idKlasy = $row["idKlasy"];
      $sql1 = "SELECT `zadania`.`id`, `zadania`.`idKlasy`, `zadania`.`Termin`, `zadania`.`Temat`, `zadania`.`Tresc`, `uzytkownicy`.`Imie`, `uzytkownicy`.`Nazwisko`
                FROM `zadania` 
                INNER JOIN `uzytkownicy`
                ON `zadania`.`idNauczyciela` = `uzytkownicy`.`id`
                WHERE `zadania`.`idKlasy` = $idKlasy
                ORDER BY `zadania`.`Termin` DESC";
    }else{
      $sql1 = "SELECT `zadania`.`id`, `zadania`.`idKlasy`, `zadania`.`Termin`, `zadania`.`Temat`, `zadania`.`Tresc`, `uzytkownicy`.`Imie`, `uzytkownicy`.`Nazwisko`
              FROM `zadania` 
              INNER JOIN `uzytkownicy`
              ON `zadania`.`idNauczyciela` = `uzytkownicy`.`id`
              WHERE `zadania`.`idNauczyciela` = $myId
              ORDER BY `zadania`.`Termin` DESC";
    }
  }
}

if($_SESSION["uprawnienia"] >= 3){
  $sql1 = "SELECT `zadania`.`id`, `zadania`.`idKlasy`, `zadania`.`Termin`, `zadania`.`Temat`, `zadania`.`Tresc`, `uzytkownicy`.`Imie`, `uzytkownicy`.`Nazwisko`
  FROM `zadania` 
  INNER JOIN `uzytkownicy`
  ON `zadania`.`idNauczyciela` = `uzytkownicy`.`id`
  INNER JOIN `klasy`
  ON `uzytkownicy`.`idKlasy` = `klasy`.`idKlasy`
  WHERE `klasy`.`idSzkoly` = 1
  ORDER BY `zadania`.`Termin` DESC";
}

$result1 = $connect->query($sql1);

if($_SESSION["uprawnienia"] == 2){
  echo '<button class="button" onclick='. "'". 'window.open("dodajZadanie.php","_self")'. "'" .'>New homework 📄</button>';
}else if($_SESSION["uprawnienia"] >= 3){
  echo '<button class="Button" style="background-color: gray;" onclick='. "'". 'window.open("dodajZadanie.php","_self")'. "'" .' disabled>New homework 📄</button><a style="color: red;">*jonly teacher can do that</a>';
}

?>

<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

<div class="dziennikTop">Homework</div>

<div id="ocenyTable"><table class="oceny" border="1">
<thead>
    <tr><th class="nadawcaTh">Teacher</th><th class="tematTh">Title</th><th class="dataTh">Due date</th><th class="odczytaneTh">More</th></tr>

<?php
$counter = 0;
if ($result1->num_rows > 0) {
  while($row = $result1->fetch_assoc()) {
    echo '<tr><th>'.$row["Imie"].' '.$row["Nazwisko"].'</th><th>'.htmlspecialchars($row["Temat"]).'</th><th>'.$row["Termin"].'</th><th><button class="menuButton" onclick="window.open(`/php/zadanie.php/'.$row["id"].'`,`_self`)">More</button></th></tr>';
  }
} else {
  echo '<a>no homeworks ^.^</a>';
}
?>
</thead>
</div>