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
<link rel="icon" type="image/png" href="../../../assets/logo.png"/>
        <title>Gubru</title>
        <link rel="stylesheet" type="text/css" href="../../../style/style.css">
        <div class="loginDiv">
          Logged in as: '.$login.'
        </div> 
<div class="topDiv">
            <img src="../../../assets/logo.png" height="50px" width="50px"/>
                Gubru
            <button class="button" onclick='. "'". 'window.open("../../logout.php","_self")'. "'" .'>Log out</button>
</div>
<div class="menuDiv">
            <button class="menuButton" onclick='. "'". 'window.open("../../panel.php","_self")'. "'" .'>User panel</button>
            <button class="menuButton" onclick='. "'". 'window.open("../../ogloszenia.php","_self")'. "'" .'>Announcements</button>
            <button class="menuButton" onclick='. "'". 'window.open("../../poczta.php","_self")'. "'" .'>Mail</button>
            <button class="menuButton" onclick='. "'". 'window.open("../../plikiSzkoly.php","_self")'. "'" .'>School files</button>
            <button class="menuButton" onclick='. "'". 'window.open("../../zadania.php","_self")'. "'" .'>Homework</button>
            <button class="menuButton" onclick='. "'". 'window.open("../../terminarz.php","_self")'. "'" .'>Timetable</button>
            <button class="menuButton" onclick='. "'". 'window.open("../../frekwencja.php","_self")'. "'" .'>Absence</button>
            <button class="menuButton" onclick='. "'". 'window.open("../../recive.php","_self")'. "'" .'>Grades</button>
            ';
            if($_SESSION["uprawnienia"] >= 3){
              echo '
              <button class="menuButton" onclick='. "'". 'window.open("../../panelAdmin.php","_self")'. "'" .'>Principal panel</button>';
            }
            echo'
</div>
';


if($connect === false){
  die("ERROR: Could not connect. " . mysqli_connect_error());
}


$urlPath = $_SERVER["REQUEST_URI"];
$przedmiotId = array_slice(explode('/', rtrim($urlPath, '/')), -1)[0];
$klasaId = array_slice(explode('/', rtrim($urlPath, '/')), -2)[0];

$sql = "SELECT * FROM `uzytkownicy` WHERE `idKlasy` = $klasaId ORDER BY `uzytkownicy`.`Nazwisko` ASC";

$result = $connect->query($sql);

?>

<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />


<script>
function hideShowTable() {
  var x = document.getElementById("ocenyTable");
  if (x.style.display === "none") {
    x.style.display = "block";
  } else {
    x.style.display = "none";
  }
}


function myFunction(a) {
  hideShowTable();
  var x = document.getElementById("edycja");
  if (x.style.display === "none") {
    x.style.display = "block";
  } else {
    x.style.display = "none";
  }

var mInput = document.getElementById("nrEdycji");
mInput.innerHTML=a;

var mHid = document.getElementById("nieMowNikomu");
mHid.value=a;
}

function usun(nr) {
  var url = "usun.php/" + nr;
  window.open(url);
  setTimeout(window.location.reload(true), 30000);
}

function DodawanieOceny(a) {
  hideShowTable();
  var x = document.getElementById("dodajOcene");
  if (x.style.display === "none") {
    x.style.display = "block";
  } else {
    x.style.display = "none";
  }

var mInput = document.getElementById("nrEdycji2");
mInput.innerHTML=a;

var mHid = document.getElementById("nieMowNikomu2");
mHid.value=a;
}

function dodajOcene() {
  hideShowTable();
  var mInput = document.getElementById("ocenaDoDod");
  var ocena = mInput.value;

  var mHid = document.getElementById("nieMowNikomu2");
  var nr = mHid.value;

  var wagaOc = document.getElementById("wagaOc");
  var wagaOceny = wagaOc.value;

  var komOc = document.getElementById("komOc");
  var komentDoOc = komOc.value;

  var opD = document.getElementById("optionD");
  var opDo = opD.value;

  var miejsce = 0;
  switch(opDo){
    case "semester I":
      miejsce = 1;
      break;
    case "Proposed (I)":
      miejsce = 2;
      break;
    case "Final (I)":
      miejsce = 3;
      break;
    case "semester II":
      miejsce = 4;
      break;
    case "proposed (II)":
      miejsce = 5;
      break;
    case "final (II)":
      miejsce = 6;
      break;
    case "Proposed annual":
      miejsce = 7;
      break;
    case "Annual":
      miejsce = 8;
      break;
  }

  var url = "../../dodajOcene.php/" + ocena + "/" + nr + "/" + <?php echo $przedmiotId; ?> + "/" + wagaOceny + "/" + komentDoOc + "/" + miejsce;
  window.open(url);
  setTimeout(window.location.reload(true), 30000);
}

