<?php
declare(strict_types = 1);

namespace app\models;

use RedBeanPHP\R;

class Categories extends AppModel
{
    public static function getCategories(int $lang)
    {
        return R::getAssoc("SELECT category_id, c.id, c.parent_id, language_id, title, c.slug, content 
            FROM category_description AS cd
            JOIN category AS c ON cd.category_id = c.id WHERE cd.language_id = ?", [$lang]);
    }
}