<?php 
function buildHeader() : string {
    
    session_start();

    $headerTemplate = file_get_contents("./templates/header.html");
    if (isset($_SESSION['loggedUser'])) {
        $areaPersonale = '<a href="areaPersonale.php" id="areaPersonale">Area personale</a>';
        $headerTemplate = str_replace('{{areaPersonale}}',$areaPersonale,$headerTemplate);
    } else {
        $login='<a href="login.php" id="loginFormLink">Login</a>';
        $headerTemplate = str_replace('{{areaPersonale}}',$login,$headerTemplate);
    }

    return $headerTemplate;
}

?>