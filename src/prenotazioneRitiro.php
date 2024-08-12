<?php 
require_once("header.php");
require_once("footer.php");

session_start();

$header = '';
$footer = buildFooter();

if (!isset($_SESSION['loggedUser'])) {
    header("Location:login.php?error=" . urlencode("Devi essere loggato per effettuare una prenotazione"));
    exit();
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

$reservationTemplate = file_get_contents("./templates/reservationForm.html");
$reservationTemplate = str_replace('{{header}}',$header,$reservationTemplate);
$reservationTemplate = str_replace('{{footer}}',$footer,$reservationTemplate);
$reservationTemplate = str_replace('{{errors}}',$errorMessage,$reservationTemplate);
$reservationTemplate = str_replace('{{Registration confirmed}}',$message,$reservationTemplate);

echo($reservationTemplate);

?>