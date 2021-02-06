<?php
require("Config/helper.php");
require('Config/Request.php');

$baseUrl = str_replace('index.php','',$_SERVER['SCRIPT_NAME']);
$url = str_replace($baseUrl,'',$_SERVER['REDIRECT_URL']);
$explodeUrl = explode('/',$url);
$model       =  array_shift($explodeUrl);
$controller  =  'Controller\\'.ucfirst($model).'Controller';
$method      =  (!empty($explodeUrl[0]))? array_shift($explodeUrl) : 'index' ;


if (!empty($model)){

    include $controller.".php";
    
    $class  = new $controller();
    $result = call_user_func_array(array($class ,$method), $explodeUrl);
    encode($result);
}else
    pre('Home Page');
