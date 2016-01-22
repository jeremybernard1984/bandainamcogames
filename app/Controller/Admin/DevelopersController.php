<?php

namespace App\Controller\Admin;

use Core\HTML\BootstrapForm;

class DevelopersController extends AppController{

    public function __construct(){
        parent::__construct();
        $this->loadModel('developer');
    }

    public function index(){
        $items = $this->developer->all();
        $this->render('admin.developers.index', compact('items'));
    }

    public function add(){
        if (!empty($_POST)) {
            $result = $this->developer->create([
                'name_developer_EU' => $_POST['name_developer_EU'],
                'name_developer_FR' => $_POST['name_developer_FR'],
                'name_developer_GB' => $_POST['name_developer_GB'],
                'name_developer_DE' => $_POST['name_developer_DE'],
                'name_developer_IT' => $_POST['name_developer_IT'],
                'name_developer_ES' => $_POST['name_developer_ES'],
                'name_developer_SG' => $_POST['name_developer_SG'],
                'name_developer_AE' => $_POST['name_developer_AE'],
                'name_developer_AU' => $_POST['name_developer_AU'],
            ]);
            return $this->index();
        }
        $form = new BootstrapForm($_POST);
        $this->render('admin.developers.edit', compact('form'));
    }

    public function edit(){
        if (!empty($_POST)) {
            $result = $this->developer->update($_GET['id'], [
                'name_developer_EU' => $_POST['name_developer_EU'],
                'name_developer_FR' => $_POST['name_developer_FR'],
                'name_developer_GB' => $_POST['name_developer_GB'],
                'name_developer_DE' => $_POST['name_developer_DE'],
                'name_developer_IT' => $_POST['name_developer_IT'],
                'name_developer_ES' => $_POST['name_developer_ES'],
                'name_developer_SG' => $_POST['name_developer_SG'],
                'name_developer_AE' => $_POST['name_developer_AE'],
                'name_developer_AU' => $_POST['name_developer_AU'],
            ]);
            return $this->index();
        }
        $developer = $this->developer->find($_GET['id']);
        $form = new BootstrapForm($developer);
        $this->render('admin.developers.edit', compact('form'));
    }

    public function delete(){
        if (!empty($_POST)) {
            $result = $this->developer->delete($_POST['id']);
            return $this->index();
        }
    }

}