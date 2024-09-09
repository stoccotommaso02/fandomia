<?php

require_once("./lib/templateController.php");
require_once("./header.php");
require_once("./footer.php");

http_response_code(404);

$pageTemplate = "404.html";
$header = buildHeader();
$footer = buildFooter();

$template404 = new Template();
$template404 = $template404->render($pageTemplate, array("header" => $header,
                                            "footer" => $footer));



echo($template404);

?>