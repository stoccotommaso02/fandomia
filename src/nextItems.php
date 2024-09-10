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

$nextItems = '<ul class="products_list">';
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
    foreach ($rows as $row) {
        $row['check_unavailable'] = $row['status'] == 'Non disponibile'? "disabled" : '';
        $nextItemTemplate = new Template();
        $row['sale_info'] = '';
        $nextItemTemplate = $nextItemTemplate->render("card.html",$row);
        $nextItems .= $nextItemTemplate;
    }
    $nextItems .= '</ul>';
 } else {
    $nextItems = "Nessun articolo è presente in questa sezione.";
}

$total_products_sql = "SELECT COUNT(*) as total_products FROM Products where release_date > CURDATE()";
$connection -> setConnection();
$total_products_result = $connection->queryDB($total_products_sql);
$total_products = $total_products_result[0]['total_products'];

$pagination_links =  get_pagination_links($page,$total_products, $products_per_page);

$next_items_template = new Template();
$next_items_template = $next_items_template->render("nextItems.html",array("header" => $header,
                                                                           "next_items_list" => $nextItems,
                                                                           "pagination_links" => $pagination_links,
                                                                           "footer" => $footer));

echo($next_items_template);

