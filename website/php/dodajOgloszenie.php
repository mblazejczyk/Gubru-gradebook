<?php
session_start();
$login = $_SESSION["login"];
if($login == "" || $_SESSION["uprawnienia"] <= 1){
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

?>

<html>
    <head>
    <link rel="stylesheet" type="text/css" href="../style/style.css">
        

        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

        
    </head>
    <body>

    
    <div class="loginForm">
        <form action='wyslijOgloszenie.php' target="_blank" method='post'>
            <h1>Create Announcement</h1>
            <label>
                Title: <br><input type='text' name='temat' size='40' maxlength="75" class = "inputLogin">
            </label>
            <br>
            <label>
                Announcement: <br>
                <textarea name="tresc" rows="4" cols="50" class = "inputLogin"></textarea>
            </label>
            <br><br>
            <input value="Create announcement" type="submit" name="gotowe" class="Loginbutton"><br>
        </form>
        </div>
    </body>
</html>