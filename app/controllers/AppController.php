<?php
namespace app\controllers;

use app\models\AppModel;
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
    }
}