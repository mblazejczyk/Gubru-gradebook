<?php
session_start();
$login = $_SESSION["login"];
if($login == "" || $_SESSION["uprawnienia"] != 3){
    header("Location: ../noAccess.html");
  }else{

  
    $connect = mysqli_connect("localhost", "srv38973_dziennik", "password_here", "srv38973_dziennik");

echo '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';
if($connect === false){
  die("ERROR: Could not connect. " . mysqli_connect_error());
}


echo '<script>alert("Edited (*demo)");window.close();</script>';
  }
?>