<?php
declare(strict_types = 1);

namespace app\models;

use RedBeanPHP\R;

class Page extends AppModel
{
    public function getPage(string $slug, int $lang)
    {
        return R::getRow("SELECT p.*, pd.* FROM page p 
                        JOIN page_description pd
                        ON p.id = pd.page_id
                        WHERE p.slug = ? AND pd.language_id = ?", [$slug,$lang]);
    }
}