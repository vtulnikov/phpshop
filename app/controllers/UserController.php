<?php
declare(strict_types = 1);

namespace app\controllers;

use app\models\User;

/**@property User $model */
class UserController extends AppController
{
    public function loginAction()
    {
        
    }
    public function logoutAction()
    {

    }
    public function signupAction()
    {
        if(User::checkAuth()){
            redirect(getBaseUrl());
        }
        if(!empty($_POST)){
            $data = $_POST;
            $this->model->load($data);
            dump($data);
            dump($this->model->attributes);
        }
       
        $this->setMeta(getTranslatedPart('tpl_signup'));
    }
    public function cabinetAction()
    {

    }
}