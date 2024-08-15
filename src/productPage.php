<?php 

require_once("./lib/global.php");
require_once("./header.php");
require_once("./footer.php");

$header = buildHeader();
$footer = buildFooter();

if (!isset($_GET['product_id']) || $_GET['product_id'] == null ) {
    header("Location: index.php");
    exit();
} else {
    $product_id = sanitizeString($_GET['product_id']); 
    $product_type = sanitizeString($_GET['product_type']);

    $productTable = "";

    $connection = getConnection();

    switch ($product_type)  {
        case "book":
            $productTable = "Books";
            break;
        case "comic":
            $productTable = "Comics";
            break;
        case "videogame":
            $productTable = "Videogames";
            break;
        case "music":
            $productTable = "Music";
            break;
    }
    $jsonBooks = file_get_contents("./assets/libri.json");
   $jsonBooks = json_decode($jsonBooks,JSON_OBJECT_AS_ARRAY);
   $booksList = '';
   foreach ($jsonBooks as $jasonBook) {
        $booksList .= $jasonBook['id'];
    }
    echo($booksList);
    exit();
    try {
        $productQuery = "SELECT *
        FROM Products join $productTable on Products.id  = $productTable.id
        WHERE Products.id = $product_id";

        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        $results = $connection -> query($productQuery);
        }  catch (Exception $e) {
            echo("Database problem : " . $e->getMessage());
            exit();
        }
        if ($results -> num_rows != 0 ) {
          foreach($results as $record)
            $productTemplate = new Template();
            $productTemplate = $productTemplate -> render("product_page.html",array("header" => $header,
                                                                                    "id" => $record['id'],
                                                                                    "name" => $record['name'],
                                                                                    "product_type" => $record['product_type'],
                                                                                    "genre" => $record['genre'],
                                                                                    "status" => $record['status'],
                                                                                    "release_date" => $record['release_date'],
                                                                                    "developer" => $record['developer'],
                                                                                    "price" => $record['price'],
                                                                                    "footer" => $footer));
            echo($productTemplate);
        }
}

?>