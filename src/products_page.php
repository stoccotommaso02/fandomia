<?php

require_once("./lib/global.php");
require_once("./lib/DBController.php");
require_once("./lib/templateController.php");
require_once("header.php");
require_once("footer.php");

$header = buildHeader();
$footer = buildFooter();

$genre_table = '';
$extra_filters = '';
$products = '';
$category = $_GET['category'];
switch($category) {
    case "comic":
        $genre_table = "Comics";
        $products = "Fumetti";
        break;
    case "videogame":
        $genre_table = $products = "Videogames";
        break;
    case "book":
        $genre_table = "Books";
        $products = "Libri";
        break;
    case "music":
        $genre_table = "Music";
        $products = "Musica";
        break;
}
$sql = "SELECT * FROM Products join $genre_table on Products.id = {$genre_table}.id ";

// Array per contenere i valori dei parametri da bindare
$params = [];
$types = ""; // Stringa per i tipi di dato (es. "ssi" per stringa, stringa, intero)

if (isset($_GET['category'])) {
    $sql .= "WHERE product_type = ?";
    $types .= "s"; // Tipo stringa per categoria
    $params[] = $_GET['category'];
    }  else {
        header("Location:index.php");
        exit();
    }
/* si possono selezionare al momento più prezzi*/
if(!empty($_GET['price'])){

    $prices = $_GET['price'];
    $prices_conditions = array();

    foreach($prices as $price_filter) {
        list($min, $max) = explode('-', $price_filter);
        $prices_conditions[] = "price BETWEEN ? and ?";
        $types .= "ii"; 
        $params[] = $min;
        $params[] = $max;
    }
    if (!empty($prices_conditions)) {
        $sql .= " AND (" . implode(" OR ", $prices_conditions) . ")";
    }
}
/* lo sconto al momento dovrebbe essere un radiobox*/
if (isset($_GET['sale_percentage'])) {
    list($min, $max) = explode('-', $_GET['sale_percentage']);
    $sql .= " AND (sale_percentage BETWEEN ? AND ?)";
    $types .= "ii"; 
    $params[] = $min;
    $params[] = $max;
}
/* Il genre deve essere un radiobox */
if(isset($_GET['genre'])) {

    $genre_checked = $_GET['genre'];
    $types .= "s"; // Tipo intero per prezzo minimo e massimo
    $params[] = $genre_checked;
    $sql .= " AND genre = ?";
}

// Prepara la query
$connection = new DBconnection();
$connection -> setConnection();

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$stmt = $connection->prepare($sql);
// Bind dei parametri se esistono
if (!empty($params)) {
    $stmt->bind_param($types,...$params);
}
// Esegui la query
$stmt->execute();
$result = $stmt->get_result();
$products_list = '';

$products_per_page = 10; // Numero di prodotti per pagina

// Ottieni la pagina corrente dal parametro GET, o usa la pagina 1 come predefinita
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

// Calcola l'offset (da dove iniziare a prendere i prodotti)
$offset = ($page - 1) * $products_per_page;

// Verifica se ci sono prodotti che corrispondono ai filtri
if (!empty($result)) {
    $products_list .= '<ul class="products_list">';
    // Mostra i prodotti filtrati
    foreach ($result as $row) {
        $product_template = new Template();
        $product_template = $product_template->render("card.html",$row);
        $products_list .= $product_template;
        }
    $products_list .= '</ul>';
} else {
     //Da inserire un possibile errore 404;
     $products_list .= "Nessun prodotto corrispondente filtri selezionati";
}

$total_products_result = $result -> num_rows;
$total_pages = $total_products_result / $products_per_page;
$total_pages = ceil($total_pages);

// Visualizza i link di paginazione
$pagination_links =  "<div class='pagination'>";
for ($i = 1; $i <= $total_pages; $i++) {
    if ($i == $page) {
        $pagination_links .= "<strong>$i</strong> "; // Pagina corrente senza link
    } else {
        $pagination_links .= "<a href='products_page.php?page=$i&category=$category'>$i</a> "; // Altre pagine con link
    }
}

if ($page < $total_pages) {
    $next = "<a href='products_page.php?page=" . ($page + 1) . "&category=$category'" . ">Next</a>";
} else {
    $next = "<span>Next</span>"; // Disabled state
}
$pagination_links .= $next;
$pagination_links .=  "</div>";

$products_page_template = new Template();
$products_page_template = $products_page_template->render("products_page.html",array("header" => $header,
                                                                                     "category" => $_GET['category'],
                                                                                     "products" => $products,
                                                                                     "products_list" => $products_list,
                                                                                     "footer" => $footer));
echo($products_page_template);
?>