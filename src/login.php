<?php 
$header = '';
require_once("buildHeader.php");
if (session_start() && isset($_SESSION['loggedUser']))
   { $header = $_SESSION['loggedUser'];}
else 
    {$header = buildHeader();}

$loginTemplate = file_get_contents("./templates/login.html");
$loginTemplate = str_replace('{{header}}',$header,$loginTemplate);

echo($loginTemplate);

?>