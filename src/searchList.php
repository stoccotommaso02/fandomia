<?php 

require_once("./lib/global.php");
require_once("JaroWinkler.php");

function searchList(string $searchParam) : string {
    $connection = new DBconnection;
    $connection -> setConnection();
    
    $searchQuery = "SELECT *
                    from Products";
    
    $results = $connection -> queryDB($searchQuery);
    
    $searchResult = '';
    if (empty($results)) {
        $searchResult = "Nessun prodotto corrisponde alla tua ricerca!";
    } else {

        $products = [];

        foreach ($results as $result) {
            $similarity = jaro_winkler($searchParam, $result['name']);
            $products[] = ['id' => $result['id'],
                           'name' => $result['name'],
                           'status' => $result['status'],
                           'price' => $result['price'],
                           'release_date' => $result['release_date'],
                           'product_type' => $result['product_type'],
                           'similarity' => $similarity];
            /*Un punteggio di similarità uguale a 1 , equivale ad aver trovato
              una perfetta corrispondenza, e quindi fermo il ciclo*/
            if ($similarity == 1)   {
                $searchResult .= "<ul>";
                
                $searchItemTemplate = new Template();
                $searchItemTemplate = $searchItemTemplate->render("card.html",end($products));
                $searchResult .= $searchItemTemplate;
                
                $searchResult .= "</ul>";
                return $searchResult;
                        }
        }

        // Ordina i risultati in base alla somiglianza (decrescente)
        usort($products, function($a, $b) {
            if($a['similarity'] < $b['similarity']) {
                return 1;
            }
            elseif($a['similarity'] > $b['similarity']) {
                return -1;
            }
            else {
                return 0;
            }
        });

        $searchResult .= "<ul>";
        $count = 0;

        foreach ($products as $product) {
        if ( $count >= 10) {
            break;
        }
        $searchItemTemplate = new Template();
        $searchItemTemplate = $searchItemTemplate->render("card.html",$product);
        $searchResult .= $searchItemTemplate;
        $count ++;
        }
        $searchResult .= "</ul>";
    }
    return $searchResult;
}

?>