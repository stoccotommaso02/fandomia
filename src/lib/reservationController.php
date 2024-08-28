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

        if(!empty(validate_withdraw_date($withdrawDate)))
            $errors[] = validate_withdraw_date($withdrawDate);

        if(!empty(validate_withdraw_time($withdrawTime)))
            $errors[] = validate_withdraw_time($withdrawTime);

        if ($notes && !empty(validate_notes($notes)))
            $errors[] = validate_notes($notes);

        if (empty($errors)) {
        //Se c'è un numero di prenotazione nell'array POST, l'utente vuole modificare una
        //prenotazione già esistente
        if (isset($_POST['reservation_id']))   {
            $userEmail = $_SESSION['loggedUser'];
            try {
                $connection = new DBconnection;
                $connection -> setConnection();

                mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
                $updateQuery = "UPDATE Reservation
                                SET reservation_date = '{$_POST['data_ritiro']}',
                                    reservation_time = '{$_POST['fascia_oraria']}',
                                    notes = '{$_POST['notes']}'
                                WHERE Reservation.id = {$_POST['reservation_id']}" ;
                $result = $connection -> alterQueryDB($updateQuery);
            }
            catch (Exception $e) {
                echo("Database problem : " . $e->getMessage());
                exit();
            }
            if ($result) {
                $message = "La prenotazione è stata modificata con successo!";
                $_SESSION['message'] = $message;
            } else {
                $error = "Modifica della prenotazione non andata a buon fine";
                $_SESSION['errors'] = $error;
            }
        //Indipendentemente dal successo o meno del tentativo di modifica, l'utente viene re-indirizzato
        //alla lista delle sue prenotazioni, ove visualizzerà la prenotazione modificata o potrà fare
        //un nuovo tentativo di modifica    
            header("Location: ../reservationList.php");
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
    //Se non è presente il codice identificativo del prodotto e il valore del campo submit è la stringa :"cancella_prenotazione",
    // l'utente sta provando ad eliminare una prenotazione
       else    if ($_POST['submit'] == 'cancella_prenotazione') {
            $reservation_id = sanitizeString($_POST['reservation_id']);
            $connection = new DBconnection;
            try {
                mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
                $deletionQuery = "DELETE from Reservation where id = {$reservation_id}";
                $connection ->setConnection();
                $result = $connection -> alterQueryDB($deletionQuery);
            }
            catch (Exception $e) {
                echo("Database problem : " . $e->getMessage());
                exit();
            }
            if ($result) {
                $message = "La prenotazione è stata cancellata con successo!";
                $_SESSION['message'] = $message;
            } else {
                $error = "Non è stato possibile cancellare la prenotazione";
                $_SESSION['errors'] = $error;
            }
            header("Location: ../reservationList.php");
            exit();
        }
        //Non è presente il codice del prodotto da prenotare, ne il codice identificativo di
        //una prenotazione da cancellare, quindi probabilmente c'è stato un problema di reperimento di
        //una risorsa; che ci stia reindirizzamento ad una pagina 404/505 ?
           else  {

            header("Location:../404.php");
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
        return $withdrawCheck();
    }