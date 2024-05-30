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

function Edycjaoceny(a, b, waga, komentarz, data) {
  hideShowTable();
  var x = document.getElementById("edytujOcene");

  if (x.style.display === "none") {
    x.style.display = "block";
  } else {
    x.style.display = "none";
  }



var mOce = document.getElementById("ocenaDoDod1");
mOce.value=b;

var wOce = document.getElementById("wagaOc1");
wOce.value=waga;

var kOce = document.getElementById("komOc1");
kOce.value=komentarz;

var dataOc = document.getElementById("dadaDod");
dataOc.value=data;
}

</script>


<div class="dziennikTop">Grade book</div>

<div id="ocenyTable"><table class="oceny" border="1">
      <thead>
        <tr><th class="nrDziennika">Subjects</th><th class="oceny">semester I</th><th class="propKon">Av. (I)</th><th class="propKon">P (I)</th><th class="propKon">F (I)</th><th class="oceny">semester II"</th><th class="propKon">Av. (II)</th><th class="propKon">P (II)</th><th class="propKon">F (II)</th><th class="propKon">Av. (A)</th><th class="propKon">P (A)</th><th class="propKon">Annual</th></tr>


<?php
$temp = $_SESSION["idKlasy"];
$sql = "SELECT * FROM `klasy` WHERE `idKlasy` = $temp";

$result = $connect->query($sql);

$counter = 0;
if ($result->num_rows > 0) {
  while($row = $result->fetch_assoc()) {

    $idPrze = explode("&", $row["PrzedmiotyUczone"]);

    $sql1 = "SELECT * FROM `przedmioty` WHERE ";
    for($x = 0; $x < count($idPrze); $x++){
      if(count($idPrze) == $x+1){
        $sql1 = $sql1 . "`idPrzedmiotu` = ". $idPrze[$x];
      }else{
        $sql1 = $sql1 . "`idPrzedmiotu` = ". $idPrze[$x] . " OR ";
      }

    }

    $result1 = $connect->query($sql1);
    if ($result1->num_rows > 0) {
      while($row1 = $result1->fetch_assoc()) {
        echo '<tr><th>'.$row1["Nazwa"].'</th><th>';


        $sql2 = "SELECT * FROM `oceny` WHERE `idUcznia` = ".$_SESSION["idUzy"]." AND `idPrzedmiotu` = ".$row1["idPrzedmiotu"]." ORDER BY `miejsceOceny` ASC";
        $result2 = $connect->query($sql2);
        if ($result2->num_rows > 0) {

          $currentPlace = 1;
          $sumOcen = 0;
          $iloscOcen = 0;

          $sumWocen = 0;
          $iloscWocen = 0;
          while($row2 = $result2->fetch_assoc()) {
              if($currentPlace != $row2["miejsceOceny"]){
                if($currentPlace == 1 && $row2["miejsceOceny"] == 2){
                  $sredniaTemp = $sumOcen / $iloscOcen;
                  $srednia = number_format((float)$sredniaTemp, 2, '.', '');
                  echo '</th><th>'. $srednia . '</th><th>';
                  $currentPlace++;
                  $sumWocen = $sumOcen;
                  $iloscWocen = $iloscOcen;
                  $sumOcen = 0;
                  $iloscOcen = 0;
                }else if($currentPlace == 4 && $row2["miejsceOceny"] == 5){
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
                }else if($currentPlace == 6 && $row2["miejsceOceny"] == 7){
                  $sredniaTemp = $sumWocen / $iloscWocen;
                  $srednia = number_format((float)$sredniaTemp, 2, '.', '');
                  echo '</th><th>'. $srednia . '</th><th>';
                  $currentPlace++;
                  $sumWocen = 0;
                  $iloscWocen = 0;
                  $sumOcen = 0;
                  $iloscOcen = 0;
                }else{
                  $diff = $row2["miejsceOceny"] - $currentPlace;
                  for($x = 0; $x < $diff; $x++){
                    echo '</th><th>';
                  }
                }
    
                $currentPlace = $row2["miejsceOceny"];
              }
            
            echo '<div class="ocena" onclick="Edycjaoceny('.$row2["idOceny"].', '.$row2["Ocena"].', '.$row2["Waga"].', `'.$row2["Komentarz"].'`, `'.$row2["DataDodania"].'`)">'.$row2["Ocena"].'</div>';

            switch($row2["Ocena"]){
              case "1+":
                $sumOcen += 1.25 * (float)$row2["Waga"];
                break;
              case "2-":
                $sumOcen += 1.75 * (float)$row2["Waga"];
                break;
              case "2+":
                $sumOcen += 2.25 * (float)$row2["Waga"];
                break;
              case "3-":
                $sumOcen += 2.75 * (float)$row2["Waga"];
                break;
              case "3+":
                $sumOcen += 3.25 * (float)$row2["Waga"];
                break;
              case "4-":
                $sumOcen += 3.75 * (float)$row2["Waga"];
                break;
              case "4+":
                $sumOcen += 4.25 * (float)$row2["Waga"];
                break;
              case "5-":
                $sumOcen += 4.75 * (float)$row2["Waga"];
                break;
              case "5+":
                $sumOcen += 5.25 * (float)$row2["Waga"];
                break;
              default:
                $sumOcen += (float)$row2["Ocena"] * (float)$row2["Waga"];
            }
            $iloscOcen += (int)$row2["Waga"];
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
          }

        }else{
          for($x = 0; $x < 10; $x++){
            echo '</th><th>-';
          }
        }
        echo '</th></tr>';
      }
    }
    
    
    
  }
} else {
  echo 'no students';
}

?>

</thead>
</table></div>

<div id="edytujOcene" style="display: none;">
<div class="loginForm">
  <button onclick="Edycjaoceny(0, 0)" class="closeBtn">X</button><br>
  Grade: <br><input type="text" name="ocena" id="ocenaDoDod1" size="40" maxlength="1" type="text" class = "inputLogin" disabled><br>
  Weight: <br><input type="text" name="ocena" id="wagaOc1" size="40" maxlength="1" type="text" class = "inputLogin" disabled>
  Comment: <br><input type="text" name="ocena" id="komOc1" size="40" maxlength="128" type="text" class = "inputLogin" disabled>
  Added: <br><input type="text" name="ocena" id="dadaDod" size="40" maxlength="128" type="text" class = "inputLogin" disabled>
  </div>
</div>