<?php

function debug($data, $die = false)
{
    echo "<pre>". print_r($data, true) . "</pre>";
    if($die) die;
}
function h(string $data)
{
    return htmlspecialchars($data);
}
function redirect($url = "")
{
    $redirect = $url ?: PATH;
    header("Location: {$redirect}");
    die;
}
function getBaseUrl():string
{
    return PATH . '/' . (vvt\App::$app->getProperty('lang') ? vvt\App::$app->getProperty('lang') . '/' : '');
}
function checkUrlLanguage(string $request_uri)
{
    $path = trim($request_uri, "/");
    $url_parts = explode("/", $path, 2);
    if(!array_key_exists($url_parts[0], vvt\App::$app->getProperty('languages'))){
        return "/" . $url_parts[1];
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