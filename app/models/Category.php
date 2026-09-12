<?php
declare(strict_types = 1);

namespace app\models;

use RedBeanPHP\R;

class Category extends AppModel
{
    public function getCategory(string $slug, int $lang)
    {
        return R::getRow("SELECT c.*, cd.* FROM category c JOIN category_description cd on c.id = cd.category_id
                WHERE c.slug = ? AND cd.language_id = ?", [$slug, $lang]);
    }
    public function getIds(array $cats, int $catId):string
    {
        $result = "";
        foreach($cats as $id => $data){
            if((int)$data['parent_id'] === $catId){
                $result .= $id . ",";
                $result .= $this->getIds($cats, $id);
            }
        }
        return $result;
    }
    public function getProducts(string $ids, int $lang, int $offset, int $perpage)
    {
        $sortValues = [
            "title_asc"  => 'ORDER BY title ASC', 
            "title_desc" => 'ORDER BY title DESC', 
            "price_asc"  => 'ORDER BY price ASC',  
            "price_desc" => 'ORDER BY price DESC', 
        ];
        $orderBy = "";
        if(isset($_GET['sort']) && array_key_exists($_GET['sort'], $sortValues)){
            $orderBy = $sortValues[$_GET['sort']];
        }
        return R::getAll("SELECT p.*, pd.* FROM product p JOIN product_description pd on p.id = pd.product_id
                WHERE p.status = 1 AND p.category_id IN ($ids) AND pd.language_id = ? $orderBy LIMIT $offset, $perpage", [$lang]);
    }
    public function getTotalProducts(string $ids):int
    {
        return R::count('product', "category_id IN ($ids) AND status = 1");
    }
}