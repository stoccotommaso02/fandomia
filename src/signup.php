<?php 

require_once("./lib/global.php");
require_once("header.php");
require_once("footer.php");

/* file che si occupa solo di costruire il template con il form 
di registrazione; useremo poi un signUpController che si occupa
di gestire i dati submittati dal form */
$header = buildHeader();
$footer = buildFooter();
$errorMessage = '';

if (isset($_SESSION['errors'])) {
    $errorMessage = '<p style="color:red;">' . htmlspecialchars($_SESSION['errors']) . '</p>';
    unset($_SESSION['errors']);
} 

$signUpForm = new Template();
$signUpForm = $signUpForm -> render('signup.html',array("header" => $header,
                                                        "errors" => $errorMessage,
                                                        "footer" => $footer));

echo($signUpForm);
?>