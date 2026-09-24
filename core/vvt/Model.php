<?php

namespace vvt;

use Valitron\Validator;

abstract class Model
{
    protected array $attributes = [];
    protected array $errors = [];
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
    public function validate(array $data):bool
    {
        Validator::langDir(APP . "/languages/validator/lang/");
        Validator::lang(App::$app->getProperty('language')['code']);
        $validator = new Validator($data);
        $validator->rules($this->rules);
        $validator->labels($this->getLabels());
        if($validator->validate()){
            return true;
        } else{
            $this->errors = $validator->errors();
            return false;
        }
    }
    public function getErrors()
    {
        $errors = '<ul>';
        foreach($this->errors as $error){
            foreach($error as $item){
                $errors .= "<li>{$item}</li>";
            }
        }
        $errors .= '</ul>';
        $_SESSION['errors'] = $errors;
    }
    public function getLabels():array
    {
        $labels = [];
        foreach($this->labels as $key => $value){
            $labels[$key] = getTranslatedPart($value);
        }
        return $labels;
    }
}