function usunOcene() {
  hideShowTable();

  var mHid = document.getElementById("nieMowNikomu4");
  var idOc = mHid.value;

  var url = "../../usunOcene.php/" + idOc;
  window.open(url);
  setTimeout(window.location.reload(true), 30000);
}

function Edycjaoceny(a, b, waga, komentarz) {
  hideShowTable();
  var x = document.getElementById("edytujOcene");

  if (x.style.display === "none") {
    x.style.display = "block";
  } else {
    x.style.display = "none";
  }

var mInput = document.getElementById("nrEdycji4");
mInput.innerHTML=a;

var mHid = document.getElementById("nieMowNikomu4");
mHid.value=a;

var mOc = document.getElementById("OcenaEdycji4");
mOc.innerHTML=b;

var mOce = document.getElementById("nieMowOceny");
mOce.value=b;

var wOce = document.getElementById("wagaOc1");
wOce.value=waga;

var kOce = document.getElementById("komOc1");
kOce.value=komentarz;
}

function zedytujOcene() {
  hideShowTable();
  var mInput = document.getElementById("nieMowOceny");
  var ocenaUsu = mInput.value;

  var mInput = document.getElementById("ocenaDoDod1");
  var ocenaDod = mInput.value;

  var mHid = document.getElementById("nieMowNikomu4");
  var idOc = mHid.value;

  var wOce = document.getElementById("wagaOc1");
  nowaWaga = wOce.value;

  var kOce = document.getElementById("komOc1");
  nowyKom = kOce.value;

  var opD = document.getElementById("optionC");
  var opDo = opD.value;

  var miejsce = 0;
  switch(opDo){
    case "semester I":
      miejsce = 1;
      break;
    case "Proposed (I)":
      miejsce = 2;
      break;
    case "Final (I)":
      miejsce = 3;
      break;
    case "semester II":
      miejsce = 4;
      break;
    case "proposed (II)":
      miejsce = 5;
      break;
    case "final (II)":
      miejsce = 6;
      break;
    case "Proposed annual":
      miejsce = 7;
      break;
    case "Annual":
      miejsce = 8;
      break;
  }
  
  var url2 = "../../edytujOcene.php/" + idOc + "/" + ocenaDod + "/" + nowaWaga + "/" + nowyKom + "/" + miejsce;
  window.open(url2, "_blank");
  setTimeout(window.location.reload(true), 30000);
}


</script>


<div class="dziennikTop">Grade book</div>

<div id="ocenyTable"><table class="oceny" border="1">
      <thead>
        <tr><th class="nrDziennika">Lp.</th><th class="imieNazwisko">Name</th><th class="imieNazwisko">Surname</th><th class="oceny">I semester</th><th class="propKon">Av. (I)</th><th class="propKon">P (I)</th><th class="propKon">K (I)</th><th class="oceny">II semester</th><th class="propKon">Av. (II)</th><th class="propKon">P (II)</th><th class="propKon">K (II)</th><th class="propKon">Av. (A)</th><th class="propKon">P (A)</th><th class="propKon">Annual</th><th class="tableButtons">New grade</th></tr>


