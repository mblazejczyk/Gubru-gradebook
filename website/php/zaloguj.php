<?php
   //czyAdmin = 
   //1 wyświetlanie ocen, ogłoszeń, wiadomości - uczeń; 
   //2 wyświetlanie ocen, ogłoszeń, pisanie ogłoszeń, wiadomości, dodawanie ocen osobm z przypisanych klas - nauczyciel; 
   //3 wyświetlanie / dodawanie ocen wszystkim, ogłoszenia i ich pisanie, wiadomości, przypisywanie do klas, dodawanie uczniów i nauczycieli - dyrektor
   //4 head admin

   ob_start();
   ini_set('session.gc_maxlifetime', 60);
   session_set_cookie_params(60);
   session_start();
   $czyZalogowany = isset($_SESSION["login"]);
   if($czyZalogowany){
      header("Location: panel.php");
   }
   echo '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';

?>

<html lang = "en">
   <head>
   <link rel="icon" type="image/png" href="../assets/logo.png"/>
   </head>
   <body>
   <div style="background-color: red; width: 100%; color: white; text-align: center; font-size: 19px;">
            <b>!!! Website is still in building progress. Your informations may not be secure enaugh!!!</b>
        </div>
   <link rel="icon" type="image/png" href="../assets/logo.png"/>
        <title>Gubru</title>
   <link rel="stylesheet" type="text/css" href="../style/style.css">
   <div class="topDiv">
            <img src="../assets/logo.png" height="50px" width="50px"/>
                Gubru
            <button class="button" onclick="window.open('../index.html','_self')">Back to home</button>
        </div> 
      <div class = "container form-signin">
         <?php
            $msg = '';
            
            if (isset($_POST['login']) && !empty($_POST['username'])) {
                  
                  if($_POST['option'] == "Log in"){
                     $connect = mysqli_connect("localhost", "srv38973_dziennik", "password_here", "srv38973_dziennik");

                     if($connect === false){
                     die("ERROR: Could not connect. " . mysqli_connect_error());
                     }

                     $sql = "SELECT * FROM `uzytkownicy`";

                     $result = $connect->query($sql);

                     if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                              $pass = password_verify($_POST['username'], $row["haslo"]);
                              
                              if ($_POST['username'] == $row["login"] && $pass == true ) {
                                 $_SESSION["login"] = $_POST['username'];
                                 $_SESSION["uprawnienia"] = $row["czyAdmin"];
                                 $_SESSION["uczoneKlasy"] = $row["uczoneKlasy"];
                                 $_SESSION["idKlasy"] = $row["idKlasy"];
                                 $_SESSION["idUzy"] = $row["id"];
                                 $sql = "SELECT * FROM `klasy`";

                                 $result = $connect->query($sql);

                                 if ($result->num_rows > 0) {
                                    while($row1 = $result->fetch_assoc()) {
                                       if($row1["idKlasy"] == $row["idKlasy"]){
                                          $_SESSION["idSzkoly"] = $row1["idSzkoly"];
                                       }
                                    }
                                 }

                                 header("Location: panel.php");
                              }else {
                                 $msg = 'Wrong login or password';
                              }
                        }
                     }
                  }else{
                     
                  }
                
            }
         ?>
      </div>
      
      
         <form class = "form-signin" role = "form" action = "<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method = "post">
            <h4 class = "form-signin-heading"><?php echo $msg; ?></h4>
            
         <div class="loginForm">
            Log in
            <select name="option" class="loginorregister">
                <option>Log in</option>
                <option disabled>Create new</option>
            </select>
            <br>
            <select name="username" class="loginorregister">
                <option>student</option>
                <option>teacher</option>
                <option>principal</option>
            </select>
            <button class="Loginbutton" type = "submit" name = "login">Log in</button>
         </div>
         
         </form>
		        <div style="position:absolute;
   bottom:0;
left: 0;
   width:100%;
   height:60px;
    background-color: black;">
    <div style="width: 50%; float: left;"><a href="https://yellowsink.pl/" style="width: 50%; color: white;">Yellowsink.pl</a></div>
<div style="width: 50%; float: left; text-align: right;"><a href="https://yellowsink.pl/privacypolicy.html" style="color: white;">PrivacyPolicy</a> <a href="https://gubru.blazejczyk.net/CookiePolicy.pdf" target="_blank" style="color: white;">cookie policy</a> </div>
</div>	
      
   </body>
</html>