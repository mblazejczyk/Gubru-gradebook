<?php
session_start();
$login = $_SESSION["login"];
setcookie(session_name(), '', 100);
session_unset();
session_destroy();
$_SESSION = array();
echo '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';

echo '
<link rel="icon" type="image/png" href="../assets/logo.png"/>
        <title>Dziennik</title>
        <link rel="stylesheet" type="text/css" href="../style/style.css">

<script>
var dots = window.setInterval( function() {
    var wait = document.getElementById("wait");
    if ( wait.innerHTML.length > 3 ) 
        wait.innerHTML = "";
        
    else 
        wait.innerHTML += ".";
        window.open("../index.html", "_self");
    }, 500);
</script>
';

echo '<center><span class="logoutSpan">Logging out: '.$login.'</span><span id="wait" class="logoutSpan"></span>';

echo '<br><button class="button" onclick='. "'". 'window.open("../index.html","_self")'. "'" .'>Go to home page</button></center>';
?>