<?php
if ($result->num_rows > 0) {
  $h = 1;
  while($row = $result->fetch_assoc()) {
    
    echo '<tr><th>'. $h. "</th><th>" . $row["Imie"]. "</th><th>" . $row["Nazwisko"]. '</th><th>';
    
    $temp = $row["id"];
    $sql1 = "SELECT * FROM `oceny` WHERE `idUcznia` = $temp ORDER BY `miejsceOceny` ASC";
    $result1 = $connect->query($sql1);
    if ($result1->num_rows > 0) {

      $currentPlace = 1;
      $sumOcen = 0;
      $iloscOcen = 0;

      $sumWocen = 0;
      $iloscWocen = 0;
      while($row1 = $result1->fetch_assoc()) {
        if($row1["idPrzedmiotu"] == $przedmiotId){

          if($currentPlace != $row1["miejsceOceny"]){
            if($currentPlace == 1 && $row1["miejsceOceny"] == 2){
              $sredniaTemp = $sumOcen / $iloscOcen;
              $srednia = number_format((float)$sredniaTemp, 2, '.', '');
              echo '</th><th>'. $srednia . '</th><th>';
              $currentPlace++;
              $sumWocen = $sumOcen;
              $iloscWocen = $iloscOcen;
              $sumOcen = 0;
              $iloscOcen = 0;
            }else if($currentPlace == 4 && $row1["miejsceOceny"] == 5){
              $sredniaTemp = $sumOcen / $iloscOcen;
              $srednia = number_format((float)$sredniaTemp, 2, '.', '');
              echo '</th><th>'. $srednia . '</th><th>';
              $currentPlace++;
              if($iloscOcen != 0){
                $sumWocen += $sumOcen;
                $iloscWocen += $iloscOcen;
              }
              $sumOcen = 0;
              $iloscOcen = 0;
            }else if($currentPlace == 6 && $row1["miejsceOceny"] == 7){
              $sredniaTemp = $sumWocen / $iloscWocen;
              $srednia = number_format((float)$sredniaTemp, 2, '.', '');
              echo '</th><th>'. $srednia . '</th><th>';
              $currentPlace++;
              $sumWocen = 0;
              $iloscWocen = 0;
              $sumOcen = 0;
              $iloscOcen = 0;
            }else{
              $diff = $row1["miejsceOceny"] - $currentPlace;
              for($x = 0; $x < $diff; $x++){
                echo '</th><th>';
              }
            }

            $currentPlace = $row1["miejsceOceny"];
          }
        
          echo '<div class="ocena" onclick="Edycjaoceny('.$row1["idOceny"].', '.$row1["Ocena"].', '.$row1["Waga"].', `'.$row1["Komentarz"].'`)">'.$row1["Ocena"].'</div>';
        

          switch($row1["Ocena"]){
            case "1+":
              $sumOcen += 1.25 * (float)$row1["Waga"];
              break;
            case "2-":
              $sumOcen += 1.75 * (float)$row1["Waga"];
              break;
            case "2+":
              $sumOcen += 2.25 * (float)$row1["Waga"];
              break;
            case "3-":
              $sumOcen += 2.75 * (float)$row1["Waga"];
              break;
            case "3+":
              $sumOcen += 3.25 * (float)$row1["Waga"];
              break;
            case "4-":
              $sumOcen += 3.75 * (float)$row1["Waga"];
              break;
            case "4+":
              $sumOcen += 4.25 * (float)$row1["Waga"];
              break;
            case "5-":
              $sumOcen += 4.75 * (float)$row1["Waga"];
              break;
            case "5+":
              $sumOcen += 5.25 * (float)$row1["Waga"];
              break;
            default:
              $sumOcen += (float)$row1["Ocena"] * (float)$row1["Waga"];
          }
          $iloscOcen += (int)$row1["Waga"];
        }
      }

      while(true){
        if($currentPlace == 1){
          $sredniaTemp = $sumOcen / $iloscOcen;
          $srednia = number_format((float)$sredniaTemp, 2, '.', '');
          echo '</th><th>'. $srednia . '</th><th>';
          $currentPlace++;
          $sumWocen = $sumOcen;
          $iloscWocen = $iloscOcen;
          $sumOcen = 0;
          $iloscOcen = 0;
        }else if($currentPlace == 4){
          $sredniaTemp = $sumOcen / $iloscOcen;
          $srednia = number_format((float)$sredniaTemp, 2, '.', '');
          echo '</th><th>'. $srednia . '</th><th>';
          $currentPlace++;

          if($iloscOcen != 0){
            $sumWocen += $sumOcen;
            $iloscWocen += $iloscOcen;
          }
          
          $sumOcen = 0;
          $iloscOcen = 0;
        }else if($currentPlace == 6){
          $sredniaTemp = $sumWocen / $iloscWocen;
          $srednia = number_format((float)$sredniaTemp, 2, '.', '');
          echo '</th><th>'. $srednia . '</th><th>';          
          $currentPlace++;
          $sumWocen = 0;
          $iloscWocen = 0;
          $sumOcen = 0;
              $iloscOcen = 0;
        }else if($currentPlace == 8){
          break;
        }else{
          echo '</th><th>';
          $currentPlace++;
        }

        if($currentPlace == 8){
          break;
        }
      }
      echo '</th>'; 
      echo '<th><center><button onclick="DodawanieOceny('. $row["id"] .')">➕</button></center></th></tr>';
      
    }else{
      for($x = 0; $x < 10; $x++){
        echo '</th><th>-';
      }
      echo '</th>'; 
      echo '<th><center><button onclick="DodawanieOceny('. $row["id"] .')">➕</button></center></th></tr>';
    }
    $h++;
  }
} else {
  echo 'no students';
}

