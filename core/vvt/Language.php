<?php
declare(strict_types = 1);

namespace vvt;

class Language
{
    public static array $data = [];
    public static array $view = [];
    public static array $layout = [];

    public static function load(string $lang, array $route)
    {
        $viewFile = APP . "/languages/{$lang}/{$route['controller']}/{$route['action']}.php";
        $layout =  APP . "/languages/{$lang}.php";

        if(file_exists($viewFile)){
            self::$view = require_once $viewFile;
        }
        if(file_exists($layout)){
            self::$layout = require_once $layout;
        }
        self::$data = array_merge(self::$view, self::$layout);
    }
    public static function get(string $key)
    {
        return self::$data[$key] ?? null;
    }
}