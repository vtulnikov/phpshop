<?php
declare(strict_types = 1);

namespace app\models;

use vvt\App;

class Breadcrumbs extends AppModel
{
    public static function getBreadcrumbs(int $categoryId, string $name = ""):string
    {
        $categories = App::$app->getProperty('categories');
        $breadcrumbsArray = self::getParts($categories, $categoryId);
        $breadcrumbs = '<li class="breadcrumb-item"><a href="' . getBaseURl() . '">'
            . getTranslatedPart('tpl_home_breadcrumbs') . '</a></li>';
       
        foreach($breadcrumbsArray as $slug => $title){
            $breadcrumbs .= '<li class="breadcrumb-item">
                <a href="category/'. $slug .'">'. $title .'</a></li>';
        }
        if($name != ""){
            $breadcrumbs .= '<li class="breadcrumb-item active" aria-current="page"> ' . $name . '</li>';
        }
        return $breadcrumbs;
    }
    private static function getParts(array $categories, int $id):array
    {
        $breadcrumbs = [];
        while(isset($categories[$id])){
                $breadcrumbs[$categories[$id]['slug']] = $categories[$id]['title'];
                $id = $categories[$id]['parent_id'];
            } 
        return array_reverse($breadcrumbs, true);
    }
}