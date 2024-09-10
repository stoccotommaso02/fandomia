<?php 

require_once("./lib/global.php");
require_once("./lib/DBController.php");
require_once("header.php");
require_once("footer.php");

$headerTemplate = buildHeader();
$footerTemplate = buildFooter();
$reservationList = '';

if (!isset($_SESSION['loggedUser'])) {
    $error = "Devi prima loggarti per visualizzare la lista delle tue prenotazioni";
    $_SESSION['errors'] = $error;
    $_SESSION['previous_url'] = "reservationList.php";
    header("Location: login.php");
    exit();
}

if (isset($_SESSION['message'])) {
    $reservationList = "<p class='sessionMessage' role='alert'>" . $_SESSION['message'] . "</p>";
    unset($_SESSION['message']);
}

$reservationList .= retrieveReservationList();

$reservationTemplate = new Template();
$reservationTemplate = $reservationTemplate->render("reservation_list.html",array('header' => $headerTemplate,
                                                                                  'reservation_list' => $reservationList,
                                                                                  'footer' => $footerTemplate));

echo($reservationTemplate);

function retrieveReservationList() : string {
$reservationList = "";
$connection = new DBconnection;
$connection ->  setConnection();

$user = $_SESSION['loggedUser'];

$query = "SELECT * , Reservation.id as reservation_id , Reservation.notes
          from Reservation join Products
               on (Reservation.product_id = Products.id)
          where email = '$user'
          order by reservation_date";
$result = $connection -> queryDB($query);
if (count($result) > 0 ) {
    $reservationList = "<ul>";
    foreach ($result as $record) {
        $reservation_card_template = new Template();
        $record['reservation_date_formatted'] = date("d/m/Y", strtotime($record['reservation_date']));
        $record['release_date_formatted'] = date("d/m/Y", strtotime($record['release_date']));
        $reservation_card_template = $reservation_card_template->render("reserved_card.html", $record );
        $reservationList .= $reservation_card_template;
    }
    $reservationList .= "</ul>";
} elseif (count($result) == 0) {
    $reservationList = "<p role='alert'>Non è presente nessuna prenotazione!</p>";
}
return $reservationList;
}

?>