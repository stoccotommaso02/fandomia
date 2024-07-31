<?php 

require_once("buildHeader.php");
//Servono :
//-una funzione/classe per compilare il template della card di ogni prodotto;
//-una funzione/classe per compilare ogni section presente in homePage;
//-una classe che compila l'header;
//-una classe che compila il footer;
//-una classe per dis/connettersi al DB;
$latestItems = getLatestItems();
$latestSection = file_get_contents("../templates/section.html");
$latestSection = str_replace('{{listaProdotti}}',$latestItems,$latestSection);

$nextItems = getNextItems();
$nextSection = file_get_contents("../templates/section.html");
$nextSection = str_replace('{{nextItems}}',$nextItems,$nextSection);

$saleItems = getSaleItems();
$saleSection = file_get_contents("../templates/section.html");
$saleSection = str_replace('{{listaProdotti}}',$saleItems,$saleSection);

$header = buildHeader();

$homePageTemplate = file_get_contents("../templates/index.html");
$homePageTemplate = str_replace('{{header}}',$header,$homePageTemplate);
$homePageTemplate = str_replace('{{latestItems}}',$latestSection,$homePageTemplate);
$homePageTemplate = str_replace('{{nextItems}}',$nextItems,$homePageTemplate);
$homePageTemplate = str_replace('{{saleItems}}',$saleSection,$homePageTemplate);

echo($homePageTemplate);

function getLatestItems() : string {
    //implementazione;
    $latestItems = '';
    return $latestItems;
}

function getNextItems() : string {
    //implementazione 
    $nextItems = '';
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