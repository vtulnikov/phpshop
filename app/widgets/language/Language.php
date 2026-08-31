<?php
declare(strict_types = 1);

namespace app\widgets\language;

use vvt\App;
use RedBeanPHP\R;

class Language
{
    private array $languages;
    private array $language;
    private string $tpl;

    public function __construct()
    {
        $this->tpl = APP . "/widgets/language/lang.tpl.php";
        $this->languages = App::$app->getProperty('languages');
        $this->language = App::$app->getProperty('language');
    }
    public static function getLanguages():array
    {
        return R::getAssoc("SELECT code,title,base,id FROM languages ORDER BY base DESC");
    }
    public static function getLanguage(array $languages) 
    {
        $lang = App::$app->getProperty('lang');
        if($lang && array_key_exists($lang, $languages)){
            $key = $lang;
        } elseif(!$lang){
            $key = array_key_first($languages);
        } else{
            //редиректим на страницу без языка
            $url = checkUrlLanguage($_SERVER['REQUEST_URI']);
            redirect($url);
        }
        $langInfo = $languages[$key];
        $langInfo['code'] = $key;
        return $langInfo;
    }
    public function getHtml()
    {
        ob_start();
        require $this->tpl;
        return ob_get_clean();
    }
}