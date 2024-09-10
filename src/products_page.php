<?php

require_once("./lib/global.php");
require_once("./lib/DBController.php");
require_once("./lib/templateController.php");
require_once("./pagination_links_factory.php");
require_once("header.php");
require_once("footer.php");

$header = buildHeader();
$footer = buildFooter();

$genre_table = '';
$extra_filters = '';
$products = '';
$meta_tag_title = '';
$meta_tag_keywords = '';
$meta_tag_description = '';
$category = $_GET['category'];
switch($category) {
    case "Fumetto":
        $genre_table = "Comics";
        $products = "Fumetti";
        $meta_tag_title = 'Fandomia - i nostri fumetti';
        $meta_tag_description = 'Vieni alla scoperta delle ultime novità arrivate a Fandomia! Tanti fumetti in offerta da non lasciarsi scappare!';
        $meta_tag_keywords = 'Fandomia, fumetti, manga, comico, superhero, offerte, alan moore';
        break;
    case "Videogioco":
        $genre_table = "Videogames";
        $products = "Videogiochi";
        $meta_tag_title = 'Fandomia - i nostri videogiochi';
        $meta_tag_description = 'Vieni a scoprire le ultime novità tra i videogiochi di Fandomia, vecchi e nuovi classici da non lasciarsi sfuggire! ';
        $meta_tag_keywords = 'Fandomia, videogiochi, action , adventure , rpg , jrpg';
        break;
    case "Libro":
        $genre_table = "Books";
        $products = "Libri";
        $meta_tag_title = 'Fandomia - i nostri libri';
        $meta_tag_description = 'Scopri e prenota le ultime e le prossime novità più fresh, e le offerte migliori tra i libri di Fandomia';
        $meta_tag_keywords = 'Fandomia,libri,gialli,poesia,narrativa,fantasy,saggistica';
        break;
    case "Musica":
        $genre_table = "Music";
        $products = "Musica";
        $meta_tag_title = 'Fandomia - la nostra musica';
        $meta_tag_keywords = 'Fandomia, musica,vinili, cd, pop, rap, jazz, electronic,classical';
        $meta_tag_description = 'Immergiti fra le tante sonorità musicali disponibili a Fandomia, vecchi e nuovi artisti da ri/scoprire solo per te!';
        break;
}
$products_list = '';

$products_per_page = 12; // Numero di prodotti per pagina

// Ottieni la pagina corrente dal parametro GET, o usa la pagina 1 come predefinita
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

// Calcola l'offset (da dove iniziare a prendere i prodotti)
$offset = ($page - 1) * $products_per_page;

$query = "SELECT * 
        FROM Products join $genre_table on Products.id = {$genre_table}.id
        order by name 
        limit {$products_per_page}
        offset {$offset}  ";

$connection = new DBconnection();
$connection -> setConnection();

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$result = $connection -> queryDB($query);
// Verifica se ci sono prodotti che corrispondono ai filtri
if (!empty($result)) {
    $products_list .= '<ul class="products_list">';
    // Mostra i prodotti filtrati
    foreach ($result as $row) {
        $product_template = new Template();
        $row['check_unavailable'] = $row['status'] == 'Non disponibile'? "disabled" : '';
        $row['sale_info'] = '';
        $product_template = $product_template->render("card.html",$row);
        $products_list .= $product_template;
        }
    $products_list .= '</ul>';
} else {
     header("Location: 404.php");
}
//Per la paginazione, è necessario conoscere il totale di prodotti della particolare categoria
$total_products_query = "SELECT COUNT(*) as total_products
                         FROM Products join $genre_table on Products.id = {$genre_table}.id";
$connection -> setConnection();
$result = $connection -> queryDB($total_products_query);
$total_products;
if (!empty($result)) {
    $total_products = $result[0]['total_products'];
}   else {
    header("Location: 404.php");
}

$pagination_links = get_pagination_links($page , $total_products, $products_per_page, $category);

$products_page_template = new Template();
$products_page_template = $products_page_template->render("products_page.html",array("header" => $header,
                                                                                     "page_title" => $meta_tag_title,
                                                                                     "description" => $meta_tag_description,
                                                                                     "keywords" => $meta_tag_keywords,
                                                                                     "category" => $category,
                                                                                     "products" => $products,
                                                                                     "products_list" => $products_list,
                                                                                     "pagination_links" => $pagination_links,
                                                                                     "footer" => $footer));
echo($products_page_template);