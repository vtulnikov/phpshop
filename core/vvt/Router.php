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
    protected static function removeQueryParams(string $url): string
    {
        if ($url) {
            $params = explode("&", $url, 2);
            if (false == str_contains($params[0], "=")) {
                return rtrim($params[0], "/");
            }
        }
        return "";
    }
    public static function matchRoute(string $url): bool
    {
        foreach (self::$routes as $regexp => $route) {
            if (preg_match("~{$regexp}~", $url, $matches)) {
                //оставляем только строковые ключи. ARRAY_FILTER_USE_KEY - берем ключи, а не значения
                $routeParams = array_filter($matches, fn($k) => is_string($k), ARRAY_FILTER_USE_KEY);
                
                //добавляем action по умолчанию для тех урлов, у которых его не будет site.ru/category
                if (empty($route['action'])) {
                    $route['action'] = 'index';
                }
                /** 
                 * нам нужен admin_prefix (или пустой) для того, чтобы формировать адрес классов Model and View
                 * мы будем его формировать в классе Controller->getModel()
                 */
                $route['admin_prefix'] = (!isset($route['admin_prefix'])) ? "" : $route['admin_prefix'] . "\\";
                
                $routeParams += $route;
                $routeParams['controller'] = self::toUpperCamelCase($routeParams['controller']);
                self::$route = $routeParams;
                
                return true;
            }
        }
        return false;
    }
    public static function dispatch(string $url)
    {
        $url = self::removeQueryParams($url);
        if (!self::matchRoute($url)) {
            throw new Exception("Страница не найдена", 404);
        }
        if(!empty(self::$route['lang'])){
            App::$app->setProperty('lang', self::$route['lang']);
        }
        $controller = "app\\controllers\\"
            . self::$route['admin_prefix']
            . self::$route['controller']
            . "Controller";

        if (!class_exists($controller)) {
            throw new Exception("Контроллер {$controller} не найден", 404);
        }

        $controllerObject = new $controller(self::$route);

        /** @var Controller $controllerObject */ //указываем, что $controllerObject является объектом класса Controller
        $controllerObject->getModel();

        $action = self::toLowerCamelCase(self::$route['action']) . "Action";
        if (!method_exists($controllerObject, $action)) {
            throw new Exception("Метод {$controller}::{$action} не найден", 404);
        }

        $controllerObject->$action();
        $controllerObject->getView();
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
