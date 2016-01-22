<?php

namespace App\Controller\Admin;

use Core\HTML\BootstrapForm;

class PublishersController extends AppController{

    public function __construct(){
        parent::__construct();
        $this->loadModel('publisher');
    }

    public function index(){
        $items = $this->publisher->all();
        $this->render('admin.publishers.index', compact('items'));
    }

    public function add(){
        if (!empty($_POST)) {
            $result = $this->publisher->create([
                'name_publisher_EU' => $_POST['name_publisher_EU'],
                'name_publisher_FR' => $_POST['name_publisher_FR'],
                'name_publisher_GB' => $_POST['name_publisher_GB'],
                'name_publisher_DE' => $_POST['name_publisher_DE'],
                'name_publisher_IT' => $_POST['name_publisher_IT'],
                'name_publisher_ES' => $_POST['name_publisher_ES'],
                'name_publisher_SG' => $_POST['name_publisher_SG'],
                'name_publisher_AE' => $_POST['name_publisher_AE'],
                'name_publisher_AU' => $_POST['name_publisher_AU'],
            ]);
            return $this->index();
        }
        $form = new BootstrapForm($_POST);
        $this->render('admin.publishers.edit', compact('form'));
    }

    public function edit(){
        if (!empty($_POST)) {
            $result = $this->publisher->update($_GET['id'], [
                'name_publisher_EU' => $_POST['name_publisher_EU'],
                'name_publisher_FR' => $_POST['name_publisher_FR'],
                'name_publisher_GB' => $_POST['name_publisher_GB'],
                'name_publisher_DE' => $_POST['name_publisher_DE'],
                'name_publisher_IT' => $_POST['name_publisher_IT'],
                'name_publisher_ES' => $_POST['name_publisher_ES'],
                'name_publisher_SG' => $_POST['name_publisher_SG'],
                'name_publisher_AE' => $_POST['name_publisher_AE'],
                'name_publisher_AU' => $_POST['name_publisher_AU'],
            ]);
            return $this->index();
        }
        $publisher = $this->publisher->find($_GET['id']);
        $form = new BootstrapForm($publisher);
        $this->render('admin.publishers.edit', compact('form'));
    }

    public function delete(){
        if (!empty($_POST)) {
            $result = $this->publisher->delete($_POST['id']);
            return $this->index();
        }
    }

}