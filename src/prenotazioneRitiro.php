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

$productId = $_GET['product_id'];

if (isset($_SESSION['errors'])) {
    $errorMessage = '<p style="color:red;">' . htmlspecialchars($_SESSION['errors']) . '</p>';
    unset($_SESSION['errors']);
} else {
    $errorMessage = '';
    if (isset($_GET['state']))
        $message = '<p>' . htmlspecialchars($_GET['state']) . '</p>';
        else $message = '';
}

$header = buildHeader();

$reservationTemplate = file_get_contents("./templates/reservationForm.html");
$reservationTemplate = str_replace('{{header}}',$header,$reservationTemplate);
$reservationTemplate = str_replace('{{productId}}',$productId,$reservationTemplate);
$reservationTemplate = str_replace('{{footer}}',$footer,$reservationTemplate);
$reservationTemplate = str_replace('{{errors}}',$errorMessage,$reservationTemplate);

echo($reservationTemplate);

?>