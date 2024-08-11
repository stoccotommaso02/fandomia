<?php 
/* guardare pagina 420 del libro Learning PHP, MySQL & JavaScript per 
gestire errori nella compilazione del form ,sia che si tratti di
controlli, che di visualizzazione dei relativi messaggi  */
require_once('global.php');

$user = $password = $confirmPassword = $errors = '';
$connection = getConnection();

if (isset($_POST['usermail'])) {
    $user = sanitizeString($_POST['usermail']);
    $password = sanitizeString($_POST['password']);
    $confirmPassword = sanitizeString($_POST['confirmPassword']);

    if ($user == '' || $password == '' || $confirmPassword == '')
        $errors = 'Alcuni campi mancanti!';
    else {
        if (!checkUserAvalaibility($user)) {
            $errors = 'Username non disponibile!';
            header("Location: ../signup.php?errors=" . urlencode($errors));
            exit();
        } elseif ( $password !== $confirmPassword) {
            $errors = 'Attenzione, le due password non coincidono!';
            header("Location: ../signup.php?errors=" . urlencode($errors));
            exit();
        }
            else {
                $insertionQuery = "INSERT into Users
                                   values('$user','$password')";
                $result = $connection -> query($insertionQuery);
                if ($result) {
                    $message = "La registrazione è andata a buon fine!";
                    header("Location: ../login.php?state=" . urlencode($message));
                } else {
                    $errors = "Registrazione non andata a buon fine";
                    header("Location: ../signup.php?errors=" . urlencode($errors));
                    exit();
                }
            }
    }
}

function checkUserAvalaibility(string $username) : bool {
    global $connection;
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