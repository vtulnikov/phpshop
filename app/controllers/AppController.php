<?php
namespace app\controllers;

use app\models\AppModel;
use app\views\widgets\language\Language;
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
    }
}