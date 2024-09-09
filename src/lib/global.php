<?php

require_once("templateController.php");

session_start();

function sanitizeString(string $var) : string
{
$var = strip_tags($var);
$var = htmlentities($var);
$var = stripslashes($var);
return $var;
}

function err500($errno) {
  http_response_code(500);
  header("Location: ./500.php");
  exit();
}

set_error_handler('err500');
set_exception_handler('err500');
