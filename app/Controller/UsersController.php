<?php

namespace App\Controller;

use Core\Auth\DBAuth;
use Core\HTML\BootstrapForm;
use \App;

class UsersController extends AppController {


    public function login(){
        $errors = false;
        if(!empty($_POST)){
            $auth = new DBAuth(App::getInstance()->getDb());
            $HashedPassword = $auth->SearchUserPassword($_POST['login']);
            $uniqueKey = $auth->SearchUserKey($_POST['login']);
            //var_dump($HashedPassword);
            // Je decrypt por verifier si le login est bon VOIR DBAuth.php
            if($auth->login($_POST['login'], $HashedPassword, $uniqueKey)){
                    header('Location: index.php?p=admin.dashboards.index');
            }
            else {
                $errors = true;
            }
        }
        $form = new BootstrapForm($_POST);
        $this->render('users.login', compact('form', 'errors'));
    }

    public function logOut(){
        unset($_SESSION['auth']);
        unset($_SESSION['lang']);
        $form = new BootstrapForm($_POST);
        $this->render('sitepages.index');
    }

}