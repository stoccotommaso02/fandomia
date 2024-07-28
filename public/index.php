<?php 

//Servono :
//-una funzione/classe per compilare il template della card di ogni prodotto;
//-una funzione/classe per compilare ogni section presente in homePage;
//-una classe che compila l'header;
//-una classe che compila il footer;
//-una classe per dis/connettersi al DB;

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
}

$saleSection = file_get_contents("../templates/section.html");
$saleSection = str_replace('{{listaProdotti}}',$listaLibri,$saleSection);

$homePageTemplate = file_get_contents("../templates/index.html");
$homePageTemplate = str_replace('{{saleItems}}',$saleSection,$homePageTemplate);

echo($homePageTemplate);
//echo($indexTemplate);

?>