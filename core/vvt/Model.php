<?php

namespace vvt;

abstract class Model
{
    protected array $attributes = [];
    public array $errors = [];
    protected array $rules = [];
    protected array $labels = [];

    public function __construct()
    {
        Db::getInstance();
    }
    public function load(array $data)
    {
        foreach($this->attributes as $name => $value){
            if(isset($data[$name])){
                $this->attributes[$name] = $data[$name];
            }
        }
    }
}