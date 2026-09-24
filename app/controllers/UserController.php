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
            redirect("user/cabinet");
        }
        if(!empty($_POST)){
            $data = $_POST;
            $this->model->load($data);
            if(!$this->model->validate($data)){
                $this->model->getErrors();
                redirect();
            } else{
                $_SESSION['success'] = getTranslatedPart('user_signup_success_register');
                redirect("/user/cabinet");
            }
        }
        $this->setMeta(getTranslatedPart('tpl_signup'));
    }
    public function cabinetAction()
    {

    }
}