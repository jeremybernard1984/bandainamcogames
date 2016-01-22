<?php

namespace App\Controller\Admin;

use Core\HTML\BootstrapForm;

class FamiliesController extends AppController{

    public function __construct(){
        parent::__construct();
        $this->loadModel('Family');
    }

    public function index(){
        $items = $this->Family->all();
        $this->render('admin.families.index', compact('items'));
    }

    public function add(){
        if (!empty($_POST)) {
            $result = $this->Family->create([
                'name_family_EU' => $_POST['name_family_EU'],
                'name_family_FR' => $_POST['name_family_FR'],
                'name_family_GB' => $_POST['name_family_GB'],
                'name_family_DE' => $_POST['name_family_DE'],
                'name_family_IT' => $_POST['name_family_IT'],
                'name_family_ES' => $_POST['name_family_ES'],
                'name_family_SG' => $_POST['name_family_SG'],
                'name_family_AE' => $_POST['name_family_AE'],
                'name_family_AU' => $_POST['name_family_AU'],
            ]);
            return $this->index();
        }
        $form = new BootstrapForm($_POST);
        $this->render('admin.families.edit', compact('form'));
    }

    public function edit(){
        if (!empty($_POST)) {
            $result = $this->Family->update($_GET['id'], [
                'name_family_EU' => $_POST['name_family_EU'],
                'name_family_FR' => $_POST['name_family_FR'],
                'name_family_GB' => $_POST['name_family_GB'],
                'name_family_DE' => $_POST['name_family_DE'],
                'name_family_IT' => $_POST['name_family_IT'],
                'name_family_ES' => $_POST['name_family_ES'],
                'name_family_SG' => $_POST['name_family_SG'],
                'name_family_AE' => $_POST['name_family_AE'],
                'name_family_AU' => $_POST['name_family_AU'],
            ]);
            return $this->index();
        }
        $family = $this->Family->find($_GET['id']);
        $form = new BootstrapForm($family);
        $this->render('admin.families.edit', compact('form'));
    }

    public function delete(){
        if (!empty($_POST)) {
            $result = $this->Family->delete($_POST['id']);
            return $this->index();
        }
    }

}