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

$sesjaSzkoly = $_SESSION["idSzkoly"];
$sql = "SELECT * FROM `ogloszenia` WHERE `idSzkoly` = $sesjaSzkoly ORDER BY `Data` DESC, `id` DESC";

$result = $connect->query($sql);


echo '
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';

if($_SESSION["uprawnienia"] >= 2){
    echo '<button class="button" onclick='. "'". 'window.open("dodajOgloszenie.php","_self")'. "'" .'>Create new ✏️</button>';
}

echo '<div class="dziennikTop">Announcements</div>
<div class="ogloszenia">';


if ($result->num_rows > 0) {
  while($row = $result->fetch_assoc()) {
    echo '<center><div class="ogloszenie">';
    
    echo '<b>Title: '. htmlspecialchars($row["Temat"]) .'</b><br>';
    
    echo '<span>Added on: <b>'.$row["Data"].'</b></span><br>';
    echo '<a>Announcement:<br>'. htmlspecialchars($row["Ogloszenie"]) .'</a><br>';
    
    echo '</div></center>';
  }
} else {
  echo 'no announcements';
}



echo '</div>';



?>