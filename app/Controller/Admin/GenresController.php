<?php

namespace App\Controller\Admin;

use Core\HTML\BootstrapForm;

class GenresController extends AppController{

    public function __construct(){
        parent::__construct();
        $this->loadModel('Genre');
    }

    public function index(){
        $items = $this->Genre->all();
        $this->render('admin.genres.index', compact('items'));
    }

    public function add(){
        if (!empty($_POST)) {
            $result = $this->Genre->create([
                'name_genre_EU' => $_POST['name_genre_EU'],
                'name_genre_FR' => $_POST['name_genre_FR'],
                'name_genre_GB' => $_POST['name_genre_GB'],
                'name_genre_DE' => $_POST['name_genre_DE'],
                'name_genre_IT' => $_POST['name_genre_IT'],
                'name_genre_ES' => $_POST['name_genre_ES'],
                'name_genre_SG' => $_POST['name_genre_SG'],
                'name_genre_AE' => $_POST['name_genre_AE'],
                'name_genre_AU' => $_POST['name_genre_AU'],
            ]);
            return $this->index();
        }
        $form = new BootstrapForm($_POST);
        $this->render('admin.genres.edit', compact('form'));
    }

    public function edit(){
        if (!empty($_POST)) {
            $result = $this->Genre->update($_GET['id'], [
                'name_genre_EU' => $_POST['name_genre_EU'],
                'name_genre_FR' => $_POST['name_genre_FR'],
                'name_genre_GB' => $_POST['name_genre_GB'],
                'name_genre_DE' => $_POST['name_genre_DE'],
                'name_genre_IT' => $_POST['name_genre_IT'],
                'name_genre_ES' => $_POST['name_genre_ES'],
                'name_genre_SG' => $_POST['name_genre_SG'],
                'name_genre_AE' => $_POST['name_genre_AE'],
                'name_genre_AU' => $_POST['name_genre_AU'],
            ]);
            return $this->index();
        }
        $genre = $this->Genre->find($_GET['id']);
        $form = new BootstrapForm($genre);
        $this->render('admin.genres.edit', compact('form'));
    }

    public function delete(){
        if (!empty($_POST)) {
            $result = $this->Genre->delete($_POST['id']);
            return $this->index();
        }
    }

}