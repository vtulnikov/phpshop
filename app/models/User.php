<?php
declare(strict_types = 1);

namespace app\models;

use Valitron\Validator;
use vvt\App;

class User extends AppModel
{
    public array $attributes = [
        'email' => '',
        'password' => '',
        'name' => '',
        'address' => '',
    ];
    protected array $rules = [
        'required' => ['name', 'password', 'email', 'address'],
        'email' => ['email'],
        'lengthMin' => [
            'password' => 5,
        ],
        'lengthMax' => [
            'email' => 50,
            'password' => 255,
            'name' => 255,
            'address' => 255,
        ],
    ];
    protected array $labels = [
        'email' => 'tpl_signup_email_input',
        'password' => 'tpl_signup_password_input',
        'name' => 'tpl_signup_name_input',
        'address' => 'tpl_signup_address_input',
    ];

    public static function checkAuth():bool
    {
        return isset($_SESSION['user']);
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
    public function getErrors():string
    {
        $result = "<ul>";
        foreach($this->errors as $error){
            foreach($error as $item){
                $result .= "<li>". $item . "</li>";
            }
        }
        $result .= "</ul>";
        return $result;
    }
    public function getLabels()
    {
        $labels = [];
        foreach($this->labels as $k => $v){
            $labels[$k] = getTranslatedPart($v);
        }
        return $labels;
    }
}