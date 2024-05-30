<?php
session_start();
$login = $_SESSION["login"];
if($login == "" || $_SESSION["uprawnienia"] < 2){
    header("Location: ../noAccess.html");
  }
  $connect = mysqli_connect("localhost", "srv38973_dziennik", "password_here", "srv38973_dziennik");

echo '
<script>
function przenies() {
  window.close();
}
</script>
';
echo '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';

if($connect === false){
  die("ERROR: Could not connect. " . mysqli_connect_error());
}

$urlPath = $_SERVER["REQUEST_URI"];

$idOc = array_slice(explode('/', rtrim($urlPath, '/')), -5)[0];
$ocenaDod = array_slice(explode('/', rtrim($urlPath, '/')), -4)[0];
$nowaWaga = array_slice(explode('/', rtrim($urlPath, '/')), -3)[0];
$nowyKom = array_slice(explode('/', rtrim($urlPath, '/')), -2)[0];
$miejsce = array_slice(explode('/', rtrim($urlPath, '/')), -1)[0];

echo '<script>alert("Edited! (*demo)");window.close();</script>';


?>