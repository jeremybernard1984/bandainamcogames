<?php

namespace App\Controller\Admin;

use Core\HTML\BootstrapForm;

class PlatformsController extends AppController{

    public function __construct(){
        parent::__construct();
        $this->loadModel('Platform');
    }

    public function index(){
        $items = $this->Platform->all();
        $this->render('admin.platforms.index', compact('items'));
    }

    public function add(){
        if (!empty($_POST)) {
            $result = $this->Platform->create([
                'name_platform_EU' => $_POST['name_platform_EU'],
                'name_platform_FR' => $_POST['name_platform_FR'],
                'name_platform_GB' => $_POST['name_platform_GB'],
                'name_platform_DE' => $_POST['name_platform_DE'],
                'name_platform_IT' => $_POST['name_platform_IT'],
                'name_platform_ES' => $_POST['name_platform_ES'],
                'name_platform_SG' => $_POST['name_platform_SG'],
                'name_platform_AE' => $_POST['name_platform_AE'],
                'name_platform_AU' => $_POST['name_platform_AU'],
            ]);
            return $this->index();
        }
        $form = new BootstrapForm($_POST);
        $this->render('admin.platforms.edit', compact('form'));
    }

    public function edit(){
        if (!empty($_POST)) {
            $result = $this->Platform->update($_GET['id'], [
                'name_platform_EU' => $_POST['name_platform_EU'],
                'name_platform_FR' => $_POST['name_platform_FR'],
                'name_platform_GB' => $_POST['name_platform_GB'],
                'name_platform_DE' => $_POST['name_platform_DE'],
                'name_platform_IT' => $_POST['name_platform_IT'],
                'name_platform_ES' => $_POST['name_platform_ES'],
                'name_platform_SG' => $_POST['name_platform_SG'],
                'name_platform_AE' => $_POST['name_platform_AE'],
                'name_platform_AU' => $_POST['name_platform_AU'],
            ]);
            return $this->index();
        }
        $platform = $this->Platform->find($_GET['id']);
        $form = new BootstrapForm($platform);
        $this->render('admin.platforms.edit', compact('form'));
    }

    public function delete(){
        if (!empty($_POST)) {
            $result = $this->Platform->delete($_POST['id']);
            return $this->index();
        }
    }

}