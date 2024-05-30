<?php
session_start();
$login = $_SESSION["login"];

function RemoveBS($Str) {  
  $a = html_entity_decode(mb_convert_encoding(stripslashes($Str), "HTML-ENTITIES", 'UTF-8'));
  return $a;
}

if($login == "" || $_SESSION["uprawnienia"] < 2){
    header("Location: ../noAccess.html");
  }else{

  
    $connect = mysqli_connect("localhost", "srv38973_dziennik", "password_here", "srv38973_dziennik");

echo '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';

$temat = RemoveBS(mysqli_real_escape_string($connect, $_REQUEST['temat']));
$tresc = RemoveBS(mysqli_real_escape_string($connect, $_REQUEST['tresc']));

echo '<script>alert("Added (*demo)");window.close();</script>';
  }
?>