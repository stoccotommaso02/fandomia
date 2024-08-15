<?php 

require_once("./lib/global.php");
require_once("./lib/DBController.php");
require_once("searchList.php");
require_once("header.php");
require_once("footer.php");

$searchParam = '';
if (isset($_POST['search']) && $_POST['search'] != null ) {
    $searchParam = sanitizeString($_POST['search']);
    unset($_POST['search']);
}

$header = buildHeader();
$footer = buildFooter();

$searchResult = searchList($searchParam);

$searchTemplate = new Template();
$searchTemplate = $searchTemplate -> render('searchResult.html',array("header" => $header,
                                                                      "footer" => $footer,
                                                                      "searchList" => $searchResult));
                 
echo ($searchTemplate);

function sanitizeString(string $input) : string
{
$input = strip_tags($input);
$input = htmlentities($input);
$input = stripslashes($input);
return $input;
}

?>