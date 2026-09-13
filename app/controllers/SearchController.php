<?php
declare(strict_types = 1);

namespace app\controllers;

use vvt\App;
use vvt\Pagination;
use app\models\Search;

/**@property Search $model */
class SearchController extends AppController
{
    public function indexAction()
    {
        $s = get('s', 's');
        $lang = App::$app->getProperty('language');
        $page = get('page');
        $perpage = App::$app->getProperty('pagination');

        $total = $this->model->getTotalProducts($s, $lang['id']);

        $pagination = new Pagination($page, $perpage, $total);
        $offset = $pagination->getOffset();

        $products = $this->model->getFoundProducts($s, $lang['id'], $offset, $perpage);

        $this->setMeta(getTranslatedPart('tpl_search_query') . $s);
        $this->setData(compact('s','total','pagination','products'));
    }
}