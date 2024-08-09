<?php

require_once("buildHeader.php");

$headerTemplate = buildHeader();

$areaPersonaleTemplate = file_get_contents("./templates/areaPersonale.html");
$areaPersonaleTemplate = str_replace('{{header}}',$headerTemplate,$areaPersonaleTemplate);

echo($areaPersonaleTemplate);
?>