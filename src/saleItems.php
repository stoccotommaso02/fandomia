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

$saleItems = '<ul class="products_list">';
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
    foreach ($rows as $row) {
        $row['check_unavailable'] = $row['status'] == 'Non disponibile'? "disabled" : '';
        $saleItemTemplate = new Template();
        $prezzo_scontato = $row['price'] * (100 - $row['sale_percentage'])/100;
        $prezzo_scontato = round($prezzo_scontato,2);
        $row['sale_info'] = "<dt>Prezzo scontato</dt><dd>{$prezzo_scontato} &euro;</dd>
                             <dt>Sconto</dt><dd>{$row['sale_percentage']}%</dd>";
        $row['release_date_formatted'] = date("d/m/Y", strtotime($row['release_date']));
        $saleItemTemplate = $saleItemTemplate->render("card.html",$row);
        $saleItems .= $saleItemTemplate;
    }
    $saleItems .= '</ul>';
 } else {
    $saleItems = "Nessun articolo è presente in questa sezione.";
}

$total_products_sql = "SELECT COUNT(*) as total_products FROM Products where sale_percentage != 0";
$connection -> setConnection();
$total_products_result = $connection->queryDB($total_products_sql);
$total_products = $total_products_result[0]['total_products'];

$pagination_links = get_pagination_links($page,$total_products, $products_per_page);

$sale_items_template = new Template();
$sale_items_template = $sale_items_template->render("saleItems.html",array("header" => $header,
                                                                           "sale_items_list" => $saleItems,
                                                                           "pagination_links" => $pagination_links,
                                                                           "footer" => $footer));

echo($sale_items_template);

