<?php
declare(strict_types = 1);

namespace app\widgets\languages;

use RedBeanPHP\R;
use vvt\App;

class Language
{
    private string $tpl;
    private array $languages;
    private array $language;

    public function __construct()
    {
        $this->tpl = __DIR__ . "/lang.tpl.php";
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
        return R::getAssoc("SELECT code, title, base, id FROM languages ORDER BY base DESC");
    }
    public static function getLanguage(array $languages)
    {
        $lang = App::$app->getProperty('lang');
        if($lang && array_key_exists($lang, $languages)){
            $key = $lang;
        } elseif(!$lang){
            $key = array_key_first($languages);
        } else{
            $url = checkUrlLanguage($_SERVER['REQUEST_URI']);
            redirect(PATH . $url);
        } 
        $lang_info = $languages[$key];
        $lang_info['code'] = $key;
        return $lang_info;
    }
    protected function getHtml():string
    {
        ob_start();
        require $this->tpl;
        return ob_get_clean();
    }
}