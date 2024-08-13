<?php 

session_start();

if (isset($_SESSION['loggedUser'])) {
    unset($_SESSION['loggedUser']);
} else {
    echo "<div class='main'><br>" .
"You cannot log out because you are not logged in";
}

header("Location: index.php");
?>