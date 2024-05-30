<?php
session_start();
$login = $_SESSION["login"];
if($login == "" || $_SESSION["uprawnienia"] != 3){
    header("Location: ../noAccess.html");
  }else{
    echo '<script>alert("Edited (*demo)");window.close();</script>';

  }
?>