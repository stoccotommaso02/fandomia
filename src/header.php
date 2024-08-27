<?php 
function buildHeader() : string {
    
    session_start();

    $headerTemplate = file_get_contents("./templates/header.html");
    if (isset($_SESSION['loggedUser'])) {
        $logout = '<a href="logout.php">Logout</a>';
        $headerTemplate = str_replace('{{areaPersonale}}',$logout,$headerTemplate);
    } else {
        $login='<a href="login.php" id="loginForm">Login</a>';
        $headerTemplate = str_replace('{{areaPersonale}}',$login,$headerTemplate);
    }

    return $headerTemplate;
}

?>