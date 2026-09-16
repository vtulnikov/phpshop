<?php
declare(strict_types = 1);

namespace app\widgets\page;

use RedBeanPHP\R;
use vvt\App;
use vvt\Cache;

class Page
{
    protected array $data;
    protected string|false $menuPageHtml;
    protected string $container = 'ul';
    protected string $class = 'ist-unstyled';
    protected int $cacheLife = 3600;
    protected string $cacheKey = '';
    protected array $attrs = [];
    protected string $prepend = '';
    protected array $language;

    public function __construct(array $options)
    {
        $this->language = App::$app->getProperty('language');
        $this->checkOptions($options);
        $this->run();
    }
    private function run():void
    {
        $cache = Cache::getInstance();
        $this->menuPageHtml = $cache->get($this->cacheKey . '_' . $this->language['code']);

        if(!$this->menuPageHtml){
            $this->data = R::getAssoc("SELECT id, slug, language_id, content, title, keywords, description
                FROM page p JOIN page_description pd
                ON p.id = pd.page_id WHERE pd.language_id = ?", [$this->language['id']]);
            
            $this->menuPageHtml = $this->getHtml($this->data);
            if($this->cacheLife){
                $cache->set($this->cacheKey . '_' . $this->language['code'], $this->output(), $this->cacheLife);
            }
        } 
        echo $this->output();
    }
    private function checkOptions(array $options):void
    {
        foreach($options as $key => $value){
            if(!property_exists($this, $key)) {
                throw new  \InvalidArgumentException("Неизвестное свойство - {$key}");   
            };
            $this->$key = $value;
        }
    }
    private function getHtml(array $pages):string
    {
        $res = "";
        foreach($pages as $id => $data){
            $res .= '<li><a href="page/'. h($data['slug']) .'">'. h($data['title']) .'</a></li>';
        }
        return $res;
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
        $res = $this->prepend;
        $res .= '<' . $this->container . ' class="' . $this->class . '"'. $this->getAttributes() . '>';
        $res .= $this->menuPageHtml;
        $res .= '</' . $this->container . '/>';
        return $res;
    }
}