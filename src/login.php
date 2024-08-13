<?php 

require_once("./lib/global.php");
require_once("header.php");
require_once("footer.php");

$header = '';
$footer = buildFooter();
$errorMessage = $message = '';

if (isset($_SESSION['errors'])) {
    $errorMessage = '<p style="color:red;">' . htmlspecialchars($_SESSION['errors']) . '</p>';
    unset($_SESSION['errors']);
} else {
    if (isset($_SESSION['state']))  {
        $message = '<p>' . htmlspecialchars($_SESSION['state']) . '</p>';
        unset($_SESSION['state']);
    }
       
}
if (session_start() && isset($_SESSION['loggedUser']))
   { $header = $_SESSION['loggedUser'];}
else 
    {$header = buildHeader();}

$loginTemplate = file_get_contents("./templates/login.html");
$loginTemplate = str_replace('{{header}}',$header,$loginTemplate);
$loginTemplate = str_replace('{{footer}}',$footer,$loginTemplate);
$loginTemplate = str_replace('{{errors}}',$errorMessage,$loginTemplate);
$loginTemplate = str_replace('{{Registration confirmed}}',$message,$loginTemplate);

echo($loginTemplate);

?>