<?php 

require_once("./lib/global.php");
require_once("./header.php");
require_once("./footer.php");
//Servono :
//-una funzione/classe per compilare il template della card di ogni prodotto;
//-una funzione/classe per compilare ogni section presente in homePage;
//-una classe che compila l'header;
//-una classe che compila il footer;
//-una classe per dis/connettersi al DB;
$latestItems = getLatestItems();
$latestSection = file_get_contents("./templates/section.html");
$latestSection = str_replace('{{listaProdotti}}',$latestItems,$latestSection);

$nextItems = getNextItems();
$nextSection = file_get_contents("./templates/section.html");
$nextSection = str_replace('{{nextItems}}',$nextItems,$nextSection);

$saleItems = getSaleItems();
$saleSection = file_get_contents("./templates/section.html");
$saleSection = str_replace('{{listaProdotti}}',$saleItems,$saleSection);

$header = buildHeader();
$footer = buildFooter();
$state = '';

if (isset($_SESSION['state'])) {
    global $state;
    $state = "<p>" . $_SESSION['state'] . "</p>";
    unset($_SESSION['state']);
}

$homePageTemplate = file_get_contents("./templates/index.html");
$homePageTemplate = str_replace('{{header}}',$header,$homePageTemplate);
$homePageTemplate = str_replace('{{state}}',$state,$homePageTemplate);
$homePageTemplate = str_replace('{{footer}}',$footer,$homePageTemplate);
$homePageTemplate = str_replace('{{latestItems}}',$latestSection,$homePageTemplate);
$homePageTemplate = str_replace('{{nextItems}}',$nextItems,$homePageTemplate);
$homePageTemplate = str_replace('{{saleItems}}',$saleSection,$homePageTemplate);

echo($homePageTemplate);

function getLatestItems() : string {
    //implementazione;
    $latestItems = '';
    $connection = getConnection();
    $query = "SELECT *
              from Products
              where release_date < CURDATE()
              order by release_date DESC
              limit 3 ";
    $result = $connection->query($query);
    if($result->num_rows > 0) {
        // ciclo dei record restituiti dalla query
        while($row = $result->fetch_array(MYSQLI_ASSOC)){

            $latestItemTemplate=file_get_contents("./templates/card.html");
    
            $latestItemTemplate=str_replace('{{titolo}}',$row['name'],$latestItemTemplate);
            $latestItemTemplate=str_replace('{{prezzo}}',$row['price'],$latestItemTemplate);
            $latestItemTemplate=str_replace('{{disponibilità}}',$row['status'],$latestItemTemplate);
            $latestItemTemplate=str_replace('{{releaseDate}}',$row['release_date'],$latestItemTemplate);
            $latestItemTemplate=str_replace('{{genere}}',$row['product_type'],$latestItemTemplate);
            $latestItemTemplate = str_replace('{{productId}}',$row['id'],$latestItemTemplate);
            $latestItems .= $latestItemTemplate;
        }
     } else {
        $latestItems = "il DB è vuoto";
    }
    return $latestItems;
}

function getNextItems() : string {
    //implementazione 
    $nextItems = '';
    $connection = getConnection();
    $query = "SELECT *
              from Products
              where release_date > CURDATE()
              order by release_date ASC
              limit 3 ";
    $result = $connection->query($query);
    if($result->num_rows > 0) {
        // ciclo dei record restituiti dalla query
        while($row = $result->fetch_array(MYSQLI_ASSOC)){

            $nextItemTemplate=file_get_contents("./templates/card.html");
    
            $nextItemTemplate=str_replace('{{titolo}}',$row['name'],$nextItemTemplate);
            $nextItemTemplate=str_replace('{{prezzo}}',$row['price'],$nextItemTemplate);
            $nextItemTemplate=str_replace('{{disponibilità}}',$row['status'],$nextItemTemplate);
            $nextItemTemplate=str_replace('{{releaseDate}}',$row['release_date'],$nextItemTemplate);
            $nextItemTemplate=str_replace('{{genere}}',$row['product_type'],$nextItemTemplate);
            $nextItemTemplate = str_replace('{{productId}}',$row['id'],$nextItemTemplate);
            $nextItems .= $nextItemTemplate;
        }
     } else {
        $nextItems = "il DB è vuoto";
    }
    return $nextItems;
};

function getSaleItems() : string {
    /* implementazione: per iniziare ho usato un file Json; quando avremo
    il DB questi metodo faranno delle query.
    $jsonFile=file_get_contents("../assets/libri.json");

$jsonEncoded=json_decode($jsonFile,true);

$listaLibri=""; 

foreach($jsonEncoded as $libro) {
    $libroTemplate=file_get_contents("../templates/card.html");
    
    $libroTemplate=str_replace('{{titolo}}',$libro['titolo'],$libroTemplate);
    $libroTemplate=str_replace('{{prezzo}}',$libro['prezzo'],$libroTemplate);
    $libroTemplate=str_replace('{{disponibilità}}',$libro['disponibilità'],$libroTemplate);
    $libroTemplate=str_replace('{{releaseDate}}',$libro['data di uscita'],$libroTemplate);
    $libroTemplate=str_replace('{{genere}}',$libro['genere'],$libroTemplate);
    $libroTemplate = str_replace('{{productId}}',$libro['id'],$libroTemplate);
    $listaLibri .= $libroTemplate;
}  */
    $saleItems = '';
    return $saleItems;
};

?>