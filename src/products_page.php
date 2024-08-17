<?php

require_once("./lib/global.php");
require_once("./lib/DBController.php");
require_once("./lib/templateController.php");
require_once("header.php");
require_once("footer.php");

$header = buildHeader();
$footer = buildFooter();
// Query base
$sql = "SELECT * FROM Products ";

// Array per contenere i valori dei parametri da bindare
$params = [];
$types = ""; // Stringa per i tipi di dato (es. "ssi" per stringa, stringa, intero)

// Filtro per categoria (es. electronics, books, clothing)
if (isset($_GET['category'])) {
    $sql .= "WHERE product_type = ?";
    $types .= "s"; // Tipo stringa per categoria
    $params[] = $_GET['category'];
    }  


// Filtro per prezzo
if (isset($_GET['price']) && !empty($_GET['price'])) {
    $price_conditions = [];
    foreach ($_GET['price'] as $price_filter) {
        if ($price_filter == 'under-50') {
            $sql .= " AND price < ?";
            $types .= "i"; // Tipo intero per prezzo
            $params[] = 50;
        } elseif ($price_filter == '50-100') {
            $sql .= " AND (price >= ? AND price <= ?)";
            $types .= "ii"; // Tipo intero per prezzo minimo e massimo
            $params[] = 50;
            $params[] = 100;
        } elseif ($price_filter == 'over-100') {
            $sql .= " AND price > ?";
            $types .= "i";
            $params[] = 100;
        }
    }
}

$extra_filters = '';
$genre_table = '';
$category = $_GET['category'];
switch($category) {
    case "comic":
        $genre_table = "Comics";
        break;
    case "videogame":
        $genre_table = "Videogames";
        $extra_filters = '<fieldset>
                            <legend>Consolle:</legend>
                            <label><input type="checkbox" name="platform" value="Playstation"> Playstation</label><br>
                            <label><input type="checkbox" name="platform" value="Nintento"> Nintendp</label><br>
                            <label><input type="checkbox" name="platform" value="PC"> PC</label><br>
                            <label><input type="checkbox" name="platform" value="Xbox"> Xbox</label><br>
                          </fieldset>';
        break;
    case "book":
        $genre_table = "Books";
        break;
    case "music":
        $genre_table = "Music";
        $extra_filters = '<fieldset>
                            <legend>Formato:</legend>
                            <label><input type="checkbox" name="format" value="cd"> CD</label><br>
                            <label><input type="checkbox" name="format" value="other"> Formato misterioso</label><br>
                            <label><input type="checkbox" name="format" value="vinyl"> Vinile</label><br>
                          </fieldset>';
        break;
}

// Prepara la query
$connection = new DBconnection();
$connection -> setConnection();
echo($sql);
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$stmt = $connection->prepare($sql);
// Bind dei parametri se esistono
if (!empty($params)) {
    $stmt->bind_param($types,$params[0]);
}

// Esegui la query
$stmt->execute();
$result = $stmt->get_result();
$products_list = '';
// Verifica se ci sono prodotti che corrispondono ai filtri
if ($result->num_rows > 0) {
    $products_list .= '<ul>';
    // Mostra i prodotti filtrati
    foreach ($result as $row) {
        $product_template = new Template();
        $product_template = $product_template->render("card.html",$row);
        $products_list .= $product_template;
        }
    $products_list .= '</ul>';
} else {
     $products_list .= "Nessun prodotto trovato per i filtri selezionati";
}

$connection -> setConnection();
$query = "SELECT DISTINCT genre from $genre_table";
$result = $connection -> queryDB($query);
$genre_list = '';
// Verifica se ci sono prodotti che corrispondono ai filtri
if (!empty($result)) {
    // Mostra i prodotti filtrati
    foreach ($result as $row) {
            $genre_list .= '<label><input type="checkbox" name="genre" value="' . $row['genre'] . '">' . $row['genre'] . "</label><br>";
        }
}   

$products_page_template = new Template();
$products_page_template = $products_page_template->render("products_page.html",array("header" => $header,
                                                                                     "category" => $_GET['category'],
                                                                                     "genre_list" => $genre_list,
                                                                                     "extra_filters" => $extra_filters,
                                                                                     "products_list" => $products_list,
                                                                                     "footer" => $footer));

echo($products_page_template);

$stmt->close();
?>
