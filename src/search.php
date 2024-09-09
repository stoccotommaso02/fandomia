<?php 

require_once("./lib/global.php");
require_once("./lib/DBController.php");
require_once("searchList.php");
require_once("./pagination_links_factory.php");
require_once("header.php");
require_once("footer.php");
/* step logici:
    se il param è in POST, allora l'utente ha effettuato una nuova ricerca;
    se invece c'è già un array di risultati, è già stata fatta una ricerca dall'utente, 
    ed egli vuole solo navigare tra le pagine dei risultati;*/
$searchParam = '';
$prodotti = array();

if (isset($_POST['search']) ) {

    $searchParam = sanitizeString($_POST['search']);

    $prodotti = searchList($searchParam);

    if(isset($_SESSION['search_result']))  {
        unset($_SESSION['search_result']);
    }

    $_SESSION['search_result'] = $prodotti;

}
else    if(isset($_SESSION['search_result']))   {
    $prodotti = $_SESSION['search_result'];
}
/* Valori di default presenti nella pagina, cioè nel caso
in cui la ricerca non abbia prodotto nessun risultato */
$products_list = "<p>Spiacente, la tua ricerca non ha prodotto nessun risultato</p>";
$pagination_links = '';

if (!empty($prodotti))  {
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

    $prodotti_per_pagina = 12;
    
    $offset = ($page - 1) * $prodotti_per_pagina;
    $prodotti_pagina = array_slice($prodotti, $offset, $prodotti_per_pagina);
    
    $products_list = "<ul class='products_list'>";
    foreach ($prodotti_pagina as $prodotto) {

        $product_template = new Template();
        $product_template = $product_template->render("card.html",$prodotto);

        $products_list .= $product_template;
    }
    $products_list .= "</ul>";
    
    $total_products = count($prodotti);
    
    $pagination_links = get_pagination_links($page,$total_products);
}   

$header = buildHeader();
$footer = buildFooter();

$searchTemplate = new Template();
$searchTemplate = $searchTemplate -> render('searchResult.html',array("query" => $searchParam,
                                                                      "header" => $header,
                                                                      "footer" => $footer,
                                                                      "query" => $searchParam,
                                                                      "searchList" => $products_list,
                                                                      "pagination_links" => $pagination_links));
                 
echo ($searchTemplate);

?>
