<?php
declare(strict_types = 1);

namespace app\models;

use RedBeanPHP\R;

class User extends AppModel
{
    public array $attributes = [
        'email' => '',
        'password' => '',
        'name' => '',
        'address' => '',
    ];
    public array $rules = [
        'required' => ['email', 'password', 'name', 'address'],
        'email'    => ['email'],
        'lengthMin' => [
            ['password', 6],
        ],
        'lengthMax' => [
            ['email', 50],
            ['password', 255],
            ['name', 255],
            ['address', 255],
        ],
    ];
    public array $labels = [
        'email' => 'tpl_signup_email_input',
        'password' => 'tpl_signup_password_input',
        'name' => 'tpl_signup_name_input',
        'address' => 'tpl_signup_address_input',
    ];

    public static function checkAuth():bool
    {
        return isset($_SESSION['user']);
    }

    public function save(string $table): int|string
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
    public function checkUnique($textError = ""):bool
    {
        $user = R::findOne('users', 'email=?', [$this->attributes['email']]);
        if($user){
            $this->errors['unique'][] = $textError ?: getTranslatedPart('user_signup_error_email_unique');
            return false;
        } else{
            return true;
        }
    }
}