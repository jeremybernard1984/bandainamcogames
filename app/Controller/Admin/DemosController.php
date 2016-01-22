<?php

namespace App\Controller\Admin;

use Core\HTML\BootstrapForm;
class DemosController extends AppController{

    public function __construct(){
        parent::__construct();
        // Je load les modeles VOIR dans le dossier table
        $this->loadModel('Demo');
        $this->loadModel('Image');
        $this->loadModel('Lang');
        $this->loadModel('Game');
    }

    public function index(){
        $demos = $this->Demo->allInUserLang();
        $this->render('admin.demos.index', compact('demos'));
    }


    public function add(){
        //var_dump($_POST);
        if (!empty($_POST)) {
            // si la date est entrer, je la format pour la base
            if (!empty($_POST['date_demo'])){
                $date = str_replace('/', '-', $_POST['date_demo']);
                $date_insert = date('Y-m-d H:i:s', strtotime($date));
            }

            $result = $this->Demo->create([
                    'title_demo' => $_POST['title_demo'],
                    'subtitle_demo' => $_POST['subtitle_demo'],
                    'date_demo' => $date_insert,
                    'game_id_join' => $_POST['game_id_join'],
                    'background_demo' => $_POST['background_demo'],
                    'video_demo' => $_POST['video_demo'],
                    'website_link_demo' => $_POST['website_link_demo'],
                    'apple_store_link_demo' => $_POST['apple_store_link_demo'],
                    'google_play_store_link_demo' => $_POST['google_play_store_link_demo'],
                    'amazon_link_demo' => $_POST['amazon_link_demo'],
                    'web_link_demo' => $_POST['web_link_demo'],
                    'actif' => $_POST['actif'],
                    'lang' => $_POST['lang'],

                ]);
            // Je récupere l'id de la langue pour la transmettre aux tables liées
            $findLastIdDemos = $this->Demo->findLastIdDemos();
            foreach ($findLastIdDemos as $idNewDemo) {
                //J'upload les images images du jeu avant d'enregistrer
                $result = $this->Image->uploadImg($_FILES,$idNewDemo->id);
                // Je vérifie si le Bt save est envoyé avant de rediriger vers l'index
                if($result AND !empty($_POST['BtSave'])){
                    //return $this->index();
                    header('Location: /bandainamco/public/index.php?p=admin.demos.edit&id='.$idNewDemo->id);
                }
            }
        }
        $tableEncours = $this->Demo->tableEncours();
        $lastId = $this->Demo->lastId();
        $allLangs = $this->Lang->extractAllLang('alpha2', 'nom_fr_fr');
        $langs = "";
        $games = $this->Game->extract('id', 'title_game');
        $form = new BootstrapForm($_POST);
        $this->render('admin.demos.edit', compact('games', 'langs', 'form', 'lastId', 'allLangs', 'tableEncours'));

    }

