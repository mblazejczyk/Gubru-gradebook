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
</div>
';


if($connect === false){
  die("ERROR: Could not connect. " . mysqli_connect_error());
}


$urlPath = $_SERVER["REQUEST_URI"];
$klasaId = array_slice(explode('/', rtrim($urlPath, '/')), -1)[0];

//0 - obecny; 1 - nieobecny; 2 - spoxniony; 3 - zwolniony
if(isset($_POST['submit'])) 
{
  
  echo '<script>alert("Operation successful (*demo)");</script>';
}

$sql = "SELECT * FROM `uzytkownicy` WHERE `idKlasy` = $klasaId ORDER BY `uzytkownicy`.`Nazwisko` ASC";

$result = $connect->query($sql);

?>

<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

<div class="dziennikTop">Add attendance</div>

<div id="ocenyTable"><table class="oceny" border="1">
  <thead>
    <tr><th class="nrDziennikaFre">Lp</th><th class="imieNazwiskoFre">Name</th><th class="imieNazwiskoFre">Surname</th><th class="Frekfencja">Present</th><th class="Frekfencja">Absent</th><th class="Frekfencja">Late</th><th class="FrekfencjaL">Exempt</th></tr>

<form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>" id="frekfencja">
<?php
$ideki = "";
if ($result->num_rows > 0) {
  $h = 1;
  while($row = $result->fetch_assoc()) {
    
    echo '<tr><th>'. $h. "</th><th>" . $row["Imie"]. "</th><th>" . $row["Nazwisko"]. '</th><th>';
    

    echo '<label for="'.$row["id"].'1">Pr.</label><br><input type="radio" name="'.$row["id"].'" value="0" id="'.$row["id"].'1"></th><th>';
    echo '<label for="'.$row["id"].'2">Ab.</label><br><input type="radio" name="'.$row["id"].'" value="1" id="'.$row["id"].'2"></th><th>';
    echo '<label for="'.$row["id"].'3">Late.</label><br><input type="radio" name="'.$row["id"].'" value="2" id="'.$row["id"].'3"></th><th>';
    echo '<label for="'.$row["id"].'4">Ex.</label><br><input type="radio" name="'.$row["id"].'" value="3" id="'.$row["id"].'4"></th>';
    
    $ideki = $ideki . ";" . $row["id"];
    $h++;
  }
} else {
  echo 'no students here';
}
echo '<input type="text" name="idUczniow" value="'.$ideki.'" style="display: none;">';
?>
</thead>
</table>
<div style="background-color: #000000; float: right; color: white;">
<a><b>Date of absent: </b></a><input type="datetime-local" name="dataczas" class="inputLogin">
<input type="submit" name="submit" class="Sendbutton"/>
</div>
</form>
</div>