<?php 

require_once("./lib/global.php");
require_once("./lib/DBController.php");
require_once("./lib/templateController.php");
require_once("./header.php");
require_once("./footer.php");

$latestItems = getLatestItems();
$latestSection = file_get_contents("./templates/section.html");
$latestSection = str_replace('{{listaProdotti}}',$latestItems,$latestSection);

$nextItems = getNextItems();
$nextSection = file_get_contents("./templates/section.html");
$nextSection = str_replace('{{listaProdotti}}',$nextItems,$nextSection);

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

$homePageTemplate = new Template();
$homePageTemplate = $homePageTemplate->render("index.html",array("header" => $header,
                                                                 "state" => $state,
                                                                 "latestItems" => $latestSection,
                                                                 "nextItems" => $nextSection,
                                                                 "saleItems" => $saleSection,
                                                                 "footer" => $footer));

echo($homePageTemplate);

function getLatestItems() : string {
    //implementazione;
    $connection =new DBconnection();
    $connection -> setConnection();
    $latestItems = '';
    $query = "SELECT *
              from Products
              where release_date < CURDATE()
                    and sale_percentage = 0
              order by release_date DESC
              limit 3 ";
    $rows = $connection->queryDB($query);
    if (!empty($rows)) {
    foreach ($rows as $row) {
    $latestItemTemplate = new Template();
    $latestItemTemplate = $latestItemTemplate->render("card.html",$row);
    $latestItems .= $latestItemTemplate;
    }
}   else {
        $latestItems = "il DB è vuoto";
    }
    
    return $latestItems;
    
}

function getNextItems() : string {
    //implementazione 
    $connection =new DBconnection();
    $connection -> setConnection();
    $nextItems = '';
    $query = "SELECT *
              from Products
              where release_date > CURDATE()
                    and sale_percentage = 0
              order by release_date ASC
              limit 3 ";
    $rows = $connection->queryDB($query);
    if (!empty($rows)) {
        // ciclo dei record restituiti dalla query
        foreach ($rows as $row) {
            $nextItemTemplate = new Template();
            $nextItemTemplate = $nextItemTemplate->render("card.html",$row);
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
    $connection =new DBconnection();
    $connection -> setConnection();
    $query = "SELECT *
              from Products
              where sale_percentage != 0
              order by sale_percentage DESC
              limit 3 ";
    $rows = $connection->queryDB($query);
    if (!empty($rows)) {
        // ciclo dei record restituiti dalla query
        foreach ($rows as $row) {
            $saleItemTemplate = new Template();
            $saleItemTemplate = $saleItemTemplate->render("card.html",$row);
            $saleItems .= $saleItemTemplate;
        }
     } else {
        $saleItems = "il DB è vuoto";
    }
    return $saleItems;
};

?>