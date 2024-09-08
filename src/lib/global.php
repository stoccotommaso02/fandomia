<?php

require_once("templateController.php");

session_start();

function getConnection(): mysqli{
  $url = "fandomiadb";
  $user = "testuser";
  $password = "testpassword";
  $database = "testdb";
  $connection = new mysqli($url, $user, $password, $database);
  if($connection->connect_error)
    throw new Exception("Connection error ({$connection->connect_errno})");
  return $connection;
}
function renderTemplate($template, $data = []) {
  ob_start();
  extract($data);
  include $template;
  $content = ob_get_contents();
  echo $content;
}

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
