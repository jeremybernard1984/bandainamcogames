<?php

namespace App\Controller;

use Core\Auth\DBAuth;
use Core\HTML\BootstrapForm;
use \App;

class sitepagesController extends AppController {


    public function index(){
        $this->render('sitepages.index');
    }


}