<?php 
require_once("header.php");
require_once("footer.php");

$header = '';
$footer = buildFooter();

if (session_start() && isset($_SESSION['loggedUser'])) {
    header("Location :areaPersonale.php");
}

if (isset($_GET['error'])) {
    $errorMessage = '<p style="color:red;">' . htmlspecialchars($_GET['error']) . '</p>';
} else {
    $errorMessage = '';
    if (isset($_GET['state']))
        $message = '<p>' . htmlspecialchars($_GET['state']) . '</p>';
        else $message = '';
}

$header = buildHeader();

$loginTemplate = file_get_contents("./templates/login.html");
$loginTemplate = str_replace('{{header}}',$header,$loginTemplate);
$loginTemplate = str_replace('{{footer}}',$footer,$loginTemplate);
$loginTemplate = str_replace('{{errors}}',$errorMessage,$loginTemplate);
$loginTemplate = str_replace('{{Registration confirmed}}',$message,$loginTemplate);

echo($loginTemplate);

?>