<?php 

require_once("./lib/global.php");
require_once("./lib/templateController.php");
require_once("header.php");
require_once("footer.php");

$header = '';
$footer = buildFooter();
$errorMessage = '';
if (!isset($_SESSION['loggedUser'])) {
    $errorMessage = "Devi essere loggato per effettuare una prenotazione";
    $_SESSION['errors'] = $errorMessage;
    header("Location:login.php");
    exit();
}
if (!isset($_GET['product_id']) || $_GET['product_id'] == null) {
    header("Location:index.php");
    exit();
}

$productId = sanitizeString($_GET['product_id']);

if (isset($_SESSION['errors']) && $_SESSION['errors'] != null ) {
    $errorMessage = '<p style="color:red;">' . htmlspecialchars($_SESSION['errors']) . '</p>';
    unset($_SESSION['errors']);
}

$header = buildHeader();

$reservationTemplate = new Template();
$reservationTemplate =  $reservationTemplate->render("reservationForm.html",array('header' => $header,
                                                                                  'product_id' => $productId,
                                                                                  'footer' => $footer,
                                                                                  'errors' => $errorMessage));

echo($reservationTemplate);

?>