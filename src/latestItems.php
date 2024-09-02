<?php 

require_once("./lib/global.php");
require_once("./lib/DBController.php");
require_once("./lib/templateController.php");
require_once("./pagination_links_factory.php");
require_once("header.php");
require_once("footer.php");

$header = buildHeader();
$footer = buildFooter();

$products_per_page = 10; // Numero di prodotti per pagina

// Ottieni la pagina corrente dal parametro GET, o usa la pagina 1 come predefinita
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

// Calcola l'offset (da dove iniziare a prendere i prodotti)
$offset = ($page - 1) * $products_per_page;

$latestItems = '';
$connection =new DBconnection();
$connection -> setConnection();
$query = "SELECT *
          from Products
          where release_date <= CURDATE()
            and release_date >= CURDATE() - INTERVAL 30 DAY 
          order by release_date DESC
          limit {$products_per_page}
          offset {$offset} ";
$rows = $connection->queryDB($query);
if (!empty($rows)) {
    // ciclo dei record restituiti dalla query
    foreach ($rows as $row) {
        $latestItemTemplate = new Template();
        $latestItemTemplate = $latestItemTemplate->render("card.html",$row);
        $latestItems .= $latestItemTemplate;
    }
 } else {
    $latestItems = "il DB è vuoto";
}

$total_products_sql = "SELECT COUNT(*) as total_products 
                       FROM Products 
                       WHERE release_date <= CURDATE() and release_date >= CURDATE() - INTERVAL 30 DAY ";
$connection -> setConnection();
$total_products_result = $connection->queryDB($total_products_sql);
$totale_products = $total_products_result[0]['total_products'];

// Creazione dei link di paginazione
$pagination_links = get_pagination_links($page , $totale_products);

$latest_item_template = new Template();
$latest_item_template = $latest_item_template->render("latestItems.html",array("header" => $header,
                                                                               "latest_items_list" => $latestItems,
                                                                               "pagination_links" => $pagination_links,
                                                                               "footer" => $footer));

echo($latest_item_template);

?>