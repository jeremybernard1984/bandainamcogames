<?php

namespace App\Controller\Admin;

use Core\HTML\BootstrapForm;
class NewsController extends AppController{

    public function __construct(){
        parent::__construct();
        // Je load les modeles VOIR dans le dossier table
        $this->loadModel('New');
        $this->loadModel('Image');
        $this->loadModel('Lang');
        $this->loadModel('Game');
        $this->loadModel('Videolink');
    }

    public function index(){
        $news = $this->New->allInUserLang();
        $this->render('admin.news.index', compact('news'));
    }


    public function add(){
        //var_dump($_POST);
        if (!empty($_POST)) {
            // si la date est entrer, je la format pour la base
            if (!empty($_POST['date_news'])){
                $date = str_replace('/', '-', $_POST['date_news']);
                $date_insert = date('Y-m-d H:i:s', strtotime($date));
            }
                $result = $this->New->create([
                    'title_news' => $_POST['title_news'],
                    'date_news' => $date_insert,
                    'resum_news' => $_POST['resum_news'],
                    'game_id_join' => $_POST['game_id_join'],
                    'description_news' => $_POST['description_news'],
                    'actif' => $_POST['actif'],
                    'lang' => $_SESSION['lang'],
                    'game_id_join' => $_POST['game_id_join']
                ]);
            // Je récupere l'id de la langue pour la transmettre aux tables liées
            $findLastIdNews = $this->New->findLastIdNews();
            foreach ($findLastIdNews as $idNewNews) {
                // Je vérifie si le Bt save est envoyé avant de rediriger vers l'index
                if($result AND !empty($_POST['BtSave'])){
                    //return $this->index();
                    header('Location: /namcobandai/public/index.php?p=admin.news.edit&id='.$idNewNews->id);
                }
            }
        }
        $tableEncours = $this->New->tableEncours();
        $lastId = $this->New->lastId();
        $langs = "";
        $allLangs = $this->Lang->extractAllLang('alpha2', 'nom_fr_fr');
        $games = $this->Game->extract('id', 'title_game');
        $form = new BootstrapForm($_POST);
        $this->render('admin.news.edit', compact('games', 'form', 'lastId', 'allLangs', 'langs', 'tableEncours'));
    }

