<?php

require_once("header.php");
require_once("footer.php");

$headerTemplate = buildHeader();
$footerTemplate = buildFooter();

$areaPersonaleTemplate = file_get_contents("./templates/areaPersonale.html");
$areaPersonaleTemplate = str_replace('{{header}}',$headerTemplate,$areaPersonaleTemplate);
$areaPersonaleTemplate = str_replace('{{footer}}',$footerTemplate,$areaPersonaleTemplate);

echo($areaPersonaleTemplate);
?>