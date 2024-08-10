<?php 

require_once('./global.php');

$user = $password = $errors = '';
$connection = getConnection();

if (isset($_POST['user'])) {
    $user = sanitizeString($_POST['user']);
    $password = sanitizeString($_POST['password']);

    if ($user == '' || $password = '')
        $errors = 'Alcuni campi mancanti!';
    else {
        if (!checkUserAvalaibility($user)) {
            $errors = 'Username non disponibile!';
        }
            else {
                $insertionQuery = "INSERT into Users
                                   values('$user','$password')";
                $result = $connection -> query($insertionQuery);
                if ($result) {
                    header("Location: ../index.php");
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
?>