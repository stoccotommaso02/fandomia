<?php

require("./lib/DBController.php");
$connection = new DBconnection;
$connection->setConnection();

$jsonBooks = file_get_contents("./assets/libri_aggiornati.json");
$jsonBooks = json_decode($jsonBooks,JSON_OBJECT_AS_ARRAY);
foreach($jsonBooks as $jsonBook) {
    $query = "Insert into Products(id,name,price,release_date,product_type,status,sale_percentage) 
                     values('{$jsonBook['id']}','{$jsonBook['titolo']}',{$jsonBook['prezzo']},'{$jsonBook['data di uscita']}',
                            'book','{$jsonBook['disponibilità']}',{$jsonBook['sconto']});";
    echo($query);
    try {
        $connection->queryDB($query);
    }   catch(Exception $e) {
        echo("Database problem : " . $e->getMessage());
        exit();
    }
}