?>

</thead>
      </table></div>



<div id="edycja" style="display: none;">
  <div class="loginForm">
  <button onclick="myFunction(0)" class="closeBtn">X</button><br>
  <form target="_blank" action="edytuj.php" method="post">
  <h3>Editing student (id): <a id="nrEdycji"/></h3><input type="text" id="nieMowNikomu" name="nrEdycji" style="display: none;">
  <label>
      Name: <input type="text" name="imie" size="40" maxlength="40"  class = "inputLogin">
  </label>
  <br>
  <label>
      Surname: <input type="text" name="nazwisko" size="35" maxlength="40"  class = "inputLogin">
  </label>
  <br>
  <label>
      Grade book place: <input type="number" name="nrwdzienniku" maxlength="2"  class = "inputLogin">
  </label>
  <br><br>
  <input value="Edytuj ucznia" type="submit" name="gotowe" class="Loginbutton"><br>
  </form>
  </div>
</div>

<div id="dodajOcene" style="display: none;">
  <div  class="loginForm">
    <button onclick="DodawanieOceny(0)" class="closeBtn">X</button><br>
    <h3>Adding grade for student (id): <a id="nrEdycji2"/></h3><input type="text" id="nieMowNikomu2" name="nrEdycji2" style="display: none;">

    Grade: <br><input type="text" name="ocena" id="ocenaDoDod" size="40" maxlength="1" type="text" class = "inputLogin"><br>
    Grade period:<br>
    <select name="optionD" class="loginorregister" id="optionD">
      <option>semester I</option>
      <option>Proposed (I)</option>
      <option>Final (I)</option>
      <option>semester II</option>
      <option>proposed (II)</option>
      <option>final (II)</option>
      <option>Proposed annual</option>
      <option>Annual</option>
    </select><br>
    weight: <br><input type="text" name="ocena" id="wagaOc" size="40" maxlength="1" type="text" class = "inputLogin"><br>
    Comment: <br><input type="text" name="ocena" id="komOc" size="40" maxlength="128" type="text" class = "inputLogin"><br>
    <br>
    <button onclick="dodajOcene()"  class="Loginbutton">Add</button>
  </div>
</div>


<div id="edytujOcene" style="display: none;">
<div class="loginForm">
  <button onclick="Edycjaoceny(0, 0)" class="closeBtn">X</button><br>
  <a>Editing grade:  <a id="OcenaEdycji4"/></a><input type="text" id="nieMowOceny" name="OcenaEdycji4" style="display: none;"><br>
  <a>student id: <a id="nrEdycji4"/></a><input type="text" id="nieMowNikomu4" name="nrEdycji4" style="display: none;">
  <br><br>
  New grade: <br><input type="text" name="ocena" id="ocenaDoDod1" size="40" maxlength="1" type="text" class = "inputLogin"><br>
  Grade period:<br>
  <select name="optionC" class="loginorregister" id="optionC">
      <option>semester I</option>
      <option>Proposed (I)</option>
      <option>Final (I)</option>
      <option>semester II</option>
      <option>proposed (II)</option>
      <option>final (II)</option>
      <option>Proposed annual</option>
      <option>Annual</option>
  </select><br>
  Weight: <br><input type="text" name="ocena" id="wagaOc1" size="40" maxlength="1" type="text" class = "inputLogin"><br>
  Comment: <br><input type="text" name="ocena" id="komOc1" size="40" maxlength="128" type="text" class = "inputLogin"><br>
  <button onclick="zedytujOcene()" class="Loginbutton">Edit</button>
  <h2>or</h2>
  <button onclick="usunOcene()"  class="Loginbutton">Remove grade</button>
  </div>
</div>