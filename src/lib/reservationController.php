<?php 

    require_once('global.php');

    $product_id = $withdrawDate = $withdrawTime = $notes = $errors = '';
    $connection = getConnection();

    if(!isset($_SESSION['loggedUser']) || $_SESSION['loggedUser'] == null ) {
        $_SESSION['errors'] = "Effettuare il login per visualizzare la lista delle prenotazioni";
        header("Location: ../login.php?redirect_url=" . urlencode($_GET['product_id']));
        exit();
    }
    if (isset($_GET['product_id'])) {
        $product_id = sanitizeString($_GET['product_id']);
        $withdrawDate = sanitizeString($_POST['data_ritiro']);
        $withdrawTime = sanitizeString($_POST['fascia_oraria']);
        $notes = sanitizeString($_POST['notes']);
    
        if ($withdrawDate == '' || $withdrawTime == '') {
            $error = 'Alcuni campi mancanti!';
            $_SESSION['errors'] = $error;
            header("Location: ../prenotazioneRitiro.php?product_id=" . urlencode($product_id));
            exit();
        }
        else {
            if (!checkProductAvalaibility($product_id)) {
                $error = 'Prodotto non disponibile!';
                $_SESSION['errors'] = $error;
                header("Location: ../prenotazioneRitiro.php?product_id=" . urlencode($product_id));
                exit();
            }   else { 
                    $withdrawCheck = checkWithdrawDate($product_id , $withdrawDate);
                    if (!$withdrawCheck['avalaibility']) {
                /* Nell'errorMessage posso indicare esplicitamente la data dalla quale il prodotto
                sarà disponibile */

                        $errorMessage = "La data di ritiro deve essere posteriore al " . $withdrawCheck['product_release_date'];
                        $_SESSION['errors'] = $errorMessage;
                        header("Location: ../prenotazioneRitiro.php?error=" . urlencode("DataAnteriore") . "&product_id=" . urlencode($product_id));
                        exit();
                }   else {
                        $reservationDate = $withdrawDate;
                        $reservationTime = $withdrawTime;
                        $userEmail = $_SESSION['loggedUser'];
                        try {
                            mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
                            $insertionQuery = "INSERT into Reservation(product_id,username,reservation_date,reservation_time,notes)
                                               values('$product_id','$userEmail','$reservationDate','$reservationTime','$notes')";
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
                            header("Location: ../prenotazioneRitiro.php?product_id=" . $product_id);
                            exit();
                        }
                }
            }   
        }
    }
    
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $reservation_id = sanitizeString($_POST['reservation_id']);
        try {
            mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
            $deletionQuery = "DELETE from Reservation where id = {$reservation_id}";
            $result = $connection -> query($deletionQuery);
        }
        catch (Exception $e) {
            echo("Database problem : " . $e->getMessage());
            exit();
        }
        if ($result) {
            $message = "La cancellazione è stata cancellata con successo!";
            $_SESSION['message'] = $message;
        } else {
            $error = "Non è stato possibile cancellare la prenotazione";
            $_SESSION['errors'] = $error;
        }
        header("Location: ../reservationList.php");
        exit();
    }

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
    
?>