<?php
declare(strict_types = 1);

namespace app\models;

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
            'password' => 6
        ],
        'lengthMax' => [
            'email' => 50,
            'password' => 255,
            'name' => 255,
            'address' => 255,
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

}