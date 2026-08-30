<?php
declare(strict_types = 1);

namespace vvt;

class Language
{
    public static array $data = []; //все переводные фразы страницы
    public static array $layout = []; //переводные фразы шаблона
    public static array $route = []; //переводные фразы вида

    public static function load(string $code, array $route)
    {
        $langLayout =  APP . "/languages/{$code}.php";
        $langView = APP . "/languages/{$code}/{$route['controller']}/{$route['action']}.php";
        
        if(file_exists($langLayout)){
            self::$layout  = require_once $langLayout;
        }
        if(file_exists($langView)){
            self::$route  = require_once $langView;
        }
        self::$data = array_merge(self::$layout, self::$route);
    }
    public static function get(string $key)
    {
        return self::$data[$key] ?? $key;
    }
}