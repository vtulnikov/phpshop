<?php
declare(strict_types = 1);

namespace app\models;

use RedBeanPHP\R;

class Product extends AppModel
{
    public function getProduct(string $slug, int $lang):array
    {
        return R::getRow("SELECT p.*, pd.* FROM product as p
                        JOIN product_description as pd on p.id = pd.product_id
                        WHERE p.status = 1 AND p.slug = ? AND pd.language_id = ?", [$slug, $lang]);
    }
    public function getGallery(int $id):array
    {
        return R::getAll("SELECT product_id, img FROM product_gallery 
                WHERE product_id = ?",[$id]);
    }
}