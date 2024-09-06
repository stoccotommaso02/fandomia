<?php 

require_once("./lib/global.php");
require_once("./lib/templateController.php");
require_once("./header.php");
require_once("./footer.php");

$header = '';
$footer = buildFooter();
$errorMessage = $state = '';

if (isset($_SESSION['loggedUser']) && $_SESSION['loggedUser'] != null ) {
    header("Location: index.php");
}

if (isset($_SESSION['errors'])) {
    $errorMessage = '<p class="formError">' . htmlspecialchars($_SESSION['errors']) . '</p>';
    unset($_SESSION['errors']);
} else {
    if (isset($_SESSION['state']))  {
        $state = '<p class="sessionState">' . htmlspecialchars($_SESSION['state']) . '</p>';
        unset($_SESSION['state']);
    }
       
}

$header = buildHeader();

$redirect_url=isset($_GET['redirect_url']) ? $_GET['redirect_url'] : '';

$loginTemplate = new Template();
$loginTemplate = $loginTemplate->render("login.html",array('header' => $header,
                                                           'redirect_url' => $redirect_url,
                                                           'footer' => $footer,
                                                           'errors' => $errorMessage,
                                                           'state' => $state
)); 

echo($loginTemplate);

