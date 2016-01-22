<?php

namespace App\Controller\Admin;

use Core\HTML\BootstrapForm;
class GamesController extends AppController{

    protected $tableEncours = 'games';

    public function __construct(){
        parent::__construct();
        // Je load les modeles VOIR dans le dossier table
        $this->loadModel('Game');
        $this->loadModel('Capture');
        $this->loadModel('Download');
        $this->loadModel('Classification');
        $this->loadModel('Videolink');
        $this->loadModel('Lang');
        $this->loadModel('Category');
        $this->loadModel('Developer');
        $this->loadModel('Family');
        $this->loadModel('Genre');
        $this->loadModel('Publisher');
        $this->loadModel('Platform');
        $this->loadModel('Image');
    }

    public function index(){
        $games = $this->Game->all();
        //$langs = $this->Lang->findAllLangToGames($games->id_group_lang);
        $this->render('admin.games.index', compact('games','langs'));
    }


    public function add(){
        if (!empty($_POST) AND !empty($_POST['ChoixPlatform'])) {
            if ( $_POST['numbers_gamers_game'] == null) {$numberGamers = 1;}else{ $numberGamers = $_POST['numbers_gamers_game'];}
            $result = $this->Game->create([
                'title_game' => $_POST['title_game'],
                'description_game' => $_POST['description_game'],
                'actif' => $_POST['actif'],
                'lang' => $_POST['lang'],
                'id_genre' => $_POST['id_genre'],
                'id_family' => $_POST['id_family'],
                'id_publisher' => $_POST['id_publisher'],
                'id_developer' => $_POST['id_developer'],
                'link_website_game' => $_POST['link_website_game'],
                'link_facebook_game' => $_POST['link_facebook_game'],
                'numbers_gamers_game' => $numberGamers,
                'copyright_game' => $_POST['copyright_game'],
                //'copyright_logo_game' => $_POST['copyright_logo_game'],
                //'banner_game' => $_POST['banner_game'],
            ]);
            // Je récupere l'id de la langue pour la transmettre aux tables liées
            $findLastIdGame = $this->Game->findLastIdGame();


            foreach ($findLastIdGame as $idNewGame) {

                // Je créé la les tables jointes de classification
                $result = $this->Classification->createClassifications($idNewGame->id);

                foreach ($_POST['ChoixPlatform'] AS $key => $value) {
                    $result = $this->Platform->createPlatform([
                        'id_game' => $idNewGame->id,
                        'id_platform' => $value,
                    ]);
                }
                //J'upload les images du jeu avec l'id de la fiche créer au dessus... update des infos
                $result = $this->Image->uploadImg($_FILES,$idNewGame->id);
                // Je redirige vers la page edit pour gerer la suite
                header('Location: /bandainamco/public/index.php?p=admin.games.edit&id='.$idNewGame->id);
            }
        }else{
            $platformsCheck = "";
        }
        $tableEncours = $this->Game->tableEncours();
        $lastId = $this->Game->lastId();
        $allLangs = $this->Lang->extractAllLang('alpha2', 'nom_fr_fr');
        $langs = "";
        $allPlatforms = $this->Platform->extractAllPlatform('id', 'name_platform_EU');
        $platforms = "";
        $categories = $this->Category->extract('id', 'titre');
        $developers = $this->Developer->extract('id', 'name_developer_EU');
        $families = $this->Family->extract('id', 'name_family_EU');
        $genres = $this->Genre->extract('id', 'name_genre_EU');
        $publishers = $this->Publisher->extract('id', 'name_publisher_EU');

        $form = new BootstrapForm($_POST);
        $this->render('admin.games.edit', compact('categories','developers','families','genres','publishers', 'form', 'lastId', 'allLangs','langs', 'allPlatforms','platforms','platformsCheck', 'tableEncours'));
    }


