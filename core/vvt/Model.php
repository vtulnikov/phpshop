<?php

namespace vvt;

abstract class Model
{
    private array $attributes = [];
    private array $errors = [];
    private array $rules = [];
    private array $labels = [];

    public function __construct()
    {
        Db::getInstance();
    }
}