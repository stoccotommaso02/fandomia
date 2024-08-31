<?php

require_once("./global.php");
require_once("./DBController.php");

if(isset($_SESSION['loggedUser'])) {
  $error = "Per un nuovo login,effettuare prima il logout!";
  $_SESSION['errors'] = $error;
  header("Location: ../index.php");
  exit();
}

if (!isset($_POST['userEmail']) || !isset($_POST['password'])) {
  $error = "Non sono stati compilati tutti i campi!";
  $_SESSION['errors'] = $error;
  header("Location: ../login.php");
  exit();
}

 $user = sanitizeString($_POST['userEmail']);
 $password = sanitizeString($_POST['password']);

<<<<<<< HEAD
 
 if ($user == "" || $pass == "") {
=======
 if ($user == "" || $password == "") {
>>>>>>> homePage-html
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
   //Da migliorare la redirection, farla per qualsiasi pagina precedente?
   //Guardare commento a piè pagina
   if(isset($_POST['redirect_url']) && $_POST['redirect_url'] != null)   {
    header("Location:../prenotazioneRitiro.php?product_id=" . $_POST['redirect_url']);
   }  else if (isset($_SESSION['previous_url']))  {
    $previous_url = $_SESSION['previous_url'];
    unset($_SESSION['previous_url']);
    header("Location:../$previous_url");
    exit();
   }
     else  {
   header("Location: ../index.php");
   exit();
   }
  }
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