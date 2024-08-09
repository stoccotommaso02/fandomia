<?php 

require_once("buildHeader.php");

/* file che si occupa solo di costruire il template con il form 
di registrazione; useremo poi un signUpController che si occupa
di gestire i dati submittati dal form */
$header = buildHeader();

$footer = '';

$signUpForm = file_get_contents("../templates/signup.html");
$signUpForm = str_replace('{{header}}',$header,$signUpForm);
$signUpForm = str_replace('{{footer}}',$footer,$signUpForm);

echo($signUpForm);
?>