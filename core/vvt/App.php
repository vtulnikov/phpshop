<?php

namespace vvt;

use Exception;

class App
{
    public static Registry $app;

    public function __construct()
    {
        new ErrorHandler();
        self::$app = Registry::getInstance();
        $this->setParams();
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