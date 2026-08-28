<?php
namespace app\widgets\language;
use RedBeanPHP\R;
use vvt\App;

class Language
{
    protected string $tpl;
    protected array $langs;
    protected array $lang;

    public function __construct()
    {
        $this->tpl = __DIR__ . "/lang_tpl.php";
        $this->run();
    }
    public function run()
    { 
        $this->langs = App::$app->getProperty('languages');
        $this->lang = App::$app->getProperty('language');
        echo $this->getHtml();
    }
    public static function getLangs():array
    {
        return R::getAssoc("SELECT code, title, base, id FROM languages ORDER BY base DESC");
    }
    public static function getLang(array $languages)
    {
        $lang = App::$app->getProperty('lang');
        
        if($lang && array_key_exists($lang, $languages)){
            $key = $lang;
        } elseif(!$lang){
            $key = array_key_first($languages);
        } else{
            throw new \Exception('Неизвестный язык ' . htmlspecialchars($lang));
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