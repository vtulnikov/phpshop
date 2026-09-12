<?php
declare(strict_types = 1);

namespace app\controllers;

use vvt\App;
use app\models\Search;
use vvt\Pagination;

/**@property Search $model */
class SearchController extends AppController
{
    public function indexAction()
    {
        $s = get('s', 's');
        $lang = App::$app->getProperty('language');
        $page = get('page');
        $perpage = (int) App::$app->getProperty('pagination');
        $total = $this->model->countFoundProducts($s, (int) $lang['id']);

        $pagination = new Pagination($page, $perpage, $total);
        $offset = $pagination->getStart();

        $products = $this->model->getFoundProduct($s, (int) $lang['id'], $offset, $perpage);
        $this->setMeta(getTranslatedPart('tpl_search_title'));
        $this->setData(compact('s', 'pagination', 'products', 'total'));
    }
}