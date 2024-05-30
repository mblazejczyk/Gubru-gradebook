<?php
session_start();
$login = $_SESSION["login"];
if($login == "" || $_SESSION["uprawnienia"] < 2){
    header("Location: ../noAccess.html");
  }else{
    $connect = mysqli_connect("localhost", "srv38973_dziennik", "password_here", "srv38973_dziennik");

echo '
<script>
function przenies() {
  window.close();
}
</script>
';
echo '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';

$urlPath = $_SERVER["REQUEST_URI"];

$idOc = array_slice(explode('/', rtrim($urlPath, '/')), -1)[0];

echo '<script>alert("Removed (*demo)");window.close();</script>';
}
?>