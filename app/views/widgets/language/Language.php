<?php
declare(strict_types = 1);

namespace app\views\widgets\language;

use vvt\App;
use RedBeanPHP\R;

class Language
{
    private array $languages;
    private array $language;
    private string $tpl;

    public function __construct()
    {
        $this->tpl = APP . "/views/widgets/language/lang.tpl.php";
        $this->run();
        
    }
    public function run()
    {
        $this->languages = App::$app->getProperty('languages');
        $this->language = App::$app->getProperty('language');
        echo $this->getHtml();
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
            //TODO редиректим на страницу без языка
            redirect();
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