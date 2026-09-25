<?php
declare(strict_types = 1);

use app\models\User;

if(!User::checkAuth()){
    redirect("user/login");
}
echo "ЛК";