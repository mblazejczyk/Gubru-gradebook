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
    
    if($row["czyAdmin"] == 1 || $_SESSION["uprawnienia"] >= 3){
      $idKlasy = $row["idKlasy"];
    }else{
      $idKlasyTemp = explode('&', $row["uczoneKlasy"]);
      $idKlasy = $idKlasyTemp[0];
    }
  }
}

$sql1 = "SELECT `sciezka`, `nazwa`
FROM `pliki` 
INNER JOIN `klasy`
ON `pliki`.`idSzkoly` = `klasy`.`idSzkoly`
WHERE `klasy`.`idKlasy` = $idKlasy";

$result1 = $connect->query($sql1);

if($_SESSION["uprawnienia"] >= 2){
  echo '<button class="button" onclick='. "'". 'window.open("dodajPlik.php","_self")'. "'" .'>Add file 📁</button>';
}

?>

<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

<div class="dziennikTop">School files</div>

<div id="ocenyTable"><table class="oceny" border="1">

<?php
echo '<ul>';
$counter = 0;
if ($result1->num_rows > 0) {
  while($row = $result1->fetch_assoc()) {
    echo '<li><a href="'.$row["sciezka"].'">'.htmlspecialchars($row["nazwa"]).'</a></li>';
    
  }
} else {
  echo '<a>no files</a>';
}
echo '</ul>';
?>
</div>