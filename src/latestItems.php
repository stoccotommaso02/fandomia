<?php 

require_once("./lib/global.php");
require_once("./lib/DBController.php");
require_once("./lib/templateController.php");
require_once("./pagination_links_factory.php");
require_once("header.php");
require_once("footer.php");

$header = buildHeader();
$footer = buildFooter();

$products_per_page = 12; 

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

$offset = ($page - 1) * $products_per_page;

$latestItems = '<ul class="products_list">';
$connection =new DBconnection();
$connection -> setConnection();
$query = "SELECT *
          from Products
          where release_date <= CURDATE()
          order by release_date DESC
          limit {$products_per_page}
          offset {$offset} ";
$rows = $connection->queryDB($query);
if (!empty($rows)) {
    foreach ($rows as $row) {
        $row['check_unavailable'] = $row['status'] == 'Non disponibile'? "disabled" : '';
        $latestItemTemplate = new Template();
        $row['sale_info'] = '';
        $row['release_date_formatted'] = date("d/m/Y", strtotime($row['release_date']));
        $latestItemTemplate = $latestItemTemplate->render("card.html",$row);
        $latestItems .= $latestItemTemplate;
    }
    $latestItems .= '</ul>';
 } else {
    $latestItems = "Nessun articolo è presente in questa sezione.";
}

$total_products_sql = "SELECT COUNT(*) as total_products 
                       FROM Products 
                       WHERE release_date <= CURDATE() and release_date >= CURDATE() - INTERVAL 30 DAY ";
$connection -> setConnection();
$total_products_result = $connection->queryDB($total_products_sql);
$totale_products = $total_products_result[0]['total_products'];

$pagination_links = get_pagination_links($page , $totale_products, $products_per_page);

$latest_item_template = new Template();
$latest_item_template = $latest_item_template->render("latestItems.html",array("header" => $header,
                                                                               "latest_items_list" => $latestItems,
                                                                               "pagination_links" => $pagination_links,
                                                                               "footer" => $footer));

echo($latest_item_template);

