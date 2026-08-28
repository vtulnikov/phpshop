<?php

namespace app\models;

use RedBeanPHP\R;

class Main extends AppModel
{
    public function getNames():array
    {
        return R::findAll('users');
    }
    public function getHits($lang, $limit=6)
    {
        return R::getAll("SELECT p.*, pd.* FROM  product as p JOIN product_description as pd on p.id = pd.product_id 
        WHERE p.status = 1 AND p.hit = 1 AND pd.language_id = ? LIMIT $limit", [$lang]);
    }
    public function getSlides():array
    {
        return R::findAll('slider');
    }
}
