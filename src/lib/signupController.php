<?php 

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
            $errors[] = "L'email inserita è già stata registrata!";
        }
    
    if  (empty($errors))  {
                $connection = new DBconnection;
                $connection -> setConnection();
                $hashed_password = password_hash($password, PASSWORD_BCRYPT);
                $insertionQuery = "INSERT into Users
                                   values('$user_email','$hashed_password')";
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
    $_SESSION['previous_usermail'] = $_POST['usermail']; 
    header("Location: ../signup.php" );
    exit();

function is_email_available(string $user_email) : bool {
    $connection = new DBconnection;
    $connection -> setConnection();
    $checkQuery = "SELECT * 
                   from Users
                   where email = '$user_email' ";
    $result = $connection->queryDB($checkQuery);
    return count($result) == 0;
}

function validate_password(string $field)   {
    if ($field == "")    {
        return "Nessuna password inserita";
    }   else if (strlen($field) < 8)    {
        return "La password dev'essere lunga almeno 8 caratteri";
    }   else if (strlen($field) > 16)    {
        return "La password dev'essere lunga al massimo 16 caratteri";
    } else if (!preg_match("/^[a-zA-Z0-9]+$/", $field)) {
        return "La password può contenere solo lettere maiuscole, lettere minuscole e numeri";
    }   else if (!preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z0-9]+$/",$field)) {
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

