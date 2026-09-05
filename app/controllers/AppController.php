<?php
namespace app\controllers;

use app\models\AppModel;
use app\models\Cart;
use app\widgets\languages\Language;
use vvt\Controller;
use vvt\App;

class AppController extends Controller
{
    public function __construct(array $route)
    {
        parent::__construct($route);
        /**
         * создаем подключение к БД, чтобы в футере метод getDBLogs() не выкидывал ошибку, 
         * если нет соответствующей модели для контроллера, обрабатывающего текущую страницу
         */
        new AppModel();
        App::$app->setProperty('languages', Language::getLanguages());
        $currentLanguageInfo = Language::getLanguage(App::$app->getProperty('languages'));
        App::$app->setProperty('language', $currentLanguageInfo);
        
        \vvt\Language::load($currentLanguageInfo['code'], $this->route);
        Cart::translateCart($currentLanguageInfo['id']);
    }
}