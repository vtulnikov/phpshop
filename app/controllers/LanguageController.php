<?php

declare(strict_types=1);

namespace app\controllers;

use vvt\App;

class LanguageController extends AppController
{
    public function changeAction()
    {
        $lang = get('lang', 's');
        $validLanguages = App::$app->getProperty('languages');
        $baseLanguage = App::$app->getProperty('language')['code'];

        if (!$lang || !array_key_exists($lang, $validLanguages)) {
            redirect();
        }

        $url = trim(parse_url($_SERVER['HTTP_REFERER'], PHP_URL_PATH), "/");
        $url_parts = explode("/", $url, 2);

        if (array_key_exists($url_parts[0], $validLanguages)) {
            //если переключаемся с др. языка на третий
            if ($lang != $baseLanguage) {
                //то перезаписываем значение старого в массиве
                $url_parts[0] = $lang;
            } else {
                //если же переключаемся на базовый, то удаляем тот, который был раньше из массива
                array_shift($url_parts);
            }
        } else {
            //если переключаемся с базового на другой проверяем, что не пытаемся переключиться с базового на базовый
            if ($lang != $baseLanguage) {
                //и просто доабвляем в массив язык на который переключаемся
                array_unshift($url_parts, $lang);
            }
        }
        $url = PATH . '/' . implode('/', $url_parts);
        redirect($url);
    }
}
