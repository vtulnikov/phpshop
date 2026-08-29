<?php

use vvt\App;

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
    $redirect = $url ?? PATH;
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