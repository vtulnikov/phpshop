<?php
declare(strict_types = 1);

namespace app\controllers;

use vvt\App;
use app\models\Page;

/**@property Page $model */
class PageController extends AppController
{
    public function indexAction()
    {
        $lang = App::$app->getProperty('language');
        $page = $this->model->getPage($this->route['slug'], $lang['id']);
        if(!$page){
            $this->error_404();
            return;
        }
        $this->setMeta($page['title'], $page['description'], $page['keywords']);
        $this->setData(compact('page'));
    }
}