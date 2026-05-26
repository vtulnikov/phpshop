<?php
namespace app\widgets\language;

use RedBeanPHP\R;
use vvt\App;

class Language
{
    protected string $tpl; //внеший вид виджета
    protected array $langs;
    protected array $lang;

    public function __construct()
    {
        $this->tpl = __DIR__ . '/lang_tpl.php';
        $this->langs = App::$app->getProperty('languages');
        $this->lang = App::$app->getProperty('language');
        echo $this->getHtml();
        //не до конца понял, зачем нам отдельный метод, если можно просто подключить прямоо здесь
        // require $this->tpl;
    }
    public static function getLangs()
    {
        return R::getAssoc("SELECT code, title, base, id FROM languages ORDER BY base DESC ");
    }
    public static function getLang(array $languages):array
    {
        $lang = App::$app->getProperty('lang');

        if($lang && array_key_exists($lang, $languages)){
            $key = $lang;
        } else if(!$lang){
            $key = array_key_first($languages);
        } else{
            throw new \Exception("Неизвестный ключ языка " . htmlspecialchars($lang), 404);
        }
        
        $langInfo = $languages[$key];
        //добавим еще code, чтобы был в этом массиве: ru, en и т.д.
        $langInfo['code'] = $key;
        
        return $langInfo;
    }
    protected function getHtml()
    {
        ob_start();
        require $this->tpl;
        return ob_get_clean();
    }
}