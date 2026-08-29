<?php
declare(strict_types = 1);

namespace app\controllers;

use vvt\App;

class LanguageController extends AppController
{
    public function changeAction()
    {
        $lang = $_GET['lang'] ?? null;
        if($lang && array_key_exists($lang, App::$app->getProperty('languages'))){
            $url = trim(parse_url($_SERVER['HTTP_REFERER'], PHP_URL_PATH), "/");
            $url_parts = explode("/", $url, 2);
            //если нет такого языка, то переход с базового языка на другой
            if(!array_key_exists($url_parts[0], App::$app->getProperty('languages'))){
                if($url_parts[0] != App::$app->getProperty('language')['code']){
                    $url = $lang . "/" . $url;
                    redirect(PATH. "/" . $url);
                } 
                //если язык существует в списке, но смена происходит на не базовый язык
            } elseif($lang != App::$app->getProperty('language')['code']){
                $url = $lang . "/" . $url_parts[1];
                redirect(PATH. "/" . $url);
            } else{
                $url = $url_parts[1];
                redirect(PATH. "/" . $url);
            }
        } else{
            redirect();
        }
    }
}