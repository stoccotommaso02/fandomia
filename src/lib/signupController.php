<?php 
/* guardare pagina 420 del libro Learning PHP, MySQL & JavaScript per 
gestire errori nella compilazione del form ,sia che si tratti di
controlli, che di visualizzazione dei relativi messaggi  */
require_once('global.php');

$user = $password = $confirmPassword = $errors = '';

if (isset($_POST['usermail'])) {
    $user = sanitizeString($_POST['usermail']);
    $password = sanitizeString($_POST['password']);
    $confirmPassword = sanitizeString($_POST['confirmPassword']);

    if ($user == '' || $password == '' || $confirmPassword == '')
        $errors = 'Alcuni campi mancanti!';
    else {
        if ( $password !== $confirmPassword ) {
            $errors = 'Attenzione, le due password non coincidono!';
            $_SESSION['errors'] = $errors;
            header("Location: ../signup.php");
            exit();
        }
        elseif (!checkUserAvalaibility($user)) {
            $errors = 'Username non disponibile!';
            $_SESSION['errors'] = $errors;
            header("Location: ../signup.php");
            exit();
        }   else {
                $connection = getConnection();
                $insertionQuery = "INSERT into Users
                                   values('$user','$password')";
                $result = $connection -> query($insertionQuery);
                if ($result) {
                    $message = "La registrazione è andata a buon fine!";
                    $_SESSION['state'] = $message;
                    header("Location: ../login.php" );
                    exit();
                } else {
                    $errors = "Registrazione non andata a buon fine";
                    $_SESSION['errors'] = $errors;
                    header("Location: ../signup.php");
                    exit();
                }
            }
    }
}

function checkUserAvalaibility(string $username) : bool {
    $connection = getConnection();
    $user = sanitizeString($username);
    $checkQuery = "SELECT * 
                   from Users
                   where username = '$user' ";
    $result = $connection->query($checkQuery);
    if ($result->num_rows == 0)
        return true;
        else return false;
}

function sanitizeString(string $var) : string
{
$var = strip_tags($var);
$var = htmlentities($var);
$var = stripslashes($var);
return $var;
}

?>