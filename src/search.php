<?php 

require_once("./lib/global.php");
require_once("./lib/DBController.php");
require_once("header.php");
require_once("footer.php");

$searchParam = '';
if (isset($_GET['search'])) {
    $searchParam = $_GET['search'];
    unset($_GET['search']);
}

$header = buildHeader();
$footer = buildFooter();

$searchResult = searchList($searchParam);

$searchTemplate = new Template();
$searchTemplate = $searchTemplate -> render('searchResult.html',array("header" => $header,
                                                                      "footer" => $footer,
                                                                      "searchList" => $searchResult));
                 
echo ($searchTemplate);

function searchList(string $searchParam) : string {
    $connection = new DBconnection;
    $connection -> setConnection();
    
    $searchQuery = "SELECT *
                    from Products
                    where name = '$searchParam'";
    
    $results = $connection -> queryDB($searchQuery);
    
    $searchResult = '';
    if (empty($results)) {
        $searchResult = "Nessun prodotto corrisponde alla tua ricerca!";
    } else {
    foreach($results as $result) {
        $searchResult .= $result['name'];
        }
    }
    return $searchResult;
}
?>