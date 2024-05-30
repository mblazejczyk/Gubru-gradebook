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

<div class="PocztamenuDiv">
<button class="PocztamenuButton" onclick='. "'". 'window.open("poczta.php","_self")'. "'" .'>📬Inbox</button>
<button class="PocztamenuButton" onclick='. "'". 'window.open("wyslane.php","_self")'. "'" .'>📤Outbox</button>
<button class="PocztamenuButton" onclick='. "'". 'window.open("wysylanie.php","_self")'. "'" .'>✏️New mail</button>
</div>';



if($connect === false){
  die("ERROR: Could not connect. " . mysqli_connect_error());
}

$myId = $_SESSION["idUzy"];

$sql = "SELECT `wiadomosci`.`id`, `wiadomosci`.`Temat`, `wiadomosci`.`Wiadomosc`, `wiadomosci`.`DataWyslania`, `wiadomosci`.`CzyOdczytane`, `uzytkownicy`.`Imie`, `uzytkownicy`.`Nazwisko` FROM `wiadomosci` INNER JOIN `uzytkownicy` ON `wiadomosci`.`idAdresata` = `uzytkownicy`.`id` WHERE `wiadomosci`.`idNadawcy` = $myId";

$result = $connect->query($sql);

?>


<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

<div class="dziennikTop">Outbox</div>

<div id="ocenyTable"><table class="oceny" border="1">
  <thead>
    <tr><th class="nadawcaTh">Recipient</th><th class="tematTh">Title</th><th class="dataTh">Send date</th><th class="odczytaneTh">Read?</th></tr>


<?php
$counter = 0;
if ($result->num_rows > 0) {
  while($row = $result->fetch_assoc()) {
    
    echo '<tr><th>'. $row["Imie"]." ".$row["Nazwisko"]. "</th><th><a href='wiadomosc.php/".$row["id"]."'>" . $row["Temat"]. "</a></th><th>" . $row["DataWyslania"]. '</th><th>';

    if($row["CzyOdczytane"] == 0){
      echo 'NO';
    }else{
      echo 'YES';
    }

    echo '</th></tr>';
    
    
    
  }
} else {
  echo 'error';
}

?>

</thead>
      </table></div>