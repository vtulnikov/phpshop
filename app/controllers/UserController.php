<?php

declare(strict_types=1);

namespace app\controllers;

use app\models\User;

/**@property User $model */
class UserController extends AppController
{
    public function loginAction()
    {
        if (User::checkAuth()) {
            redirect("user/cabinet");
        }
        if (!empty($_POST)) {
            if ($this->model->login()) {
                $_SESSION['success'] = getTranslatedPart('user_login_success');
                redirect("user/cabinet");
            } else {
                $_SESSION['errors'] = getTranslatedPart('user_login_error');
                redirect();
            }
        }
        $this->setMeta(getTranslatedPart('tpl_login'));
    }
    public function logoutAction() {
        if(isset($_SESSION['user'])){
            unset($_SESSION['user']);
        }
        redirect("user/login");
    }
    public function signupAction()
    {
        if (User::checkAuth()) {
            redirect("user/cabinet");
        }
        if (!empty($_POST)) {
            $data = $_POST;
            $this->model->load($data);

            if (!$this->model->validate($data) || !$this->model->checkUnique()) {
                $this->model->getErrors();
                $_SESSION['form_data'] = $data;
                redirect();
            } else {
                $this->model->attributes['password'] = password_hash($this->model->attributes['password'], PASSWORD_ARGON2I);
                if ($this->model->save('users')) {
                    $_SESSION['success'] = getTranslatedPart('user_signup_success_register');
                    redirect("user/login");
                } else {
                    $_SESSION['errors'] = getTranslatedPart('user_signup_error_register');
                    redirect();
                }
            }
        }
        $this->setMeta(getTranslatedPart('tpl_signup'));
    }
    public function cabinetAction() {}
}
