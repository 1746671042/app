<?php
header("content-type:text/html;charset=utf-8");
//根据类名自动引入类库
function __autoload($class){
    include "./class/{$class}.class.php";
    
}
//调取类和方法
$class = isset($_GET["class"])?$_GET["class"]:"index";
$method = isset($_GET["method"])?$_GET["method"]:"index";

$object  = new $class();
$object->$method();