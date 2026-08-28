<?php

namespace vvt;

abstract class Model
{
    public array $attributes = [];
    public array $errors = [];
    public array $rules = [];
    public array $labels = [];
    protected ?MyDb $db = null;

    public function __construct()
    {
        Db::getInstance();
        $this->db = new MyDb(Registry::getInstance()->getProperty('dbconfig'));
    }
}