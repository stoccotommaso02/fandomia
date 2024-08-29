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

$saleItems = '<ul>';
$connection =new DBconnection();
$connection -> setConnection();
$query = "SELECT *
          from Products
          where sale_percentage != 0
          order by sale_percentage DESC
          limit {$products_per_page}
          offset {$offset} ";
$rows = $connection->queryDB($query);
if (!empty($rows)) {
    // ciclo dei record restituiti dalla query
    foreach ($rows as $row) {
        $saleItemTemplate = new Template();
        $saleItemTemplate = $saleItemTemplate->render("card.html",$row);
        $saleItems .= $saleItemTemplate;
    }
    $saleItems .= '</ul>';
 } else {
    $saleItems = "il DB è vuoto";
}

$total_products_sql = "SELECT COUNT(*) as total_products FROM Products where sale_percentage != 0";
$connection -> setConnection();
$total_products_result = $connection->queryDB($total_products_sql);
$total_pages = $total_products_result[0]['total_products'] / $products_per_page;
$total_pages = ceil($total_pages);

// Visualizza i link di paginazione
$pagination_links =  "<div class='pagination'>";
for ($i = 1; $i <= $total_pages; $i++) {
    if ($i == $page) {
        $pagination_links .= "<strong>$i</strong></div>"; // Pagina corrente senza link
    } else {
        $pagination_links .= "<a href='saleItems.php?page=$i'>$i</a></div>"; // Altre pagine con link
    }
}

$sale_items_template = new Template();
$sale_items_template = $sale_items_template->render("saleItems.html",array("header" => $header,
                                                                           "sale_items_list" => $saleItems,
                                                                           "pagination_links" => $pagination_links,
                                                                           "footer" => $footer));

echo($sale_items_template);

