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
<div class="panelUzy">Principal panel</div>
';


if(isset($_POST['submit'])) 
{
  echo '<script>alert("Edited! (*demo)");</script>';
}
?>
<center><div class="adminPrzyciski">
  <button class="menuButton" onclick='window.open("dodajKonto.php","_self")'>Create new account</button>
  <button class="menuButton" onclick='window.open("dodajKlase.php","_self")'>Create new class</button>
  <button class="menuButton" onclick='window.open("dodajPrzedmiot.php","_self")'>Add new school subject</button>
  <br>
  <button class="menuButton" onclick='window.open("edytujPrzedmioty.php","_self")'>Add / remove subjects to / from class</button>
  <button class="menuButton" onclick='window.open("edytujUczniow.php","_self")'>Move student to other class</button>
  <button class="menuButton" onclick='window.open("edytujNauczycieli.php","_self")'>Add / remove teachers to subjects</button>
</div></center>
<form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post" enctype="multipart/form-data">

<?php
$temp = $_SESSION["idKlasy"];
$sql2 = "SELECT * FROM `klasy` WHERE `idKlasy` = $temp";
$result2 = $connect->query($sql2);
$idSzkoly = "";

if ($result2->num_rows > 0) {
  while($row2 = $result2->fetch_assoc()) {
    $idSzkoly = $row2["idSzkoly"];
  }
}

$sql1 = "SELECT * FROM `klasy` WHERE `idSzkoly` = $idSzkoly";
$result1 = $connect->query($sql1);

echo '<table class="oceny" border="1"><tr><th class="nrDziennikaFre">Class name</th><th>Subjects</th></tr>';
if ($result1->num_rows > 0) {
  while($row1 = $result1->fetch_assoc()) {
    echo '<tr><th>'. htmlspecialchars($row1["NazwaKlasy"]).'</th><th>';
    $sql3 = "SELECT * FROM `przedmioty` WHERE `idSzkoly` = $idSzkoly";
    $result3 = $connect->query($sql3);

    $przedmiotyWKla = explode('&', $row1["PrzedmiotyUczone"]);

    if ($result3->num_rows > 0) {
      while($row3 = $result3->fetch_assoc()) {
        if(in_array($row3["idPrzedmiotu"], $przedmiotyWKla)){
          echo '<label><input type="checkbox" name="'.htmlspecialchars($row1["idKlasy"]).'[]" value="'.htmlspecialchars($row3["idPrzedmiotu"]).'" checked>'.htmlspecialchars($row3["Nazwa"]).'</laber>';
        }else{
          echo '<label><input type="checkbox" name="'.htmlspecialchars($row1["idKlasy"]).'[]" value="'.htmlspecialchars($row3["idPrzedmiotu"]).'">'.htmlspecialchars($row3["Nazwa"]).'</laber>';
        }

      }
    }
    echo '</th></tr>';
  }
}
?>
</table>
<input type="submit" name="submit" class="Sendbutton" value="change"/>
</form>