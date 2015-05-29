<?php
function __autoload($className) {
    $path = explode("_",$className);
    if (count($path) == 1)
         include "classes/". $className . '.php';
    else
    {
        $directory = "";
        for($i = 0; $i < count($path) - 1; $i++){
            $directory .= $path[$i] . "/";
        }
       // var_dump($directory);
        include "classes/" . $directory . $className . ".php";
    }
}
?>