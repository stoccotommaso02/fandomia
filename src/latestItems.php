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
$total_pages = $total_products_result[0]['total_products'] / $products_per_page;
$total_pages = ceil($total_pages);

// Visualizza i link di paginazione
$pagination_links =  "<div class='pagination'>";
$next = $previous = "";

    if ($page > 1) {
        $previous = "<a href='latestItems.php?page=" . ($page - 1) . ">Previous</a>";
    } else {
        $previous = "<span>Previous</span> "; // Disabled state
    }
$pagination_links .= $previous;
for ($i = 1; $i <= $total_pages; $i++) {
    if ($i == $page) {
        $pagination_links .= "<strong>$i</strong> "; // Pagina corrente senza link
    } else {
        $pagination_links .= "<a href='latestItems.php?page=$i'>$i</a> "; // Altre pagine con link
    }
}
if ($page < $total_pages) {
    $next = "<a href='latestItems.php?page=" . ($page + 1) . "'>Next</a>";
} else {
    $next = "<span>Next</span>"; // Disabled state
}
$pagination_links .= $next;
$pagination_links .=  "</div>";

$latest_item_template = new Template();
$latest_item_template = $latest_item_template->render("latestItems.html",array("header" => $header,
                                                                               "latest_items_list" => $latestItems,
                                                                               "pagination_links" => $pagination_links,
                                                                               "footer" => $footer));

echo($latest_item_template);

?>