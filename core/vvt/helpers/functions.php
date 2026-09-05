<?php

function debug($data, $die = false)
{
    echo "<pre>". print_r($data, true) . "</pre>";
    if($die) die;
}
function h(string $data)
{
    return htmlspecialchars($data ?? "", ENT_QUOTES);
}
function redirect($url = "")
{
    if($url){
        $redirect = $url;
    } else{
        $redirect = $_SERVER['HTTP_REFERER'] ?? PATH;
    }
    if(!filter_var(PATH . $redirect, FILTER_VALIDATE_URL)){
        $redirect = PATH;
    }

    header("Location: {$redirect}", true, 301);
    die;
}
function getBaseUrl():string
{
    return PATH . '/' . (vvt\App::$app->getProperty('lang') ? vvt\App::$app->getProperty('lang') . '/' : '');
}
function checkUrlLanguage(string $request_uri)
{
    $path = trim($request_uri, "/");
    [$lang, $url] = explode("/", $path, 2);
    if(!array_key_exists($lang, vvt\App::$app->getProperty('languages'))){
        return "/" . $url;
    }
    return $request_uri;
}
/**
 * Возвращает значение из массива $_GET по ключу
 *
 * @param string $type Допустимые значения: 'i' (int), 'f' (float), 's' (string).
 * @return int|float|string
 */
function get(string $key, string $type = 'i')
{
    $value = $_GET[$key] ?? '';

    return match($type){
        'i' => (int) $value,
        'f' => (float) $value,
        's' => (string) $value,
        default => throw new InvalidArgumentException('Неизвестный тип данных')
    };
}
/**
 * Возвращает значение из массива $_POST по ключу
 *
 * @param string $type Допустимые значения: 'i' (int), 'f' (float), 's' (string).
 * @return int|float|string
 */
function post(string $key, string $type = 'i')
{
    $value = $_POST[$key] ?? '';

    return match($type){
        'i' => (int) $value,
        'f' => (float) $value,
        's' => (string) $value,
        default => throw new InvalidArgumentException('Неизвестный тип данных')
    };
}
function getTranslatedPart(string $key):string
{
    return \vvt\Language::get($key);
}
function getCartIcon(int $id)
{
    if(!empty($_SESSION['cart']) && array_key_exists($id, $_SESSION['cart'] )){
        $icon = '<i class="fas fa-cart-arrow-down"></i>';
    } else{
        $icon = '<i class="fas fa-shopping-cart"></i>';
    }
    return $icon;
}