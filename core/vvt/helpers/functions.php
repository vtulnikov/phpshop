<?php

use vvt\App;

function debug($data, $die = false)
{
    echo "<pre>". print_r($data, true) . "</pre>";
    if($die) die;
}
function h(?string $data): string
{
    return htmlspecialchars($data ?? '', ENT_QUOTES);
}
function redirect($url = "")
{
    if($url){
        $redirect = $url;
    } else{
        $redirect = $_SERVER['HTTP_REFERER'] ?? PATH;
    }
    if (!filter_var($redirect, FILTER_VALIDATE_URL)) {
        $redirect = PATH;
    }
    
    header("Location: {$redirect}");
    die;
}
function checkUrlLanguage(string $request_uri)
{
    $path = trim($request_uri, "/");
    $url_parts = explode("/", $path, 2);
    if(!array_key_exists($url_parts[0], App::$app->getProperty('languages'))){
        return "/" . $url_parts[1];
    }
    return $request_uri;
}
function getBaseURl()
{
    return PATH . '/' . (App::$app->getProperty('lang') ? App::$app->getProperty('lang') . '/' : "");
}
/**
 * Получает и приводит параметр из $_GET к нужному типу.
 * @param string $type Допустимые значения: 'i' (int), 'f' (float), 's' (string).
 */
function get(string $key, string $type = 'i')
{
    $value = $_GET[$key] ?? '';

    return match($type){
        'i' => (int) $value,
        'f' => (float) $value,
        's' => (string) $value,
        default => throw new  InvalidArgumentException("Неизвестный тип данных: {$type}")
    };
}
/**
 * Получает и приводит параметр из $_POST к нужному типу.
 * @param string $type Допустимые значения: 'i' (int), 'f' (float), 's' (string).
 */
function post(string $key, string $type = 'i')
{
    $value = $_POST[$key] ?? '';

    return match($type){
        'i' => (int) $value,
        'f' => (float) $value,
        's' => (string) $value,
        default => throw new  InvalidArgumentException("Неизвестный тип данных: {$type}")
    };
}
function getTranslatedPart(string $key):string
{
    return \vvt\Language::get($key);
}
function changeCartIcon(int $id)
{
    if(!empty($_SESSION['cart']) && array_key_exists($id, $_SESSION['cart'])){
        $icon = '<i class="fas fa-cart-arrow-down">';
    } else{
        $icon = '<i class="fas fa-shopping-cart">';
    }
    return $icon;
}