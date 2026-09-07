<?php

namespace app\models;

use vvt\Model;
use RedBeanPHP\R;
use vvt\App;

class AppModel extends Model
{
    public function setMenuData(int $lang)
    {
        $categories = R::getAssoc("SELECT category_id, c.id, c.parent_id, language_id, title, c.slug, content 
            FROM category_description AS cd
            JOIN category AS c ON cd.category_id = c.id WHERE cd.language_id = ?", [$lang]);
        App::$app->setProperty('categories', $categories);
    }
}