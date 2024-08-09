<?php 
require_once("header.php");
require_once("footer.php");

$header = '';
$footer = buildFooter();

if (isset($_GET['error'])) {
    $errorMessage = '<p style="color:red;">' . htmlspecialchars($_GET['error']) . '</p>';
} else {
    $errorMessage = '';
}
if (session_start() && isset($_SESSION['loggedUser']))
   { $header = $_SESSION['loggedUser'];}
else 
    {$header = buildHeader();}

$loginTemplate = file_get_contents("./templates/login.html");
$loginTemplate = str_replace('{{header}}',$header,$loginTemplate);
$loginTemplate = str_replace('{{footer}}',$footer,$loginTemplate);
$loginTemplate = str_replace('{{errors}}',$errorMessage,$loginTemplate);

echo($loginTemplate);

?>