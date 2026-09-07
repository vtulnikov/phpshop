<?php
declare(strict_types = 1);

namespace app\models;

use vvt\App;

class Breadcrumbs extends AppModel
{
    public static function getBreadCrumbs(int $categoryId, string $name = "")
    {
        $lang = App::$app->getProperty('language');
        $categories = App::$app->getProperty("categories_{$lang['code']}");
        $breadcrumbsArray = self::getParts($categories, $categoryId);
        $breadcrumbs = '<li class="breadcrumb-item"><a href="' . getBaseURl() . '">'
            . getTranslatedPart('tpl_home_breadcrumbs') . '</a></li>';
       
        if($breadcrumbsArray){
            foreach($breadcrumbsArray as $slug => $title){
                $breadcrumbs .= '<li class="breadcrumb-item">
                    <a href="category/'. $slug .'">'. $title .'</a></li>';
            }
        }
        if($name){
            $breadcrumbs .= '<li class="breadcrumb-item active" aria-current="page"> ' . $name . '</li>';
        }
        return $breadcrumbs;
    }
    private static function getParts(array $cats, int $id):array|false
    {
        $breadcrumbs = [];
        foreach($cats as $k => $v){
            if(isset($cats[$id])){
                $breadcrumbs[$cats[$id]['slug']] = $cats[$id]['title'];
                $id = $cats[$id]['parent_id'];
            } else{
                break;
            }
        }
        return array_reverse($breadcrumbs, true);
    }
}
