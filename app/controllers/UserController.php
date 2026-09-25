<?php
declare(strict_types = 1);

namespace app\controllers;

use app\models\User;

/**@property User $model */
class UserController extends AppController
{
    public function loginAction()
    {
        if(User::checkAuth()){
            redirect(getBaseUrl());
        }
        $this->setMeta(getTranslatedPart('tpl_login'));

        if(!empty($_POST)){
            if($this->model->login()){
                $_SESSION['success'] = getTranslatedPart('user_login_success');
                redirect("user/cabinet");
            } else{
                $_SESSION['errors'] = getTranslatedPart('user_login_error');
                redirect();
            }
        }
    }
    public function logoutAction()
    {
        if(isset($_SESSION['user'])){
            unset($_SESSION['user']);
        }
        redirect("user/login");
    }
    public function signupAction()
    {
        if(User::checkAuth()){
            redirect(getBaseUrl());
        }
        $this->setMeta(getTranslatedPart('tpl_signup'));

        if(!empty($_POST)){
            $data = $_POST;
            $this->model->load($data);

            if($this->model->validate($this->model->attributes) && $this->model->isUnique()){
                $this->model->attributes['password'] = password_hash($this->model->attributes['password'], PASSWORD_ARGON2I);
                $this->model->save('users');
                $_SESSION['success'] = getTranslatedPart('user_signup_success_register');
                if(isset($_SESSION['form_data'])){
                    unset($_SESSION['form_data']);
                } 
                redirect("user/login");
            } else {
                $_SESSION['form_data'] = $data;
                $_SESSION['errors'] = $this->model->getErrors();
                redirect();
            }
        }
        
        $this->setMeta(getTranslatedPart('tpl_signup'));
    }
    
    public function cabinetAction()
    {
        if(!User::checkAuth()){
            redirect("user/login");
        }
    }
}