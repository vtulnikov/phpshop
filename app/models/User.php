<?php
declare(strict_types = 1);

namespace app\models;

use Valitron\Validator;
use vvt\App;
use RedBeanPHP\R;

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
            ['password', 5],
        ],
        'lengthMax' => [
            ['email', 50],
            ['password', 255],
            ['name', 255],
            ['address', 255],
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
    public function save(string $table)
    {
        $tbl = R::dispense($table);
        foreach($this->attributes as $k => $v){
            if($v != ""){
                $tbl->$k = $v;
            }
        }
        return R::store($tbl);
    }
    //его можно сделать универсальным, передавая аргументами таблицу, поле и значение
    public function isUnique($textError = ""):bool
    {
        $user = R::findOne('users', 'email=?', [$this->attributes['email']]);
        if($user){
            $this->errors['unique'][] = $textError ?: getTranslatedPart('user_signup_error_email_unique');
            return false;
        } else{
            return true;
        }
    }
    public function login():bool
    {
        $email = post('email');
        $password = post('password');

        if($email && $password){
            $user = R::findOne('users', "email = ?", [$email]);
            if($user){
                if(password_verify($password, $user->password)){
                    foreach($user as $k => $v){
                        if($k == 'password') continue;
                        $_SESSION['user'][$k] = $v;
                    }
                    return true;
                }
            }
        }
        return false;
    }
}