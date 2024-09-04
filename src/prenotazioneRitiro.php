<?php 

require_once("./lib/global.php");
require_once("./lib/templateController.php");
require_once("./lib/DbController.php");
require_once("header.php");
require_once("footer.php");

$errorMessage = '';
if (!isset($_SESSION['loggedUser'])) {
    $errorMessage = "Devi essere loggato per effettuare una prenotazione";
    $_SESSION['errors'] = $errorMessage;
    header("Location: ../login.php?redirect_url=" . urlencode($_GET['product_id']));
    exit();
}
if (!isset($_REQUEST['product_id']) || $_REQUEST['product_id'] == null) {
    header("Location: 404.php");
    exit();
}

$productId = sanitizeString($_REQUEST['product_id']);

$connection =new DBconnection();
$connection -> setConnection();
try{
    $productQuery = "SELECT * FROM Products WHERE id = $productId ";
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        $results = $connection -> queryDB($productQuery);
        }  catch (Exception $e) {
            echo("Database problem : " . $e->getMessage());
            exit();
        }
    
    $release_date = '';

    if (!empty($results)) {
        // ciclo dei record restituiti dalla query
        foreach ($results as $row) {
            $product_name = $row["name"];
            $product_type = $row["product_type"];
            $release_date = $row['release_date'];
            $reservedProduct = new Template();
            $reservedProduct = $reservedProduct->render("reservedProduct.html",$row);
        }
     } else {
        $errorMessage = "Spiacenti,il prodotto non è al momento presente!";
    }

    $errors_list = '';

    if (isset($_SESSION['errors'])) {
        $errors = $_SESSION['errors'];
        $errors_list = '<ul>';
        foreach($errors as $error){
            $errors_list .= '<li>'.$error.'</li>';
            }
        $errors_list .= '</ul>';
        unset($_SESSION['errors']);
    } 

switch ($product_type)  {
    case "book":
        $product_typename = "Libri";
        break;
    case "comic":
        $product_typename = "Fumetti";
        break;
    case "videogame":
        $product_typename = "Videogiochi";
        break;
    case "music":
        $product_typename = "Musica";
        break;
}

$header = buildHeader();
$footer = buildFooter();
$submit_action = isset($_POST['reservation_id']) ? "Modifica" : "Prenota" ;
$reservation_id = isset($_POST['reservation_id']) ?  "<input type='hidden' name='reservation_id' value={$_POST['reservation_id']}>" : "";
$notes = '';
$data_ritiro = '';
$fascia_oraria = '';
/* Se è presente $_POST['reservation_id'], vuol dire che il form che deve essere inviato al browser
   serve per modificare una prenotazione già esistente; è buona norma quindi che gli input del form presentino
   i "vecchi" dati della suddetta prenotazione*/
if(isset($_POST['reservation_id']))  {
    $connection -> setConnection();
    $reservation_query = "SELECT * 
                          From Reservation
                          WHERE id = {$_POST['reservation_id']}";
    try {
        $result = $connection -> queryDB($reservation_query);
    }   catch (Exception $e) {
        echo("Database problem : " . $e->getMessage());
        exit();
    }
    if (count($result) == 1) {
        $notes = $result[0]['notes'];
        $data_ritiro = $result[0]['reservation_date'];
        $fascia_oraria = $result[0]['reservation_time'];
    }
}

$timeSlots = [
    "09:00-10:00",
    "10:00-11:00",
    "11:00-12:00",
    "12:00-13:00",
    "15:00-16:00",
    "16:00-17:00",
    "17:00-18:00",
    "18:00-19:00"
];
$option_values = '';
foreach ($timeSlots as $time)   {
    $option_values .= "<option value=\"$time\"";
    $option_values .= $time === $fascia_oraria ? 'selected' : '';
    $option_values .= ">$time</option>";
}

//Di default, l'utente può prenotare il ritiro a partire dalla data maggiore fra quella di uscita di un
//prodotto e il giorno successivo alla data odierna
$minDate = date('Y-m-d', strtotime('+1 day')) < $release_date ? $release_date : date('Y-m-d', strtotime('+1 day'));

$reservationTemplate = new Template();
$reservationTemplate =  $reservationTemplate->render("reservationForm.html",array('header' => $header,
                                                                                  'product_id' => $productId,
                                                                                  'product_type' => $product_type,
                                                                                  'product_name' => $product_name,
                                                                                  'product_typename' => $product_typename,
                                                                                  'reserved_product' => $reservedProduct,
                                                                                  'min_date' => $minDate,
                                                                                  'data_ritiro' => $data_ritiro,
                                                                                  'option_values' => $option_values,
                                                                                  'notes' => $notes,
                                                                                  'submit_action' => $submit_action,
                                                                                  'footer' => $footer,
                                                                                  'errors' => $errorMessage,
                                                                                  'reservation_id' => $reservation_id));


echo($reservationTemplate);

?>