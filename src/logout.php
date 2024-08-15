<?php 

require_once("./lib/global.php");

if (destroySession()) {
    session_start();
    $_SESSION['state'] = "Logout effettuato con successo!";
    header("Location: index.php");
    exit();
}

function destroySession() : bool {
    $_SESSION = array();
    return session_destroy();
}
?>