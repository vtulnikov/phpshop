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