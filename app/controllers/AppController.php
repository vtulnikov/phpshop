<?php
namespace app\controllers;

use app\models\AppModel;
use app\widgets\language\Language;
use vvt\App;
use vvt\Controller;

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
        App::$app->setProperty('languages', Language::getLangs());
        App::$app->setProperty('language', Language::getLang( App::$app->getProperty('languages') ));
        // debug(App::$app->getProperty('languages'));
    }
}