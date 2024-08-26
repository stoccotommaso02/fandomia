<?php 

    require_once('global.php');
    require_once('DBController.php');

    $product_id = $withdrawDate = $withdrawTime = $notes = '';
    $errors = array();

    if(!isset($_SESSION['loggedUser']) || $_SESSION['loggedUser'] == null ) {
        $_SESSION['errors'] = "Effettuare il login per effettuare una prenotazione";
        header("Location: ../login.php?redirect_url=" . urlencode($_GET['product_id']));
        exit();
    }
    if (isset($_POST['product_id'])) {
        $product_id = sanitizeString($_POST['product_id']);
        $withdrawDate = sanitizeString($_POST['data_ritiro']);
        $withdrawTime = sanitizeString($_POST['fascia_oraria']);
        $notes = sanitizeString($_POST['notes']);

        if(!empty(validate_withdraw_date($withdrawDate)))
            $errors[] = validate_withdraw_date($withdrawDate);

        if(!empty(validate_withdraw_time($withdrawTime)))
            $errors[] = validate_withdraw_time($withdrawTime);

        if ($notes && !empty(validate_notes($note)))
            $errors[] = validate_notes($notes);

        if (empty($errors)) {
            if (!checkProductAvalaibility($product_id)) {
                $errors[] = 'Prodotto non disponibile!';
                $_SESSION['errors'] = $errors;
                header("Location: ../prenotazioneRitiro.php?product_id=" . urlencode($product_id));
                exit();
            }   else { 
                        $userEmail = $_SESSION['loggedUser'];
                        try {
                            $connection = new DBconnection;
                            $connection -> setConnection();

                            mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
                            $insertionQuery = "INSERT into Reservation(product_id,username,reservation_date,reservation_time,notes)
                                               values('$product_id','$userEmail','$withdrawDate','$withdrawTime','$notes')";
                            $result = $connection -> alterQueryDB($insertionQuery);
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
                            header("Location: ../prenotazioneRitiro.php?product_id=" . $product_id);
                            exit();
                        }
                }
            }   
        }

        $_SESSION['errors'] = $errors;
        header("Location: ../prenotazioneRitiro.php?product_id=" . $product_id );
        exit();
    
    function checkProductAvalaibility(string $product_id) : bool {
        $connection = getConnection();
        $checkQuery = "SELECT * 
                       from Products
                       where id = '$product_id' ";
        $result = $connection->query($checkQuery);
        if ($result->num_rows > 0)  {
            $record = $result->fetch_assoc();
            if ($record['status'] == 'available') {
                return true;
            }
        }
        return false;
    }

    function checkWithdrawDate(string $product_id , string $date): array {
        $withdrawCheck = array();
        $connection = getConnection();
        $checkQuery = "SELECT * 
                       from Products
                       where id = '$product_id' ";
        $result = $connection->query($checkQuery);
        if ($result->num_rows > 0)  {
            $record = $result->fetch_assoc();
            if ($record['release_date'] <= $date) {
                $withdrawCheck = array("avalaibility" => true);
                return $withdrawCheck;
            } else {
                $withdrawCheck = array("avalaibility" => false,
                                       "product_release_date" => $record['release_date']);
                return $withdrawCheck;
            }
        }
    }
    
    function validate_withdraw_date(string $date) : string {
        if ($date == "") {
            return "Nessuna data inserita per il ritiro";
        }   else if (!validateDate($date))  {
            return "La data inserita non è valida";
        }
        return "";
    }

    function validate_withdraw_time(string $time_interval) : string {
        if ($time_interval == "")   {
            return "Nessuna fascia oraria indicata per il ritiro";
        }   else if (!preg_match("/^\d{2}:\d{2}-\d{2}:\d{2}$/",$time_interval))   {
            return "La fascia oraria indicata non è valida";
        }
        return "";
    }
    
    function validate_notes(string $note) : string {
        if (!preg_match("/^.{0,140}$/",$note))   {
            return "Le note inserite non possono eccedere i 140 caratteri";
        }
        return "";
    }

    function validateDate($date, $format = 'Y-m-d')
{
    $d = DateTime::createFromFormat($format, $date);
    return $d && $d->format($format) == $date;
}
?> 