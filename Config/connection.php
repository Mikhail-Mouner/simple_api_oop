<?php

$hostname_website = "localhost";
$database_website = "api_oop";
$username_website = "root";
$password_website = "";
$website = mysqli_connect($hostname_website, $username_website, $password_website) or trigger_error(mysqli_error($website),E_USER_ERROR);

mysqli_query($website , "SET NAMES utf8");
mysqli_query($website , "SET SESSION SQL_BIG_SELECTS=1;");
mysqli_select_db($website, $database_website);

header('Content-Type: application/json');