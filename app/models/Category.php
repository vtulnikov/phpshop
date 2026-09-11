<?php
declare(strict_types = 1);

namespace app\models;

use RedBeanPHP\R;

class Category extends AppModel
{
    public function getCategory(string $slug, int $lang):array
    {
        return R::getRow("SELECT c.*, cd.* FROM category as c 
                        JOIN category_description as cd on c.id = cd.category_id
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
        return R::getAll("SELECT p.*, pd.* FROM product p JOIN product_description pd on p.id = pd.product_id
                WHERE p.status = 1 AND p.category_id IN ($ids) AND pd.language_id = ? LIMIT ?, ?", [$lang, $offset, $perpage]);
    }
    public function getTotalPosts(int $catId):int
    {
        return R::count('product', "category_id = ? AND status = 1", [$catId]);
    }
}