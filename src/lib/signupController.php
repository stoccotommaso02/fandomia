<?php 
/* guardare pagina 420 del libro Learning PHP, MySQL & JavaScript per 
gestire errori nella compilazione del form ,sia che si tratti di
controlli, che di visualizzazione dei relativi messaggi  */
require_once('global.php');
require_once("./DBController.php");

$user_email = $password = $confirmPassword = '';
$errors = array();

if (!(isset($_POST['usermail']) &&
       isset($_POST['password']) &&
       isset($_POST['confirmPassword'])))   {
        $errors[] = "Alcuni campi sono mancanti";
        $_SESSION['errors'] = $errors;
        header("Location: ../signup.php");
        exit();
       }

    $user_email = sanitizeString($_POST['usermail']);
    $password = sanitizeString($_POST['password']);
    $confirmPassword = sanitizeString($_POST['confirmPassword']);

    if (!empty(validate_email($user_email)))    {
        $errors[] = validate_email($user_email);
    }

    if (!empty(validate_password($password)))   {
    $errors[] = validate_password($password);
    }

    if ( $password !== $confirmPassword ) {
            $errors[] = 'Attenzione, le due password non coincidono!';
    }
    
    if (!is_email_available($user_email)) {
            $errors[] = "Già registrato un profilo con l'email inserita";
        }
    
    if  (empty($errors))  {
                $connection = new DBconnection;
                $connection -> setConnection();
                $insertionQuery = "INSERT into Users
                                   values('$user_email','$password')";
                $result = $connection -> alterQueryDB($insertionQuery);
                if ($result) {
                    $message = "La registrazione è andata a buon fine!";
                    $_SESSION['state'] = $message;
                    header("Location: ../login.php" );
                    exit();
                } else {
                    $errors[] = "Registrazione non andata a buon fine";
                }
            }
    
    $_SESSION['errors'] = $errors;
    header("Location: ../signup.php" );
    exit();

function is_email_available(string $user_email) : bool {
    $connection = new DBconnection;
    $connection -> setConnection();
    $checkQuery = "SELECT * 
                   from Users
                   where username = '$user_email' ";
    $result = $connection->queryDB($checkQuery);
    return count($result) == 0;
}

function validate_password(string $field)   {
    if ($field == "")    {
        return "Nessuna password inserita";
    }   else if (strlen($field) < 8)    {
        return "La password dev'essere lunga almeno 8 caratteri";
    }   else if (!preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/",$field)) {
        return "La password richiede almeno un carattere maiuscolo, uno minuscolo ed un numero da 0 a 9";
    }
}

function validate_email(string $field)  {
    if ($field == "")   {
        return "Nessuna email inserita";
    }   else if (! (strpos($field,"@") > 0) ||
                    preg_match("/[^a-zA-Z0-9.@_-]/",$field))    {
                        return "L'email inserita non è valida";
                    }
}

?>