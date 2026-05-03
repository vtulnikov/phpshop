<?php

namespace vvt;

use stdClass;

abstract class Controller
{
    public array $data = [];
    public array $meta = ['title' => '', 'description' => '', 'keywords' => ''];
    public false|string $layout = '';
    public string $view = '';
    public object $model;

    public function __construct( public array $route = [] ) {}

    public function getModel()
    {
        $model = "app\model\\" . $this->route["admin_prefix"] . $this->route["controller"];
        if(class_exists($model)){
            $this->model = new $model;
        }
    }
    public function getView():void
    {
        $this->view = $this->view ?: $this->route['action']; 
    }
    public function set(array $data):void
    {
        $this->data = $data;
    }
    public function setMeta($title ="", $descriprion = "", $keywords = "")
    {
        $this->meta = [
            'title'=> $title,
            'description' => $descriprion,
            'keywords' => $keywords
        ];
    }
}