<?php 

require_once("./lib/global.php");
require_once("./lib/DBController.php");
require_once("header.php");
require_once("footer.php");

$header = buildHeader();
$footer = buildFooter();

if (!isset($_POST['product_id']) || $_POST['product_id'] == null ) {
    header("Location: 404.php");
    exit();
} else {
    $product_id = sanitizeString($_POST['product_id']); 
    $product_type = sanitizeString($_POST['product_type']);

    $productTable = "";

    $connection = new DBconnection();
    $connection -> setConnection();

    switch ($product_type)  {
        case "book":
            $productTable = "Books";
            $product_type = "Libri";
            break;
        case "comic":
            $productTable = "Comics";
            $product_type = "Fumetti";
            break;
        case "videogame":
            $productTable = "Videogames";
            $product_type = "Videogame";
            break;
        case "music":
            $productTable = "Music";
            $product_type = "Musica";
            break;
    }
    
    try {
        $productQuery = "SELECT *
        FROM Products join $productTable on Products.id  = $productTable.id
        WHERE Products.id = $product_id";

        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        $results = $connection -> queryDB($productQuery);
        }  catch (Exception $e) {
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
    $index++;
    // Se l'indice è maggiore o uguale a 7, esegui le operazioni
    if ($index >= 8) {
        // Esegui le operazioni che desideri su chiave e valore
        $extra_infos .= "<dt>$key:</dt> <dd>$value</dd>";
    }
}
            $productTemplate = $productTemplate -> render("product_page.html",array("header" => $header,
                                                                                    "id" => $record['id'],
                                                                                    "name" => $record['name'],
                                                                                    "product_type" => $product_type,
                                                                                    "genre" => $record['genre'],
                                                                                    "extra_infos" => $extra_infos,
                                                                                    "status" => $record['status'],
                                                                                    "release_date" => $record['release_date'],
                                                                                    "price" => $record['price'],
                                                                                    "footer" => $footer));
            echo($productTemplate);
          }
        }  
}

?>