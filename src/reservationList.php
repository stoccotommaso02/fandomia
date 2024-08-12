<?php 

require_once("./lib/global.php");
session_start();

$connection = getConnection();

$user = $_SESSION['loggedUser'];

$query = "SELECT * 
          from Reservation
           where username = '$user'";
$result = $connection -> query($query);
if ($result->num_rows > 0) {
    $records = $result -> fetch_all(MYSQLI_ASSOC);
    foreach ($records as $record)
        echo($record['product_id'] . $record['username'] . $record['reservation_time']);
}

?>