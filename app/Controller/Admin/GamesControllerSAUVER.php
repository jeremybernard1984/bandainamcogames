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
        $this->loadModel('Lang');
        $this->loadModel('Category');
        $this->loadModel('Developer');
        $this->loadModel('Family');
        $this->loadModel('Genre');
        $this->loadModel('Publisher');
        $this->loadModel('Platform');
    }

    public function index(){
        $games = $this->Game->all();
        $this->render('admin.games.index', compact('games'));
    }


    public function add(){
            if (!empty($_POST) AND !empty($_POST['ChoixPlatform'])) {
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
                    'numbers_gamers_game' => $_POST['numbers_gamers_game'],
                    'copyright_game' => $_POST['copyright_game'],
                    'copyright_logo_game' => $_POST['copyright_logo_game'],
                    'banner_game' => $_POST['banner_game'],
                ]);
                foreach($_POST['ChoixPlatform'] AS $key => $value){

                    $result = $this->Platform->createPlatform([
                     //'id_game' => $lastId1,
                     'id_platform' => $value,
                     
                    ]);
                    //Je précise que je connais les platformes checkées
                    $platformsCheck = $this->Platform->findPlatformCheckCreate();
                }
                // Je vérifie si le Bt save est envoyé avant de rediriger vers l'index
                if($result AND !empty($_POST['BtSave'])){
                    return $this->edit();
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
        //

        //$platformsCheckCreate = $this->Platform->findPlatformCheckCreate();


        $categories = $this->Category->extract('id', 'titre');
        $developers = $this->Developer->extract('id', 'name_developer_EU');
        $families = $this->Family->extract('id', 'name_family_EU');
        $genres = $this->Genre->extract('id', 'name_genre_EU');
        $publishers = $this->Publisher->extract('id', 'name_publisher_EU');

        $form = new BootstrapForm($_POST);
        $this->render('admin.games.edit', compact('categories','developers','families','genres','publishers', 'form', 'lastId', 'allLangs','langs', 'allPlatforms','platforms','platformsCheck', 'tableEncours'));
    }

    /**
     *
     */
    public function edit(){
        //var_dump($_POST);
        if (!empty($_POST) AND !empty($_POST['ChoixPlatform'])) {
            if (!empty($_POST['BtAllLang'])){
                    foreach($_POST['ChoixLang'] AS $key => $value){
                        // J'enregistre la premiere langue
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
                            'copyright_logo_game' => $_POST['copyright_logo_game'],
                            'banner_game' => $_POST['banner_game'],
                    ]);
                        // Je verifie que la platform existe deja


                    //$result = $this->Platform->deletePlatformJoin($_GET['id']);
                    foreach($_POST['ChoixPlatform'] AS $key2 => $value2){
                         $test_platform_exist = $this->Platform->findPlatform($_GET['id'],$value2);
                        var_dump($test_platform_exist);die;
                         $result = $this->Platform->createPlatform([
                         //'id_game' => $lastId1,
                         'id_platform' => $value2,
                        ]);

                    }
                    // J'upload les infos des images si il y a des image. Je compte pour voir
                    if (isset($_POST['nbr'])) {
                        $nbr = $_POST['nbr'];
                        for ($i = 1; $i < $nbr + 1; $i++) {
                            $result = $this->Capture->createCapt([
                                //'id_article' => $lastId1,
                                'id_capture' => $_POST['id_capture_' . $i],
                                'title' => $_POST['title_capture_' . $i],
                                'legend' => $_POST['legend_capture_' . $i],
                            ]);
                        }
                    }
                }
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
                $result = $this->Platform->deletePlatformJoin($_GET['id']);
                foreach($_POST['ChoixPlatform'] AS $key => $value){
                    $test_platform_exist = $this->Platform->findPlatform($_GET['id'],$value);
                    var_dump($test_platform_exist);
                    $result = $this->Platform->createPlatform([
                        'id_game' => $_GET['id'],
                        'id_platform' => $value,
                    ]);
                }
                // J'upload les infos des images
                if (!empty($_POST['nbr'])) {
                    $nbr = $_POST['nbr'];
                    for ($i=1; $i<$nbr+1; $i++) {
                        $result = $this->Capture->updateCapt($_GET['id'],$_POST['id_capture_'.$i], [
                            'id_capture' => $_POST['id_capture_' . $i],
                            'title' => $_POST['title_capture_' . $i],
                            'legend' => $_POST['legend_capture_' . $i]
                        ]);
                    }
                }

            }else{
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
                    'copyright_logo_game' => $_POST['copyright_logo_game'],
                    'banner_game' => $_POST['banner_game'],
                ]);
                //var_dump($_POST['ChoixPlatform']);die;
                //$result = $this->Platform->deletePlatformJoin($_GET['id']);
                foreach($_POST['ChoixPlatform'] AS $key => $value){
                    $test_platform_exist = $this->Platform->findPlatform($_GET['id'],$value);
                    var_dump($test_platform_exist);
                    if ($test_platform_exist){
                        //$result = $this->Platform->updatePlatform([
                        //    'id_game' => $_GET['id'],
                        //    'id_platform' => $value,
                        //])
                    ;
                    }else{
                        $result = $this->Platform->deletePlatformJoin($_GET['id'],$value);
                        $result = $this->Platform->createPlatform([
                            'id_game' => $_GET['id'],
                            'id_platform' => $value,
                        ]);
                    }

                }
                // J'upload les infos des images
                if (!empty($_POST['nbr'])) {
                    $nbr = $_POST['nbr'];
                    //
                    for ($i=1; $i<$nbr+1; $i++) {

                        $result = $this->Capture->updateCapt($_GET['id'],$_POST['id_capture_'.$i], [
                            'id_capture' => $_POST['id_capture_' . $i],
                            'title' => $_POST['title_capture_' . $i],
                            'legend' => $_POST['legend_capture_' . $i],
                        ]);
                    }
                }
            }

            if($result){
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
        $test_platform_exist = $this->Platform->findPlatform('id_game', 'id_platform');

        $capturesGame = $this->Capture->findAllCaptToGame($_GET['id']);

        $categories = $this->Category->extract('id', 'titre');
        $developers = $this->Developer->extract('id', 'name_developer_EU');
        $families = $this->Family->extract('id', 'name_family_EU');
        $genres = $this->Genre->extract('id', 'name_genre_EU');
        $publishers = $this->Publisher->extract('id', 'name_publisher_EU');

        $form = new BootstrapForm($game);
        $this->render('admin.games.edit', compact('categories','developers','genres','families','publishers', 'form', 'capturesGame', 'langs', 'allLangs','allPlatforms','platforms','platformsCheck','tableEncours', 'test_platform_exist' ));

    }
    public function delete(){
        if (!empty($_POST)) {
            $result = $this->Game->delete($_POST['id']);
			$result = $this->Capture->deleteCaptJoin($_POST['id']);
            $result = $this->Platform->deletePlatformJoin($_POST['id']);
            return $this->index();
        }
    }
}