<?php
namespace app\controllers;

use app\models\AppModel;
use app\models\Cart;
use app\widgets\language\Language;
use vvt\App;
use vvt\Controller;

class AppController extends Controller
{
    public function __construct(array $route)
    {
        parent::__construct($route);
        new AppModel();
        App::$app->setProperty('languages', Language::getLanguages());
        $currentLanguageInfo = Language::getLanguage(App::$app->getProperty('languages'));
        App::$app->setProperty('language', $currentLanguageInfo);

        //загружаем все данные для перевода шаблонных фраз
        \vvt\Language::load($currentLanguageInfo['code'], $this->route);

        Cart::translateCart($currentLanguageInfo['id']);
    }
}