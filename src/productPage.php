<?php 

require_once("./lib/global.php");
require_once("./lib/DBController.php");
require_once("header.php");
require_once("footer.php");

$header = buildHeader();
$footer = buildFooter();

if (!isset($_GET['product_id']) || $_GET['product_id'] == null ) {
    header("Location: 404.php");
    exit();
} else {
    $product_id = sanitizeString($_GET['product_id']);
    $connection = new DBconnection();
    $connection -> setConnection();

    try {
    $result = $connection->queryDB("SELECT *
    FROM Products
    WHERE id = $product_id");
    }
    catch(Exception $e){
        echo("Database problem: " . $e->getMessage());
        exit();
    }

    if(count($result) != 1){
        header("Location: 404.php");
        exit();
    }

    $row = $result[0];
    $product_type = $row["product_type"];
    $productTable = $plural = "";

    switch ($product_type)  {
        case "Libro":
            $productTable = "Books";
            $plural = "Libri";
            break;
        case "Fumetto":
            $productTable = "Comics";
            $plural = "Fumetti";
            break;
        case "Videogioco":
            $productTable = "Videogames";
            $plural = "Videogiochi";
            break;
        case "Musica":
            $productTable = "Music";
            $plural = "Musica";
            break;
    }
    
    try {
        $connection = new DBconnection();
        $connection->setConnection();

        $productQuery = "SELECT *
        FROM Products join $productTable on Products.id  = $productTable.id
        WHERE Products.id = $product_id";

        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        $results = $connection -> queryDB($productQuery);
        }  catch (Exception $e) {
            echo("$product_type");
            echo("$productTable");
            echo("Database problem : " . $e->getMessage());
            exit();
        }
        if (!empty($results)) {
          foreach($results as $record)  {
            $productTemplate = new Template();
            
            $index = 0;
            $extra_infos = '';

// Itera sull'array associativo
foreach ($record as $key => $value) {
    $index++; //FIXME
    // Se l'indice è maggiore o uguale a 7, esegui le operazioni
    if ($index >= 9) {
        // Esegui le operazioni che desideri su chiave e valore
        $extra_infos .= "<dt>$key</dt> <dd>$value</dd>";
    }
}
            $productTemplate = $productTemplate -> render("product_page.html",array("header" => $header,
                                                                                    "id" => $record['id'],
                                                                                    "name" => $record['name'],
                                                                                    "product_type" => $product_type,
                                                                                    "breadcrumb_text" => $plural,
                                                                                    "extra_infos" => $extra_infos,
                                                                                    "status" => $record['status'],
                                                                                    "release_date" => $record['release_date'],
                                                                                    "price" => $record['price'],
                                                                                    "sale_percentage" => $record['sale_percentage'],
                                                                                    "description" => $record['description'],
                                                                                    "check_unavailable" => $record['status'] == 'Non disponibile'? "disabled" : '',
                                                                                    "footer" => $footer));
            echo($productTemplate);
          }
        }  
}

