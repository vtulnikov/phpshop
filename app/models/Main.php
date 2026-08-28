<?php

namespace app\models;

use RedBeanPHP\R;

class Main extends AppModel
{
    public function getProducts($lang, $limit=3)
    {
        return $this->db->query("SELECT p.*, pd.* FROM  product as p JOIN product_description as pd on p.id = pd.product_id 
        WHERE p.status = 1 AND p.hit = 1 AND pd.language_id = ? LIMIT $limit", [$lang])->findAll();
    }
    public function getSlides():array
    {
        return $this->db->query("SELECT * from slider")->findAll();
    }
}
