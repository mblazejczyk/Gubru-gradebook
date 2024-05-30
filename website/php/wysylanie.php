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

if(isset($_POST['submit'])) 
{ 
  echo '<script>alert("Sent (*demo)");</script>';
}

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
$sql = "SELECT `idKlasy`, `uczoneKlasy`, `czyAdmin` FROM `uzytkownicy` WHERE `id` = $myId";

$result = $connect->query($sql);

?>


<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />



<div class="dziennikTop">New message</div>

<form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>" id="formularz">
<div class="listaDoWyslania">
  <h2>Recipient:</h2>
<?php
$counter = 0;
if ($result->num_rows > 0) {
  while($row = $result->fetch_assoc()) {
    
    if($row["czyAdmin"] == 1){
      $idKlasy = $row["idKlasy"];
    }else{
      $idKlasyTemp = explode('&', $row["uczoneKlasy"]);
      $idKlasy = $idKlasyTemp[0];
    }
      $sql1 = "SELECT `Imie`, `Nazwisko`, `id` FROM `uzytkownicy`  INNER JOIN `klasy` ON `uzytkownicy`.`idKlasy` = `klasy`.`idKlasy` INNER JOIN `szkoly` ON `klasy`.`idSzkoly` = `szkoly`.`idSzkoly` WHERE `uzytkownicy`.`czyAdmin` > 1";

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

        $sql1 = "SELECT `Imie`, `Nazwisko`, `id` FROM `uzytkownicy`  INNER JOIN `klasy` ON `uzytkownicy`.`idKlasy` = `klasy`.`idKlasy` INNER JOIN `szkoly` ON `klasy`.`idSzkoly` = `szkoly`.`idSzkoly` WHERE `szkoly`.`idSzkoly` = $idSzkoly";
      }

      $result1 = $connect->query($sql1);
      if ($result1->num_rows > 0) {
        
        while($row1 = $result1->fetch_assoc()) {
          $sql1Id = $row1["id"];
          echo '
            <input type="checkbox" id="'.$sql1Id.'" name="odbiorca[]" value="'.$sql1Id.'">
            <label for="'.$sql1Id.'"> '.$row1["Imie"]. ' '.$row1["Nazwisko"].'</label><br>
          ';
          
        }
      }
  }
} else {
  echo 'error';
}

?>
</div>
<div class="wysylanieWiado">
  Title: <br><input type="text" id="temat" name="temat" class="tematWiado" maxlength="128"><br>
  Message:<br>
  <textarea rows="4" cols="50" name="wiadomosc" form="formularz" class="textareaWiado"></textarea><br>
  <input type="submit" name="submit" class="Sendbutton"/>
</div>
</form>