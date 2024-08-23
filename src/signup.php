<?php 

require_once("./lib/global.php");
require_once("header.php");
require_once("footer.php");

/* file che si occupa solo di costruire il template con il form 
di registrazione; useremo poi un signUpController che si occupa
di gestire i dati submittati dal form */
$header = buildHeader();
$footer = buildFooter();
$errors_list = '';

if (isset($_SESSION['errors'])) {
    $errors = $_SESSION['errors'];
    $errors_list = '<ul>';
    foreach($errors as $error){
        $errors_list .= '<li>'.$error.'</li>';
        }
        $errors_list .= '<ul>';
    unset($_SESSION['errors']);
} 

$signUpForm = new Template();
$signUpForm = $signUpForm -> render('signup.html',array("header" => $header,
                                                        "errors" => $errors_list,
                                                        "footer" => $footer));

echo($signUpForm);
?>