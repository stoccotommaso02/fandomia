<?php 

require_once("./lib/global.php");
require_once("./lib/DBController.php");
require_once("searchList.php");
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

    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

    $prodotti_per_pagina = 10;
    
    $offset = ($page - 1) * $prodotti_per_pagina;
    $prodotti_pagina = array_slice($prodotti, $offset, $prodotti_per_pagina);
    
    $products_list = "<ul>";
    foreach ($prodotti_pagina as $prodotto) {

        $product_template = new Template();
        $product_template = $product_template->render("card.html",$prodotto);

        $products_list .= $product_template;
    }
    $products_list .= "</ul>";
    
    $total_prodotti = count($prodotti);
    $total_pages = ceil($total_prodotti / $prodotti_per_pagina);
    
    $pagination_links = "<div class='pagination'>";
    $next = $previous = "";
    if ($page > 1) {
        $previous =  "<a href='?page=" . ($page - 1) . "'>Previous</a> ";
    } else {
        $previous = "<span>Previous</span> "; // Disabled state
    }
    $pagination_links .= $previous;
    for ($i = 1; $i <= $total_pages; $i++) {
        if ($i == $page) {
            $pagination_links .= "<strong>$i</strong> "; // Pagina corrente senza link
        }   else {
            $pagination_links .= "<a href='?page=" . $i . "'>" . $i . "</a> ";
        }
    }
        // Bottone "Next"
    if ($page < $total_pages) {
            $next = "<a href='?page=" . ($page + 1) . "'>Next</a>";
        } else {
            $next = "<span>Next</span>"; // Disabled state
        }
        $pagination_links .= $next;
    
    $pagination_links .=  "</div>";

$header = buildHeader();
$footer = buildFooter();

$searchTemplate = new Template();
$searchTemplate = $searchTemplate -> render('searchResult.html',array("header" => $header,
                                                                      "footer" => $footer,
                                                                      "searchList" => $products_list,
                                                                      "pagination_links" => $pagination_links));
                 
echo ($searchTemplate);

