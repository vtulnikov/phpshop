<?php
declare(strict_types = 1);

namespace app\widgets\menu;

use RedBeanPHP\R;
use vvt\App;
use vvt\Cache;

class Menu
{
    protected array $data;
    protected array $tree;
    protected string|false $menuHtml;
    protected string $tpl;
    protected string $container = 'ul';
    protected string $class = 'menu';
    protected int $cacheLife = 0;
    protected string $cacheKey = '';
    protected array $attrs = [];
    protected string $prepend = '';
    protected array $language;

    public function __construct(array $options)
    {
        $this->language = App::$app->getProperty('language');
        $this->tpl = __DIR__. "/menu.tpl.php";
        $this->checkOptions($options);
        $this->run();
    }
    private function run():void
    {
        $cache = Cache::getInstance();
        $this->menuHtml = $cache->get($this->cacheKey . '_' . $this->language['code']);

        if(!$cache->get($this->cacheKey . '_' . $this->language['code'])){
            $this->data = R::getAssoc("SELECT category_id, c.id, c.parent_id, language_id, title, c.slug, content 
                FROM category_description AS cd
                JOIN category AS c ON cd.category_id = c.id WHERE cd.language_id = ?", [$this->language['id']]);
            
            $this->tree = $this->getTree();
            $this->menuHtml = $this->getHtml($this->tree);
            if($this->cacheLife){
                $cache->set($this->cacheKey . '_' . $this->language['code'], $this->output(), $this->cacheLife);
            }
        } 
        echo $this->output();
    }
    public function getTree():array
    {
        $tree = [];
        $data = $this->data;
        foreach($data as $id => &$node){
            if(!$node['parent_id']){
                $tree[$id] = &$node;
            } else{
                $data[$node['parent_id']]['children'][$id] = &$node;
            }
        }
        unset($node);
        return $tree;
    }
    private function checkOptions(array $options):void
    {
        foreach($options as $key => $value){
            if(!property_exists($this, $key)) continue;
            $this->$key = $value;
        }
    }
    private function getHtml(array $tree):string
    {
        $res = "";
        foreach($tree as $id => $category){
            $res .= $this->callTemplate($category);
        }
        return $res;
    }
    private function callTemplate(array $category):string
    {
        ob_start();
        require $this->tpl;
        return ob_get_clean();
    }
    private function getAttributes(){
        $res = "";
        foreach($this->attrs as $k => $v){
            $res .= sprintf('%s=%s', (string) h($k), (string) h($v) );
        }
        return $res;
    }
    private function output()
    {
        $res = '<' . $this->container . ' class="' . $this->class . '"'. $this->getAttributes() . '>';
        $res .= $this->prepend;
        $res .= $this->menuHtml;
        $res .= '</' . $this->container . '/>';
        return $res;
    }
}