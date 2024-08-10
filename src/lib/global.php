<?php

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