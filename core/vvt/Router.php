<?php

namespace vvt;

use Exception;

class Router
{
    protected static array $routes = [];
    protected static array $route = [];

    public static function add(string $regexp, $route = [])
    {
        self::$routes[$regexp] = $route;
    }
    public static function getRoutes(): array
    {
        return self::$routes;
    }
    public static function getRoute(): array
    {
        return self::$route;
    }
    protected static function removeQueryParams(string $url):string
    {
        if($url){
            $params = explode("&", $url, 2);
            debug($params);
            if(false == str_contains($url, "=")){
                return rtrim($params[0], "/");
            }
        }
        return "";
    }
    public static function dispatch(string $url)
    {
        $url = self::removeQueryParams($url);
        if (self::matchRoute($url)) {
            $controller = "app\\controllers\\" . self::$route['admin_prefix'] . self::$route['controller'] . "Controller";
            if (class_exists($controller)) {
                $controllerObject = new $controller(self::$route);
                $action = self::toLowerCamelCase(self::$route['action']) . "Action";
                if (method_exists($controllerObject, $action)) {
                    $controllerObject->$action();
                } else {
                    throw new Exception("Метод {$controller}::{$action} не найден", 404);
                }
            } else {
                throw new Exception("Контроллер {$controller} не найден", 404);
            }
        } else {
            throw new Exception("Страница не найдена", 404);
        }
    }
    public static function matchRoute(string $url): bool
    {
        foreach (self::$routes as $regexp => $route) {
            if (preg_match("~{$regexp}~", $url, $matches)) {
                //оставляем только строковые ключи. ARRAY_FILTER_USE_KEY - берем ключи, а не значения
                $params = array_filter($matches, fn($k) => is_string($k), ARRAY_FILTER_USE_KEY);

                //добавляем action по умолчанию
                if (empty($route['action'])) {
                    $route['action'] = 'index';
                }
                $route['admin_prefix'] = (!isset($route['admin_prefix'])) ? "" : $route['admin_prefix'] . "\\";

                $params += $route;
                $params['controller'] = self::toUpperCamelCase($params['controller']);
                self::$route = $params;
                return true;
            }
        }
        return false;
    }
    protected static function toUpperCamelCase(string $str): string
    {
        // Заменяем дефисы на пробелы, делаем каждое слово с заглавной, убираем пробелы
        return str_replace(' ', '', ucwords(str_replace('-', ' ', $str)));
    }
    protected static function toLowerCamelCase(string $str): string
    {
        return lcfirst(self::toUpperCamelCase($str));
    }
}
