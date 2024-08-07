<?php 

function buildHeader() : string {

    $headerTemplate = file_get_contents("./templates/header.html");
    
    if ( !isset($_SESSION['id_utente'])) {

        $login='<a href="login.php" id="loginForm>Login<a>';
        $headerTemplate = str_replace('{{areaPersonale}}',$login,$headerTemplate);
    } else {
        $areaPersonale='<a href="areaPersonale.php" id="linkAreaPersoanle">Area personale<a>';
        $headerTemplate = str_replace('{{areaPersonale}}',$areaPersonale,$headerTemplate);
    }

    return $headerTemplate;
}

?>