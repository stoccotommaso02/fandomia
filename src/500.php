<?php 
require_once("./lib/templateController.php");
require_once("./header.php");
require_once("./footer.php");

http_response_code(500);

$pageTemplate = "500.html";
$header = buildHeader();
$footer = buildFooter();

$template500 = new Template();
$template500 = $template500->render($pageTemplate, array("header" => $header,
                                            "footer" => $footer));



echo($template500);