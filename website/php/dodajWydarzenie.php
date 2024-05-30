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

function RemoveBS($Str) {  
  $StrArr = str_split($Str); $NewStr = '';
  foreach ($StrArr as $Char) {    
    $CharNo = ord($Char);
    if ($CharNo == 163 || $CharNo == 226) { $NewStr .= $Char; continue; } // keep £ 
    if ($CharNo > 32 && $CharNo < 200) {
      $NewStr .= $Char;    
    }
  }  
  return $NewStr;
}

if($connect === false){
  die("ERROR: Could not connect. " . mysqli_connect_error());
}

if(isset($_POST['submit'])) 
{ 
  echo '<script>alert("Event added (*demo)");</script>';
}

?>

<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

<div class="dziennikTop">New event</div>

<div id="ocenyTable"><table class="oceny" border="1">
<div class="loginForm">
<form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post" enctype="multipart/form-data" id="usrform">
  <label>
      Title: <br><input type="text" name="temat" size="64" maxlength="64" class = "inputLogin">
  </label>
  <br>
  <label>
      Description: <br><textarea rows="4" cols="50" name="tresc" form="usrform" class="inputLogin"></textarea>
  </label>
  <br>
  <label>
      When: <br><input type="date" name="date" size="64" maxlength="64" class = "inputLogin">
  </label>
<br>
  For class:<br>
  <select name="klasy" id="klasy" class="loginorregister">
  <?php
  $myId = $_SESSION["idUzy"];
  $sql = "SELECT `uczoneKlasy` FROM `uzytkownicy` WHERE `id` = $myId";
  $result = $connect->query($sql);

  if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
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
  ?>

  </select>

  <br><br>
  <input value="Add" type="submit" name="submit" class="Loginbutton"><br>
</form>
</div>
</div>