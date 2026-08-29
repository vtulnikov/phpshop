<?php
declare(strict_types = 1);

namespace app\widgets\languages;

use RedBeanPHP\R;

class Language
{
    private $tpl;
    private array $languages;
    private string $language;

    public function __construct()
    {
        $this->tpl = __DIR__ . "/lang.tpl.php";
        $this->run();
    }
    public function run()
    {

    }
    public static function getLanguages():array
    {
        return R::getAssoc("SELECT code, title, base, id FROM languages ORDER BY base DESC");
    }
    public static function getLanguage($languages)
    {

    }
}