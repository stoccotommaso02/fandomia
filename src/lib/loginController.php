<?php

require_once("./global.php");

if (isset($_POST['userEmail']))
 {
 $user = sanitizeString($_POST['userEmail']);
 $pass = sanitizeString($_POST['password']);
 if ($user == "" || $pass == "")
 $error = "Not all fields were entered<br>";
 else
 {
 $result = queryMySQL("SELECT username,password FROM Users
 WHERE username='$user' AND password='$pass'");
 if ($result->num_rows == 0)
 {
 $error = "<span class='error'>Username/Password
 non validi</span><br><br>";
 $loginTemplate = file_get_contents('../templates/login.html');
 $loginTemplate = str_replace('{{errors}}',$error,$loginTemplate);
 header("Location: ../login.php");
 }
 else
 {
    session_start();
 $_SESSION['loggedUser'] = $user;
 header("Location: ../index.php");
 }
 }
 }

 function sanitizeString(string $var) : string
 {
 $var = strip_tags($var);
 $var = htmlentities($var);
 $var = stripslashes($var);
 return $var;
 }

 function queryMySql(string $query) {
    $connection = getConnection();
    $result = $connection->query($query);
    return $result;
 }

?>