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
        $extra_filters = '<fieldset>
                            <legend>Consolle:</legend>
                            <label><input type="checkbox" name="platform[]" value="Playstation"> Playstation</label><br>
                            <label><input type="checkbox" name="platform[]" value="Nintendo"> Nintendo</label><br>
                            <label><input type="checkbox" name="platform[]" value="Pc"> PC</label><br>
                            <label><input type="checkbox" name="platform[]" value="Xbox"> Xbox</label><br>
                          </fieldset>';
        break;
    case "book":
        $genre_table = "Books";
        $products = "Libri";
        break;
    case "music":
        $genre_table = "Music";
        $products = "Musica";
        $extra_filters = '<fieldset>
                            <legend>Formato:</legend>
                            <label><input type="radio" name="format" value="cd"> CD</label><br>
                            <label><input type="radio" name="format" value="other"> Formato misterioso</label><br>
                            <label><input type="radio" name="format" value="vinyl"> Vinile</label><br>
                          </fieldset>';
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
echo($sql);
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
// Verifica se ci sono prodotti che corrispondono ai filtri
if ($result->num_rows > 0) {
    $products_list .= '<ul class="products_list">';
    // Mostra i prodotti filtrati
    foreach ($result as $row) {
        $product_template = new Template();
        $product_template = $product_template->render("card.html",$row);
        $products_list .= $product_template;
        }
    $products_list .= '</ul>';
} else {
     $products_list .= "Nessun prodotto corrispondente filtri selezionati";
}

//Query per recuperare i generi della particolare tipologia di prodotto
$connection -> setConnection();
$query = "SELECT DISTINCT genre from $genre_table";
$result = $connection -> queryDB($query);
$genre_list = '';
// Verifica se ci sono prodotti che corrispondono ai filtri
if (!empty($result)) {
    // Mostra i prodotti filtrati
    foreach ($result as $row) {
            $genre_list .= '<label><input type="radio" name="genre" value="' . $row['genre'] . '">' . $row['genre'] . "</label><br>";
        }
}   

$products_page_template = new Template();
$products_page_template = $products_page_template->render("products_page.html",array("header" => $header,
                                                                                     "category" => $_GET['category'],
                                                                                     "products" => $products,
                                                                                     "genre_list" => $genre_list,
                                                                                     "extra_filters" => $extra_filters,
                                                                                     "products_list" => $products_list,
                                                                                     "footer" => $footer));
echo($products_page_template);

$stmt->close();
?>