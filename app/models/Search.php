<?php
declare(strict_types = 1);

namespace app\models;

use RedBeanPHP\R;

class Search extends AppModel
{
    public function countFoundProducts(string $s, int $lang):int
    {
        return (int) R::getCell("SELECT count(*) FROM product p JOIN product_description pd
                ON p.id = pd.product_id WHERE p.status = 1 AND pd.language_id = ? 
                AND pd.title LIKE ?", [$lang, "%{$s}%"]);
    }
    public function getFoundProduct(string $s, int $lang, int $offset, int $perpage):array
    {
        return R::getAll("SELECT p.*, pd.* FROM product p JOIN product_description pd
                ON p.id = pd.product_id 
                WHERE p.status = 1 AND pd.language_id = ? AND pd.title LIKE ? LIMIT $offset, $perpage",
                [$lang, "%{$s}%"]);
    }
}