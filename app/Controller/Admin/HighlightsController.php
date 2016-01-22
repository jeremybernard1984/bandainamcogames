<?php

namespace App\Controller\Admin;

use Core\HTML\BootstrapForm;
class HighlightsController extends AppController{

    public function __construct(){
        parent::__construct();
        // Je load les modeles VOIR dans le dossier table
        $this->loadModel('Highlight');
        $this->loadModel('Game');
        $this->loadModel('Image');
    }

    public function index(){
        $highlights = $this->Highlight->all();
        $this->render('admin.highlights.index', compact('highlights'));
    }
    /*
        public function add(){
            //var_dump($_POST);
            if (!empty($_POST)) {
                $result = $this->Highlight->create([
                    'game_id_join_1' => $_POST['game_id_join_1'],
                    'background_highlight_1' => $_POST['background_highlight_1'],
                    'game_id_join_2' => $_POST['game_id_join_2'],
                    'background_highlight_2' => $_POST['background_highlight_2'],
                    'game_id_join_3' => $_POST['game_id_join_3'],
                    'background_highlight_3' => $_POST['background_highlight_3'],
                ]);
                return $this->index();
                }
            $tableEncours = $this->Highlight->tableEncours();
            $lastId = $this->Highlight->lastId();
            $form = new BootstrapForm($_POST);
            $games = $this->Game->extract('id', 'title_game');
            $this->render('admin.highlightsdit', compact('games', 'form', 'lastId', 'tableEncours'));
        }
         */
    public function edit(){
        if (!empty($_POST)) {
            // Je test si le bouton suppression est check pour background
            if (isset($_POST['background_highlight_1_delete']) && $_POST['background_highlight_1_delete'] == true){
                $result = $this->Image->deleteImgCheck($_GET['id'], $_POST['background_highlight_1'], "highlights/backgrounds", "background_highlight_1");
            }
            if (isset($_POST['background_highlight_2_delete']) && $_POST['background_highlight_2_delete'] == true){
                $result = $this->Image->deleteImgCheck($_GET['id'], $_POST['background_highlight_2'], "highlights/backgrounds", "background_highlight_2");
            }
            if (isset($_POST['background_highlight_2_delete']) && $_POST['background_highlight_2_delete'] == true){
                $result = $this->Image->deleteImgCheck($_GET['id'], $_POST['background_highlight_2'], "highlights/backgrounds", "background_highlight_2");
            }
            //J'upload les images images du jeu avant d'enregistrer
            $result = $this->Image->uploadImg($_FILES,$_GET['id']);
            $result = $this->Highlight->update($_GET['id'], [
                'game_id_join_1' => $_POST['game_id_join_1'],
                'game_id_join_2' => $_POST['game_id_join_2'],
                'game_id_join_3' => $_POST['game_id_join_3'],
            ]);
            if($result){
                echo "<script language='JavaScript'>alert('Highlight(s) enregistrée(s)')</script>";
            }

        }
        $tableEncours = $this->Highlight->tableEncours();
        $highlight = $this->Highlight->find($_GET['id']);
        $games = $this->Game->extract('id', 'title_game');
        $form = new BootstrapForm($highlight);
        $langs="";
        $this->render('admin.highlights.edit', compact('langs', 'games','highlight', 'form', 'tableEncours' ));
    }

    public function delete(){
        if (!empty($_POST)) {
            $result = $this->Highlight->delete($_POST['id']);
            return $this->index();
        }


    }


}