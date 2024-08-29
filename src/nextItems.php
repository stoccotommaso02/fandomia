<?php 

require_once("./lib/global.php");
require_once("./lib/DBController.php");
require_once("./lib/templateController.php");
require_once("header.php");
require_once("footer.php");

$header = buildHeader();
$footer = buildFooter();

$products_per_page = 10; // Numero di prodotti per pagina

// Ottieni la pagina corrente dal parametro GET, o usa la pagina 1 come predefinita
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

// Calcola l'offset (da dove iniziare a prendere i prodotti)
$offset = ($page - 1) * $products_per_page;

$nextItems = '';
$connection =new DBconnection();
$connection -> setConnection();
$query = "SELECT *
          from Products
          where release_date > CURDATE()
          order by release_date ASC
          limit {$products_per_page}
          offset {$offset} ";
$rows = $connection->queryDB($query);
if (!empty($rows)) {
    // ciclo dei record restituiti dalla query
    foreach ($rows as $row) {
        $nextItemTemplate = new Template();
        $nextItemTemplate = $nextItemTemplate->render("card.html",$row);
        $nextItems .= $nextItemTemplate;
    }
 } else {
    $nextItems = "il DB è vuoto";
}

$total_products_sql = "SELECT COUNT(*) as total_products FROM Products where release_date > CURDATE()";
$connection -> setConnection();
$total_products_result = $connection->queryDB($total_products_sql);
$total_pages = $total_products_result[0]['total_products'] / $products_per_page;
$total_pages = ceil($total_pages);

// Visualizza i link di paginazione
$pagination_links =  "<div class='pagination'>";
for ($i = 1; $i <= $total_pages; $i++) {
    if ($i == $page) {
        $pagination_links .= "<strong>$i</strong> "; // Pagina corrente senza link
    } else {
        $pagination_links .= "<a href='nextItems.php?page=$i'>$i</a> "; // Altre pagine con link
    }
}

$next_items_template = new Template();
$next_items_template = $next_items_template->render("nextItems.html",array("header" => $header,
                                                                           "next_items_list" => $nextItems,
                                                                           "pagination_links" => $pagination_links,
                                                                           "footer" => $footer));

echo($next_items_template);

