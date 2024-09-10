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

 if ($user == "" || $password == "") {
     $error = "Non sono stati compilati correttamente tutti i campi!";
     $_SESSION['errors'] = $error;
     header("Location: ../login.php");
     exit();
} else  {
 $connection = new DBconnection;
 $connection -> setConnection();
 $result = $connection -> queryDB("SELECT email,password as hashed_password
                                   FROM Users
                                   WHERE email='$user' ");
 if (empty($result) || !password_verify($password , $result[0]['hashed_password']))  {
   $error = "Credenziali non corrette";
   $_SESSION['errors'] = $error;
   header("Location: ../login.php");
   exit();
 } else  {
   $_SESSION['loggedUser'] = $user;
   
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
