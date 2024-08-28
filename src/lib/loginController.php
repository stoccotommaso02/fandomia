<?php

require_once("./global.php");

if (isset($_POST['userEmail'])) {
 $user = sanitizeString($_POST['userEmail']);
 $password = sanitizeString($_POST['password']);

 if ($user == "" || $password == "") {
     $error = "Non sono stati compilati tutti i campi!";
     $_SESSION['errors'] = $error;
     header("Location: ../login.php");
     exit();
} else  {
 $connection = new DBconnection;
 $connection -> setConnection();
 $result = $connection -> queryDB("SELECT username,password as hashed_password
                                   FROM Users
                                   WHERE username='$user' ");
 if (empty($result) || !password_verify($password , $result[0]['hashed_password']))  {
   $error = "Credenziali non corrette";
   $_SESSION['errors'] = $error;
   header("Location: ../login.php");
   exit();
 } else  {
   $_SESSION['loggedUser'] = $user;
   if(isset($_POST['redirect_url']) && $_POST['redirect_url'] != null)   {
    header("Location:../prenotazioneRitiro.php?product_id=" . $_POST['redirect_url']);
   }  else  {
   header("Location: ../index.php");
   }
  }
 }
}

 function queryMySql(string $query) {
    $connection = getConnection();
    $result = $connection->query($query);
    return $result;
 }
/* La prof in classe ha detto che sarebbe bene, quando ci si logga/registra, essere reindirizzato
non di default alla homePage, ma alla pagina in cui si era prima; decidere se farlo! Il modo che ho trovato è che
venga salvato $_SESSION['last_page'] = $_SERVER['REQUEST_URI'] e poi :
if (isset($_SESSION['last_page'])) {
            $redirect_url = $_SESSION['last_page'];
            unset($_SESSION['last_page']); // Rimuove la variabile per evitare reindirizzamenti non voluti in futuro
        } 
        header("Location: $redirect_url");
        exit(); */
?>