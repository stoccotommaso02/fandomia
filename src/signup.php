<?php 

require_once("./lib/global.php");
require_once("header.php");
require_once("footer.php");

$header = buildHeader();
$footer = buildFooter();
$errors_list = '';
$usermail = '';

if (isset($_SESSION['errors'])) {
    $errors = $_SESSION['errors'];
    $errors_list = '<ul id="errorList">';
    foreach($errors as $error){
        $errors_list .= '<li class="formError">'.$error.'</li>';
        }
        $errors_list .= '</ul>';
    unset($_SESSION['errors']);
    if (isset($_SESSION['previous_usermail']))   {
        $usermail = $_SESSION['previous_usermail'];
        unset($_SESSION['previous_usermail']);
    }
} 

$signUpForm = new Template();
$signUpForm = $signUpForm -> render('signup.html',array("header" => $header,
                                                        "errors" => $errors_list,
                                                        "usermail" => $usermail,
                                                        "footer" => $footer));

echo($signUpForm);
