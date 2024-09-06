<?php

require_once("./lib/global.php");
require_once("./lib/templateController.php");
require_once("header.php");
require_once("footer.php");

$header = buildHeader();
$footer = buildFooter();

$areaPersonaleTemplate = new Template();
$areaPersonaleTemplate = $areaPersonaleTemplate -> render("areaPersonale.html",array("header" => $header,
                                                                                     "area_personale" => "Info Account",
                                                                                     "footer" => $footer));

echo($areaPersonaleTemplate);
