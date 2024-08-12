<?php 

require_once("./lib/global.php");
require_once("header.php");
require_once("footer.php");

$headerTemplate = buildHeader();
$footerTemplate = buildFooter();
$reservationList = '';

session_start();

if (isset($_SESSION['message'])) {
    $reservationList = "<p>" . $_SESSION['message'] . "</p>";
}

$reservationTemplate = file_get_contents("./templates/areaPersonale.html");
$reservationList .= retrieveReservationList();
$reservationTemplate = str_replace('{{header}}',$headerTemplate,$reservationTemplate);
$reservationTemplate = str_replace('{{contenutoAreaPersonale}}',$reservationList,$reservationTemplate);
$reservationTemplate = str_replace('{{footer}}',$footerTemplate,$reservationTemplate);

echo($reservationTemplate);

function retrieveReservationList() : string {
$reservationList = '';
$connection = getConnection();

$user = $_SESSION['loggedUser'];

$query = "SELECT * 
          from Reservation
           where username = '$user'";
$result = $connection -> query($query);
if ($result->num_rows > 0) {
    $records = $result -> fetch_all(MYSQLI_ASSOC);
    foreach ($records as $record)
        $reservationList .= "<p>" . $record['product_id'] . $record['username'] . $record['reservation_time'] . "</p>";
} elseif ($result->num_rows == 0) {
    $reservationList = "<p>Non è presente nessuna prenotazione!</p>";
}
return $reservationList;
}

?>