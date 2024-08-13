<?php 

require_once("./lib/global.php");
require_once("header.php");
require_once("footer.php");

$header = '';
$footer = buildFooter();

if (!isset($_SESSION['loggedUser'])) {
    $errorMessage = "Devi essere loggato per effettuare una prenotazione";
    $_SESSION['errors'] = $errorMessage;
    header("Location:login.php");
    exit();
}

$productId = $_POST['product_id'];
unset($_POST['product_id']);

if (isset($_SESSION['errors'])) {
    $errorMessage = '<p style="color:red;">' . htmlspecialchars($_SESSION['errors']) . '</p>';
    unset($_SESSION['errors']);
}

$header = buildHeader();

$reservationTemplate = file_get_contents("./templates/reservationForm.html");
$reservationTemplate = str_replace('{{header}}',$header,$reservationTemplate);
$reservationTemplate = str_replace('{{productId}}',$productId,$reservationTemplate);
$reservationTemplate = str_replace('{{footer}}',$footer,$reservationTemplate);
$reservationTemplate = str_replace('{{errors}}',$errorMessage,$reservationTemplate);

echo($reservationTemplate);

?>