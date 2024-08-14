<?php 

require_once("./lib/global.php");
require_once("./lib/templateController.php");
require_once("header.php");
require_once("footer.php");

$header = '';
$footer = buildFooter();
$errorMessage = $state = '';

if (session_start() && isset($_SESSION['loggedUser'])) {
    header("Location :areaPersonale.php");
}

if (isset($_SESSION['errors'])) {
    $errorMessage = '<p style="color:red;">' . htmlspecialchars($_SESSION['errors']) . '</p>';
    unset($_SESSION['errors']);
} else {
    if (isset($_SESSION['state']))  {
        $state = '<p>' . htmlspecialchars($_SESSION['state']) . '</p>';
        unset($_SESSION['state']);
    }
       
}

$header = buildHeader();
$loginTemplate = new Template();
$loginTemplate = $loginTemplate->render("login.html",array('header' => $header,
                                                           'footer' => $footer,
                                                           'errors' => $errorMessage,
                                                           'state' => $state
)); 

echo($loginTemplate);

?>