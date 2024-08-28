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
    header("Location: login.php");
    exit();
}

if (isset($_SESSION['message'])) {
    $reservationList = "<p>" . $_SESSION['message'] . "</p>";
    unset($_SESSION['message']);
}

$reservationList .= retrieveReservationList();

$reservationTemplate = new Template();
$reservationTemplate = $reservationTemplate->render("areaPersonale.html",array('header' => $headerTemplate,
                                                                               'area_personale' => "Lista prenotazioni",
                                                                               'contenutoAreaPersonale' => $reservationList,
                                                                               'footer' => $footerTemplate));

echo($reservationTemplate);

function retrieveReservationList() : string {
$reservationList = "";
$connection = new DBconnection;
$connection ->  setConnection();

$user = $_SESSION['loggedUser'];

$query = "SELECT * , Reservation.id as reservation_id
          from Reservation join Products
               on (Reservation.product_id = Products.id)
          where username = '$user'
          order by reservation_date";
$result = $connection -> queryDB($query);
if (count($result) > 0 ) {
    $reservationList = "<ul>";
    foreach ($result as $record) {
        echo($record['notes']);
        $reservation_card_template = new Template();
        $reservation_card_template = $reservation_card_template->render("reserved_card.html", $record );
        $reservationList .= $reservation_card_template;
    }
    $reservationList .= "</ul>";
} elseif (count($result) == 0) {
    $reservationList = "<p>Non è presente nessuna prenotazione!</p>";
}
return $reservationList;
}

?>