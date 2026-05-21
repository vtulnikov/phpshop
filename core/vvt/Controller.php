<?php

namespace vvt;

abstract class Controller
{
    public array $data = [];
    public array $meta = ['title' => '', 'description' => '', 'keywords' => ''];
    public false|string $layout = '';
    public string $view = '';
    public object $model;
    public array $route = [];

    public function __construct(array $route)
    {
        $this->route = $route;
    }
    public function getModel():void
    {
        $model = "app\models\\" . $this->route['admin_prefix'] . $this->route['controller'];
        if(class_exists($model)){
            $this->model = new $model;
        }
    }
    public function getView():void
    {
        $this->view = $this->view ?: $this->route['action'];
        new View($this->route, $this->layout, $this->view, $this->meta)->render($this->data);
    }
    public function setData(array $data)
    {
        $this->data = $data; //получаем, н-р, из MainController данные со сладами из БД и передаем их в View через getView в методе render($data)
    }
    public function setMeta($title = "", $description = "", $keywords = ""):void
    {
        $this->meta = [
            "title" => $title,
            "description" => $description,
            "keywords" => $keywords
        ];
    }
}