    /**
     *
     */
    public function edit(){
        if (!empty($_POST)) {
            // si la date est entrer, je la format pour la base
            if (isset($_POST['date_demo'])){
                $date = str_replace('/', '-', $_POST['date_demo']);
                $date_insert = date('Y-m-d H:i:s', strtotime($date));
            }
            if (!empty($_POST['BtAllLang'])){
                foreach($_POST['ChoixLang'] AS $key => $value){
                    // J'enregistre la premiere langue
                    $result = $this->Demo->create([
                        'title_demo' => $_POST['title_demo'],
                        'subtitle_demo' => $_POST['subtitle_demo'],
                        'date_demo' => $date_insert,
                        'game_id_join' => $_POST['game_id_join'],
                        'background_demo' => $_POST['background_demo'],
                        'video_demo' => $_POST['video_demo'],
                        'website_link_demo' => $_POST['website_link_demo'],
                        'apple_store_link_demo' => $_POST['apple_store_link_demo'],
                        'google_play_store_link_demo' => $_POST['google_play_store_link_demo'],
                        'amazon_link_demo' => $_POST['amazon_link_demo'],
                        'web_link_demo' => $_POST['web_link_demo'],
                        'actif' => $_POST['actif'],
                        'lang' => $value,
                        'id_group_lang' => $_GET['id']
                    ]);
                    // Je récupere l'id de la langue pour la transmettre aux tables liées
                    /*$findLastIdDemos = $this->Demo->findLastIdDemos();
                    foreach ($findLastIdDemos as $idNewDemos) {
                        //J'upload les images images du jeu avant d'enregistrer
                        $result = $this->Image->uploadImg($_FILES,$idNewDemos->id);
                    }*/

                }
                $result = $this->Demo->update($_GET['id'], [
                    'title_demo' => $_POST['title_demo'],
                    'subtitle_demo' => $_POST['subtitle_demo'],
                    'date_demo' => $date_insert,
                    'game_id_join' => $_POST['game_id_join'],
                    //'background_demo' => $_POST['background_demo'],
                    'video_demo' => $_POST['video_demo'],
                    'website_link_demo' => $_POST['website_link_demo'],
                    'apple_store_link_demo' => $_POST['apple_store_link_demo'],
                    'google_play_store_link_demo' => $_POST['google_play_store_link_demo'],
                    'amazon_link_demo' => $_POST['amazon_link_demo'],
                    'web_link_demo' => $_POST['web_link_demo'],
                    'id_group_lang' => $_GET['id']
                ]);

            }else{
                // Je test si le bouton suppression est check pour background
                if (isset($_POST['background_demo_delete']) && $_POST['background_demo_delete'] == true){
                    $result = $this->Image->deleteImgCheck($_GET['id'], $_POST['background_demo'], "demos/backgrounds", "background_demo");
                }
                //J'upload les images images du jeu avant d'enregistrer
                $result = $this->Image->uploadImg($_FILES,$_GET['id']);
                $result = $this->Demo->update($_GET['id'], [
                    'title_demo' => $_POST['title_demo'],
                    'subtitle_demo' => $_POST['subtitle_demo'],
                    'date_demo' => $date_insert,
                    'game_id_join' => $_POST['game_id_join'],
                    //'background_demo' => $_POST['background_demo'],
                    'video_demo' => $_POST['video_demo'],
                    'website_link_demo' => $_POST['website_link_demo'],
                    'apple_store_link_demo' => $_POST['apple_store_link_demo'],
                    'google_play_store_link_demo' => $_POST['google_play_store_link_demo'],
                    'amazon_link_demo' => $_POST['amazon_link_demo'],
                    'web_link_demo' => $_POST['web_link_demo'],
                ]);
            }
            if($result){
                echo "<script language='JavaScript'>alert('Page(s) enregistrée(s)')</script>";
            }

        }
        $tableEncours = $this->Demo->tableEncours();
        $demo = $this->Demo->find($_GET['id']);
        $allLangs = $this->Lang->extractAllLang('alpha2', 'nom_fr_fr');
        $langs =$this->Lang->findAllLangToDemos($demo->id_group_lang);
        $games = $this->Game->extract('id', 'title_game');
        $form = new BootstrapForm($demo);
        $this->render('admin.demos.edit', compact('games', 'form', 'demo', 'langs', 'allLangs','tableEncours' ));
    }

    public function delete(){
        if (!empty($_POST)) {
            $dossier = "../public/images/demos/";
            // Si je transmet les infos master Je supprime tous les jeux du group langue.
            if (isset($_GET['master']) && $_GET['master']=='EU') {
                $langs = $this->Lang->findAllLangToDemos($_GET['group']);
                foreach($langs as $lang):
                    $result = $this->Demo->deleteDemo($lang->id, $dossier.'backgrounds');
                endforeach;
                $result = $this->Demo->deleteDemo($_POST['id'], $dossier.'backgrounds');
            }
            // Sinon je supprime juste la langue en question
            else{
                $result = $this->Demo->deleteDemo($_POST['id'], $dossier.'backgrounds');
            }
            return $this->index();
        }
    }


}