    public function edit(){
        //var_dump($_POST);
        if (!empty($_POST) AND !empty($_POST['ChoixPlatform'])) {
            // recuperation des infos des platforms et transformation en tableau pour vérifier si on match ou pas
            $my_var = [];
            $test_platform_exist = (array)$this->Platform->findPlatformCheck($_GET['id']);
            $choix_platform = $_POST['ChoixPlatform'];
            if (isset($test_platform_exist)) {
                foreach ($test_platform_exist as $opt) {
                    array_push($my_var, $opt->id_platform);
                }
            }
            $test_match = array_intersect_assoc($choix_platform, $my_var);
            $test_dif = array_diff($choix_platform, $my_var);
            //print_r($test_dif);
            //print_r($test_match);
            // Si l'envoi est fait pour TOUTES les langues, on utilise cette partie
            //print_r($_POST);
            if (!empty($_POST['BtAllLang'])) {

                // Je vérifie que j'ai bien sélectionner des langues
                if (!empty($_POST['ChoixLang'])){
                    foreach ($_POST['ChoixLang'] AS $key => $value) {
                        // J'enregistre les langues avec les infos de langue EU
                        $result = $this->Game->create([
                            'title_game' => $_POST['title_game'],
                            'description_game' => $_POST['description_game'],
                            'actif' => $_POST['actif'],
                            'lang' => $value,
                            'id_group_lang' => $_GET['id'],
                            'id_genre' => $_POST['id_genre'],
                            'id_family' => $_POST['id_family'],
                            'id_publisher' => $_POST['id_publisher'],
                            'id_developer' => $_POST['id_developer'],
                            'link_website_game' => $_POST['link_website_game'],
                            'link_facebook_game' => $_POST['link_facebook_game'],
                            'numbers_gamers_game' => $_POST['numbers_gamers_game'],
                            'copyright_game' => $_POST['copyright_game'],
                            // Ici je récupere les images de langue europe a modifier plus tard... ou pas
                            'copyright_logo_game' => $_POST['copyright_logo_game'],
                            'banner_game' => $_POST['banner_game'],
                        ]);
                        // Je récupere l'id de la langue pour la transmettre aux tables liées
                        $findLastIdGame = $this->Game->findLastIdGame();
                        foreach ($findLastIdGame as $idNewGame) {
                            // Je créé les platformes pour chaques langues
                            //$result = $this->Platform->deletePlatformJoin($_GET['id']);
                            foreach ($_POST['ChoixPlatform'] AS $key2 => $value2) {
                                $result = $this->Platform->createPlatform([
                                    'id_game' => $idNewGame->id,
                                    'id_platform' => $value2,
                                    'cover_game' => $_POST['cover_game_' . $value2],
                                    'release_date_game' => date('Y-m-d H:i:s', strtotime(str_replace('/', '-', $_POST['release_date_game_' . $value2]))),
                                    'informations_game' => $_POST['informations_game_' . $value2],
                                    'characteristics_game' => $_POST['characteristics_game_' . $value2],
                                    'download_link_game' => $_POST['download_link_game_' . $value2],
                                ]);
                            }
                            // J'upload les infos des images si il y a des image. Je compte pour voir
                            if (isset($_POST['nbr'])) {
                                $nbr = $_POST['nbr'];
                                for ($i = 1; $i < $nbr + 1; $i++) {
                                    $result = $this->Capture->createCapt([
                                        'id_game' => $idNewGame->id,
                                        'id_capture' => $_POST['id_capture_' . $i],
                                        'title' => $_POST['title_capture_' . $i],
                                        'legend' => $_POST['legend_capture_' . $i],
                                    ]);
                                }
                            }
                            // J'upload les infos des videos si il y a des videos. Je compte pour voir
                            if (isset($_POST['nbr1'])) {
                                $nbr = $_POST['nbr1'];
                                for ($i = 1; $i < $nbr + 1; $i++) {
                                    $result = $this->Videolink->createVideoLink([
                                        'id_game' => $idNewGame->id,
                                        'id_videolink' => $_POST['id_videolink_' . $i],
                                        'title' => $_POST['title_videolink_' . $i],
                                        'link' => $_POST['link_videolink_' . $i],
                                    ]);
                                }
                            }
                            // Je créé la les tables jointes de classification
                            if (isset($_POST['nbr3'])) {
                                $nbr = $_POST['nbr3'];
                                for ($i = 1; $i < $nbr + 1; $i++) {
                                    $result = $this->Classification->createClassificationsLang($idNewGame->id,$i);
                                }
                            }
                            // J'upload les infos des téléchargements si il y en a
                            if (isset($_POST['nbr4'])) {
                                $nbr = $_POST['nbr4'];
                                for ($i = 1; $i < $nbr + 1; $i++) {
                                    $result = $this->Download->createDownload([
                                        'id_game' => $idNewGame->id,
                                        'id_download' => $_POST['id_download_' . $i],
                                        'title' => $_POST['title_download_' . $i],
                                        'link' => $_POST['link_download_' . $i],
                                    ]);
                                }
                            }
                        }
                    }
                    // APRES ENREGISTREMENT DANS LES LANGUES, J'UPDATE LA LANGUE EU
                    $result = $this->Game->update($_GET['id'], [
                        'title_game' => $_POST['title_game'],
                        'description_game' => $_POST['description_game'],
                        'actif' => $_POST['actif'],
                        'lang' => $_POST['lang'],
                        'id_group_lang' => $_GET['id'],
                        'category_id' => $_POST['category_id'],
                        'id_genre' => $_POST['id_genre'],
                        'id_family' => $_POST['id_family'],
                        'id_publisher' => $_POST['id_publisher'],
                        'id_developer' => $_POST['id_developer'],
                        'link_website_game' => $_POST['link_website_game'],
                        'link_facebook_game' => $_POST['link_facebook_game'],
                        'numbers_gamers_game' => $_POST['numbers_gamers_game'],
                        'copyright_game' => $_POST['copyright_game'],
                        'copyright_logo_game' => $_POST['copyright_logo_game'],
                        'banner_game' => $_POST['banner_game'],
                    ]);

                    //Si il y a des differences avec les infos de la base je retourne le tableau test dif et je créé
                    if (!empty($test_dif)) {
                        foreach ($test_dif AS $key => $value) {
                            $result = $this->Platform->createPlatform([
                                'id_game' => $_GET['id'],
                                'id_platform' => $value,
                            ]);
                        }
                    }
                    //Sinon j'update les infos identiques
                    if (!empty($test_match)) {
                        foreach ($test_match AS $key => $value) {
                            $result = $this->Platform->updatePlatform($_GET['id'], $value, [
                                'id_game' => $_GET['id'],
                                'id_platform' => $value,
                                'cover_game' => $_POST['cover_game_' . $value],
                                'release_date_game' => date('Y-m-d H:i:s', strtotime(str_replace('/', '-', $_POST['release_date_game_' . $value]))),
                                'informations_game' => $_POST['informations_game_' . $value],
                                'characteristics_game' => $_POST['characteristics_game_' . $value],
                                'download_link_game' => $_POST['download_link_game_' . $value],
                            ]);
                        }
                    }
                    // J'upload les infos des images
                    if (!empty($_POST['nbr'])) {
                        $nbr = $_POST['nbr'];
                        for ($i = 1; $i < $nbr + 1; $i++) {
                            $result = $this->Capture->updateCapt($_GET['id'], $_POST['id_capture_' . $i], [
                                'id_capture' => $_POST['id_capture_' . $i],
                                'title' => $_POST['title_capture_' . $i],
                                'legend' => $_POST['legend_capture_' . $i]
                            ]);
                        }
                    }
                    // J'upload les infos des videos
                    if (!empty($_POST['nbr1'])) {
                        $nbr = $_POST['nbr1'];
                        for ($i = 1; $i < $nbr + 1; $i++) {
                            $result = $this->Videolink->updateVideoLink($_GET['id'], $_POST['id_videolink_' . $i], [
                                'id_videolink' => $_POST['id_videolink_' . $i],
                                'title' => $_POST['title_videolink_' . $i],
                                'link' => $_POST['link_videolink_' . $i]
                            ]);
                        }
                    }
                    // classifications
                    if (!empty($_POST['nbr3'])) {
                        $nbr = $_POST['nbr3'];
                        for ($i = 1; $i < $nbr + 1; $i++) {
                            $result = $this->Classification->UpdateClassifications($_GET['id'], $_POST['id_classification' . $i],$_POST['check_classification' . $i]);
                        }
                    }
                    // J'upload les infos des téléchargements
                    if (!empty($_POST['nbr4'])) {
                        $nbr = $_POST['nbr4'];
                        for ($i = 1; $i < $nbr + 1; $i++) {
                            $result = $this->Download->updateDownload($_GET['id'], $_POST['id_download_' . $i], [
                                'id_download' => $_POST['id_download_' . $i],
                                'title' => $_POST['title_download_' . $i],
                                'link' => $_POST['link_download_' . $i]
                            ]);
                        }
                    }
                }else {echo "<script language='JavaScript'>alert('ATTENTION ! Sélectionner une ou plusieurs langues')</script>";}
            }

            // Si l'envoi est fait pour une seule langue, on utilise cette partie
            else{
                //print_r($_POST);
                // Je test si le bouton suppression est check
                if (isset($_POST['copyright_logo_game_delete']) && $_POST['copyright_logo_game_delete'] == true){
                    $result = $this->Image->deleteImgCheck($_GET['id'], $_POST['copyright_logo_game'], "copyrights", "copyright_logo_game");
                }
                if (isset($_POST['banner_game_delete']) && $_POST['banner_game_delete'] == true){
                    $result = $this->Image->deleteImgCheck($_GET['id'], $_POST['banner_game'], "banners", "banner_game");
                }
                //J'upload les images images du jeu avant d'enregistrer
                $result = $this->Image->uploadImg($_FILES,$_GET['id']);
                $result = $this->Game->update($_GET['id'], [
                    'title_game' => $_POST['title_game'],
                    'description_game' => $_POST['description_game'],
                    'actif' => $_POST['actif'],
                    //'id_group_lang' => $_GET['id'],
                    'category_id' => $_POST['category_id'],
                    'id_genre' => $_POST['id_genre'],
                    'id_family' => $_POST['id_family'],
                    'id_publisher' => $_POST['id_publisher'],
                    'id_developer' => $_POST['id_developer'],
                    'link_website_game' => $_POST['link_website_game'],
                    'link_facebook_game' => $_POST['link_facebook_game'],
                    'numbers_gamers_game' => $_POST['numbers_gamers_game'],
                    'copyright_game' => $_POST['copyright_game'],
                    //'copyright_logo_game' => $_POST['copyright_logo_game'],
                    //'banner_game' => $_POST['banner_game'],
                ]);

                //Si il y a des differences avec les infos de la base je retourne le tableau test dif et je créé
                if (!empty($test_dif)){
                    foreach($test_dif AS $key => $value) {
                        $result = $this->Platform->createPlatform([
                            'id_game' => $_GET['id'],
                            'id_platform' => $value,
                        ]);
                    }
                }
                //Sinon j'update les infos identiques
                //print_r($_POST);
                if (!empty($test_match)) {
                    foreach ($test_match AS $key => $value) {
                        $result = $this->Platform->updatePlatform($_GET['id'],$value, [
                            'id_game' => $_GET['id'],
                            'id_platform' => $value,
                            'cover_game' => $_POST['cover_game_' .$value],
                            'release_date_game' =>  date('Y-m-d H:i:s', strtotime(str_replace('/', '-', $_POST['release_date_game_' .$value]))),
                            'informations_game' => $_POST['informations_game_' .$value],
                            'characteristics_game' => $_POST['characteristics_game_' .$value],
                            'download_link_game' => $_POST['download_link_game_' .$value],
                        ]);
                    }
                }
                // J'upload les infos des images
                if (!empty($_POST['nbr'])) {
                    $nbr = $_POST['nbr'];

                    for ($i=1; $i <= $nbr; $i++) {

                        $result = $this->Capture->updateCapt($_GET['id'],$_POST['id_capture_'.$i], [
                            'id_capture' => $_POST['id_capture_' . $i],
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

                        $result = $this->Videolink->updateVideoLink($_GET['id'],$_POST['id_videolink_'.$i], [
                            'id_videolink' => $_POST['id_videolink_' . $i],
                            'title' => $_POST['title_videolink_' . $i],
                            'link' => $_POST['link_videolink_' . $i],
                        ]);
                    }
                }
                // classifications
                if (!empty($_POST['nbr3'])) {
                    $nbr = $_POST['nbr3'];
                    $i=0;
                    for ($i = 1; $i < $nbr + 1; $i++) {
                        $result = $this->Classification->UpdateClassifications($_GET['id'], $_POST['id_classification' . $i],$_POST['check_classification' . $i]);
                    }
                }
                // J'upload les infos des videos
                if (!empty($_POST['nbr4'])) {
                    $nbr = $_POST['nbr4'];
                    $i=0;
                    for ($i=1; $i<$nbr+1; $i++) {

                        $result = $this->Download->updateDownload($_GET['id'],$_POST['id_download_'.$i], [
                            'id_download' => $_POST['id_download_' . $i],
                            'title' => $_POST['title_download_' . $i],
                            'link' => $_POST['link_download_' . $i],
                        ]);
                    }
                }
            }
            if(isset($result)){

                echo "<script language='JavaScript'>alert('jeu(x) enregistré(s)')</script>";
                // Si il y a un résultat je retourne à l'accueil
                //return $this->index();
            }
        }
        $tableEncours = $this->Game->tableEncours();

        $game = $this->Game->find($_GET['id']);


        $allLangs = $this->Lang->extractAllLang('alpha2', 'nom_fr_fr');
        $langs = $this->Lang->findAllLangToGames($game->id_group_lang);

        $allPlatforms = $this->Platform->extractAllPlatform('id', 'name_platform_EU');
        $platforms = $this->Platform->findAllPlatformToGame($game->id);
        $platformsCheck = $this->Platform->findPlatformCheck($game->id);

        $capturesGame = $this->Capture->findAllCaptToGame($_GET['id']);

        $categories = $this->Category->extract('id', 'titre');
        $developers = $this->Developer->extract('id', 'name_developer_EU');
        $families = $this->Family->extract('id', 'name_family_EU');
        $genres = $this->Genre->extract('id', 'name_genre_EU');
        $publishers = $this->Publisher->extract('id', 'name_publisher_EU');

        $form = new BootstrapForm($game);
        $this->render('admin.games.edit', compact('game','categories','developers','genres','families','publishers', 'form', 'capturesGame', 'langs', 'allLangs','allPlatforms','platforms','platformsCheck','tableEncours','findLastIdGame' ));

    }
    public function delete(){
        if (!empty($_POST)) {
            $dossier = "../public/images/games/";
            // Si je transmet les infos master Je supprime tous les jeux du group langue.
            if (isset($_GET['master']) && $_GET['master']=='EU') {
                $langs = $this->Lang->findAllLangToGames($_GET['group']);
                foreach($langs as $lang):
                    $result = $this->Game->deleteGame($lang->id, $dossier.'Copyrights', $dossier.'banners');
                    $result = $this->Capture->deleteCaptJoin($lang->id, $dossier.'captures');
                    $result = $this->Download->deleteDownloadJoin($lang->id, $dossier.'downloads');
                    $result = $this->Platform->deletePlatformJoin($lang->id, $dossier.'covers');
                    $result = $this->Videolink->deleteVideoLinkJoin($lang->id, $dossier.'videoslinks');
                    $result = $this->Classification->deleteClassificationJoin($lang->id);
                endforeach;
                $result = $this->Game->deleteGame($_POST['id'], $dossier.'Copyrights', $dossier.'banners');
                $result = $this->Capture->deleteCaptJoin($_POST['id'], $dossier.'captures');
                $result = $this->Download->deleteDownloadJoin($_POST['id'], $dossier.'downloads');
                $result = $this->Platform->deletePlatformJoin($_POST['id'], $dossier.'covers');
                $result = $this->Videolink->deleteVideoLinkJoin($_POST['id'], $dossier.'videoslinks');
                $result = $this->Classification->deleteClassificationJoin($_POST['id']);
            }
            // Sinon je supprime juste la langue en question
            else{
                $result = $this->Game->deleteGame($_POST['id'], $dossier.'Copyrights', $dossier.'banners');
                $result = $this->Capture->deleteCaptJoin($_POST['id'], $dossier.'captures');
                $result = $this->Download->deleteDownloadJoin($_POST['id'], $dossier.'downloads');
                $result = $this->Platform->deletePlatformJoin($_POST['id'], $dossier.'covers');
                $result = $this->Videolink->deleteVideoLinkJoin($_POST['id'], $dossier.'videoslinks');
                $result = $this->Classification->deleteClassificationJoin($_POST['id']);
            }
            return $this->index();
        }
    }
}