    /**
     *
     */
    public function edit(){
        if (!empty($_POST)) {
            // si la date est entrer, je la format pour la base
            if (isset($_POST['date_news'])){
                $date = str_replace('/', '-', $_POST['date_news']);
                $date_insert = date('Y-m-d H:i:s', strtotime($date));
            }
            if (!empty($_POST['BtAllLang'])){
                foreach($_POST['ChoixLang'] AS $key => $value){
                    // J'enregistre la premiere langue
                    $result = $this->New->create([
                        'title_news' => $_POST['title_news'],
                        'date_news' => $date_insert,
                        'resum_news' => $_POST['resum_news'],
                        'description_news' => $_POST['description_news'],
                        'actif' => $_POST['actif'],
                        'game_id_join' => $_POST['game_id_join'],
                        'lang' => $value,
                        'id_group_lang' => $_GET['id']
                    ]);
                    // Je récupere l'id de la langue pour la transmettre aux tables liées
                    $findLastIdNews = $this->New->findLastIdNews();
                    foreach ($findLastIdNews as $idNewNews) {
                        // J'upload les infos des images si il y a des image. Je compte pour voir
                        if (isset($_POST['nbr'])) {
                            $nbr = $_POST['nbr'];
                            for ($i = 1; $i < $nbr + 1; $i++) {
                                $result = $this->Image->createImageNews([
                                    'id_news' => $idNewNews->id,
                                    'id_image' => $_POST['id_capture_' . $i],
                                    'title' => $_POST['title_capture_' . $i],
                                    'legend' => $_POST['legend_capture_' . $i],
                                ]);
                            }
                        }
                        // J'upload les infos des videos si il y a des videos. Je compte pour voir
                        if (isset($_POST['nbr1'])) {
                            $nbr = $_POST['nbr1'];
                            for ($i = 1; $i < $nbr + 1; $i++) {
                                $result = $this->Videolink->createVideoLinkNews([
                                    'id_news' => $idNewNews->id,
                                    'id_videolink' => $_POST['id_videolink_' . $i],
                                    'title' => $_POST['title_videolink_' . $i],
                                    'link' => $_POST['link_videolink_' . $i],
                                ]);
                            }
                        }
                    }
                }

                $result = $this->New->update($_GET['id'], [
                    'title_news' => $_POST['title_news'],
                    'date_news' => $date_insert,
                    'resum_news' => $_POST['resum_news'],
                    'description_news' => $_POST['description_news'],
                    'actif' => $_POST['actif'],
                    'game_id_join' => $_POST['game_id_join'],
                    'lang' => $_POST['lang'],
                    'id_group_lang' => $_GET['id']
                ]);
                // J'upload les infos des images
                if (!empty($_POST['nbr'])) {
                    $nbr = $_POST['nbr'];
                    for ($i = 1; $i < $nbr + 1; $i++) {
                        $result = $this->Image->updateImageNews($_GET['id'], $_POST['id_capture_' . $i], [
                            'id_image' => $_POST['id_capture_' . $i],
                            'title' => $_POST['title_capture_' . $i],
                            'legend' => $_POST['legend_capture_' . $i]
                        ]);
                    }
                }
                // J'upload les infos des videos
                if (!empty($_POST['nbr1'])) {
                    $nbr = $_POST['nbr1'];
                    for ($i = 1; $i < $nbr + 1; $i++) {
                        $result = $this->Videolink->updateVideoLinkNews($_GET['id'], $_POST['id_videolink_' . $i], [
                            'id_videolink' => $_POST['id_videolink_' . $i],
                            'title' => $_POST['title_videolink_' . $i],
                            'link' => $_POST['link_videolink_' . $i]
                        ]);
                    }
                }

            }else{
                $result = $this->New->update($_GET['id'], [
                    'title_news' => $_POST['title_news'],
                    'date_news' => $date_insert,
                    'resum_news' => $_POST['resum_news'],
                    'description_news' => $_POST['description_news'],
                    'actif' => $_POST['actif'],
                    'game_id_join' => $_POST['game_id_join'],
                ]);
                // J'upload les infos des images
                if (!empty($_POST['nbr'])) {
                    $nbr = $_POST['nbr'];

                    for ($i=1; $i <= $nbr; $i++) {

                        $result = $this->Image->updateImageNews($_GET['id'],$_POST['id_capture_'.$i], [
                            'id_image' => $_POST['id_capture_' . $i],
                            'title' => $_POST['title_capture_' . $i],
                            'legend' => $_POST['legend_capture_' . $i],
                        ]);
                    }
                }
                // J'upload les infos des videos
                if (!empty($_POST['nbr1'])) {
                    $nbr = $_POST['nbr1'];
                    $i=0;
                    for ($i=1; $i <= $nbr; $i++) {

                        $result = $this->Videolink->updateVideoLinkNews($_GET['id'],$_POST['id_videolink_'.$i], [
                            'id_videolink' => $_POST['id_videolink_' . $i],
                            'title' => $_POST['title_videolink_' . $i],
                            'link' => $_POST['link_videolink_' . $i],
                        ]);
                    }
                }
            }

            if($result){
                echo "<script language='JavaScript'>alert('article(s) enregistré(s)')</script>";
                // Si il y a un résultat je retourne à l'accueil
                //return $this->index();
            }

        }
        $tableEncours = $this->New->tableEncours();
        $new = $this->New->find($_GET['id']);
        $allLangs = $this->Lang->extractAllLang('alpha2', 'nom_fr_fr');
        $langs =$this->Lang->findAllLangToNews($new->id_group_lang);
        $imagesArt  = $this->Image->findAllImgToArt($_GET['id']);
        $games = $this->Game->extract('id', 'title_game');

        $form = new BootstrapForm($new);
        $this->render('admin.news.edit', compact('games', 'form', 'imagesArt', 'langs', 'allLangs','tableEncours','new' ));

    }

    public function delete(){
        if (!empty($_POST)) {

            $result = $this->New->delete($_POST['id']);
            $result = $this->Image->deleteImgJoin($_POST['id']);

            $dossier = "../public/images/news/";
            // Si je transmet les infos master Je supprime tous les jeux du group langue.
            if (isset($_GET['master']) && $_GET['master']=='EU') {

                $langs = $this->Lang->findAllLangToNews($_GET['group']);

                foreach($langs as $lang):
                    $result = $this->New->delete($lang->id);
                    $result = $this->Image->deleteImageNewsJoin($lang->id, $dossier.'images');
                    $result = $this->Videolink->deleteVideoLinkNewsJoin($lang->id, $dossier.'videoslinks');
                endforeach;
                $result = $this->New->delete($_POST['id']);
                $result = $this->Image->deleteImageNewsJoin($_POST['id'], $dossier.'images');
                $result = $this->Videolink->deleteVideoLinkNewsJoin($_POST['id'], $dossier.'videoslinks');
            }
            // Sinon je supprime juste la langue en question
            else{
                $result = $this->New->delete($_POST['id']);
                $result = $this->Image->deleteImageNewsJoin($_POST['id'], $dossier.'images');
                $result = $this->Videolink->deleteVideoLinkNewsJoin($_POST['id'], $dossier.'videoslinks');
            }
            return $this->index();
        }


    }


}