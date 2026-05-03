<?php

namespace vvt;

use Exception;

final class App
{
    public static Registry $app;

    public function __construct()
    {
        $query = trim(urldecode($_SERVER['QUERY_STRING']), "/");
        
        new ErrorHandler();
        self::$app = Registry::getInstance();
        $this->setParams();
        Router::dispatch($query);
    }
    public function setParams(){
        $paramsFile = CONFIG . "/params.php";
        if(!file_exists($paramsFile)){
            throw new Exception("Файл {$paramsFile} не существует");
        }
        $params = require_once($paramsFile);

        if(!empty($params)){
            foreach($params as $key => $value){
                self::$app->setProperty($key, $value);
            }
        }
    }
}