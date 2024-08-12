<?php 

/* Step logici:
   - Controllare che l'utente abbia i grants per effettuare la prenotazione;
   - Controllare la presenza degli input necessari;
   - Fare la pulizia dei suddetti input;
   - Fare i controlli logici sui suddetti input (ad es. non si può
     prenotare il ritiro di un prodotto in una data antecedente al suo arrivo!);
   - Salvare la prenotazione nel DB;
   - Reindirizzare l'utente alla pagina che stava visualizzando precedentemente,
     visualizzando un messaggio di conferma dell'avvenuta prenotazione;
  Scenario alternativo:
  - Visualizzare messaggio d'errore nel caso in cui la prenotazione non sia andata
    a buon fine; */

    require_once('global.php');

    $productId = $withdrawDate = $withdrawTime = $notes = $errors = '';
    $connection = getConnection();

    if(!isset($_SESSION['loggedUser'])) {
        header("Location: ../login.php");
        exit();
    }
    if (isset($_GET['productId'])) {
        $productId = sanitizeString($_GET['productId']);
        $withdrawDate = sanitizeString($_POST['withdrawDate']);
        $withdrawTime = sanitizeString($_POST['withdrawTime']);
        $notes = sanitizeString($_POST['notes']);
    
        if ($withdrawDate == '' || $withdrawTime == '') {
            $error = 'Alcuni campi mancanti!';
            $_SESSION['errors'] = $error;
            header("Location: ../prenotazioneRitiro.php");
            exit();
        }
        else {
            if (!checkProductAvalaibility($productId)) {
                $error = 'Prodotto non disponibile!';
                $_SESSION['errors'] = $error;
                header("Location: ../index.php");
                exit();
            }   else {
                    $reservationTimestamp = $withdrawDate . ' ' . $withdrawTime;
                    $userEmail = $_SESSION['loggedUser'];
                    try {
                        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
                        $insertionQuery = "INSERT into Reservation
                                       values('$productId','$userEmail','$reservationTimestamp','$notes')";
                    $result = $connection -> query($insertionQuery);
                    }
                    catch (Exception $e) {
                    echo("Database problem : " . $e->getMessage());
                    exit();
                    }
                    if ($result) {
                        $message = "La prenotazione è andata a buon fine!";
                        $_SESSION['message'] = $message;
                        header("Location: ../reservationList.php");
                        exit();
                    } else {
                        $error = "Prenotazione non andata a buon fine";
                        $_SESSION['errors'] = $error;
                        header("Location: ../prenotazioneRitiro.php?productId=" . $productId);
                        exit();
                    }
                }
        }
    }
    
    function checkProductAvalaibility(string $productId) : bool {
        global $connection;
        $checkQuery = "SELECT * 
                       from Products
                       where id = $productId ";
        $result = $connection->query($checkQuery);
        if ($result->num_rows > 0)  {
            $record = $result -> fetch(MYSQLI_ASSOC);
            if ($record['status'] == 'avalaible') 
                return true;
        }
            return false;
    }

    function sanitizeString(string $var) : string
    {
    $var = strip_tags($var);
    $var = htmlentities($var);
    $var = stripslashes($var);
    return $var;
    }
   
?>