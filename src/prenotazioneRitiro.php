<?php 

require_once("./lib/global.php");
require_once("./lib/templateController.php");
require_once("./lib/DbController.php");
require_once("header.php");
require_once("footer.php");

$errorMessage = '';
if (!isset($_SESSION['loggedUser'])) {
    $errorMessage = "Devi essere loggato per effettuare una prenotazione";
    $_SESSION['errors'] = $errorMessage;
    header("Location: ../login.php?redirect_url=" . urlencode($_GET['product_id']));
    exit();
}
if (!isset($_GET['product_id']) || $_GET['product_id'] == null) {
    header("Location:index.php");
    exit();
}

$productId = sanitizeString($_GET['product_id']);
$product_typename = $product_name = $product_type = "";
$connection =new DBconnection();
$connection -> setConnection();
try{
    $productQuery = "SELECT * FROM Products WHERE id = $productId ";
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        $results = $connection -> queryDB($productQuery);
        }  catch (Exception $e) {
            echo("Database problem : " . $e->getMessage());
            exit();
        }
        
    if (count($results) == 1) {
        // ciclo dei record restituiti dalla query
        foreach ($results as $row) {
            $product_name = $row["name"];
            $product_type = $row["product_type"];
            $reservedProduct = new Template();
            $reservedProduct = $reservedProduct->render("reservedProduct.html",$row);
        }
     } else {
        header("Location: 404.php");
        exit();
    }


if (isset($_SESSION['errors']) && $_SESSION['errors'] != null ) {
    $errorMessage = '<p style="color:red;">' . htmlspecialchars($_SESSION['errors']) . '</p>';
    unset($_SESSION['errors']);
}

switch ($product_type)  {
    case "book":
        $product_typename = "Libri";
        break;
    case "comic":
        $product_typename = "Fumetti";
        break;
    case "videogame":
        $product_typename = "Videogiochi";
        break;
    case "music":
        $product_typename = "Musica";
        break;
}

$header = buildHeader();
$footer = buildFooter();

$minDate = date('Y-m-d', strtotime('+1 day'));

$reservationTemplate = new Template();
$reservationTemplate =  $reservationTemplate->render("reservationForm.html",array('header' => $header,
                                                                                  'product_id' => $productId,
                                                                                  'product_type' => $product_type,
                                                                                  'product_name' => $product_name,
                                                                                  'product_typename' => $product_typename,
                                                                                  'reserved_product' => $reservedProduct,
                                                                                  'min_date' => $minDate,
                                                                                  'footer' => $footer,
                                                                                  'errors' => $errorMessage));

echo($reservationTemplate);

