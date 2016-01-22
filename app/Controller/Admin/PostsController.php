<?php

namespace App\Controller\Admin;

use Core\HTML\BootstrapForm;
class PostsController extends AppController{

    public function __construct(){
        parent::__construct();
        // Je load les modeles VOIR dans le dossier table
        $this->loadModel('Post');
        $this->loadModel('Image');
        $this->loadModel('Lang');
        $this->loadModel('Category');
    }

    public function index(){
        $posts = $this->Post->all();
        $this->render('admin.posts.index', compact('posts'));
    }


    public function add(){
        if (!empty($_POST)) {
                $result = $this->Post->create([
                    'titre' => $_POST['titre'],
                    'resume' => $_POST['resume'],
                    'contenu' => $_POST['contenu'],
                    'actif' => $_POST['actif'],
                    'lang' => $_POST['lang'],
                    'category_id' => $_POST['category_id']
                ]);
            // Je vérifie si le Bt save est envoyé avant de rediriger vers l'index
            if($result AND !empty($_POST['BtSave'])){
                return $this->index();
            }
        }
        $tableEncours = $this->Post->tableEncours();

        $lastId = $this->Post->lastId();

        $allLangs = $this->Lang->extractAllLang('alpha2', 'nom_fr_fr');

        $categories = $this->Category->extract('id', 'titre');

        $form = new BootstrapForm($_POST);
        $this->render('admin.posts.edit', compact('categories', 'form', 'lastId', 'allLangs', 'tableEncours'));
    }

    /**
     *
     */
    public function edit(){
        if (!empty($_POST)) {
            if (!empty($_POST['BtAllLang'])){
                foreach($_POST['ChoixLang'] AS $key => $value){
                    // J'enregistre la premiere langue
                    $result = $this->Post->create([
                        'titre' => $_POST['titre'],
                        'resume' => $_POST['resume'],
                        'contenu' => $_POST['contenu'],
                        'actif' => $_POST['actif'],
                        'lang' => $value,
                        'id_group_lang' => $_GET['id'],
                        'category_id' => $_POST['category_id']
                    ]);
                    // J'upload les infos des images si il y a des image. Je compte pour voir
                    if (isset($_POST['nbr'])) {
                        $nbr = $_POST['nbr'];
                        for ($i = 1; $i < $nbr + 1; $i++) {
                            $result = $this->Image->createImg([
                                //'id_article' => $lastId1,
                                'id_image' => $_POST['id_image_' . $i],
                                'titre' => $_POST['titre_image_' . $i],
                                'legende' => $_POST['legende_image_' . $i],
                                'lien' => $_POST['lien_image_' . $i]
                            ]);
                        }
                    }
                }


                $result = $this->Post->update($_GET['id'], [
                    'titre' => $_POST['titre'],
                    'resume' => $_POST['resume'],
                    'contenu' => $_POST['contenu'],
                    'actif' => $_POST['actif'],
                    'lang' => $_POST['lang'],
                    'id_group_lang' => $_GET['id'],
                    'category_id' => $_POST['category_id']
                ]);
                // J'upload les infos des images
                if (!empty($_POST['nbr'])) {
                    $nbr = $_POST['nbr'];
                    for ($i=1; $i<$nbr+1; $i++) {
                        $result = $this->Image->updateImg($_GET['id'],$_POST['id_image_'.$i], [
                            'titre' => $_POST['titre_image_'.$i],
                            'legende' => $_POST['legende_image_'.$i],
                            'lien' => $_POST['lien_image_'.$i]
                        ]);
                    }
                }

            }else{
                $result = $this->Post->update($_GET['id'], [
                    'titre' => $_POST['titre'],
                    'resume' => $_POST['resume'],
                    'contenu' => $_POST['contenu'],
                    'actif' => $_POST['actif'],
                    //'id_group_lang' => $_GET['id'],
                    'category_id' => $_POST['category_id']
                ]);
                // J'upload les infos des images
                if (!empty($_POST['nbr'])) {
                    $nbr = $_POST['nbr'];
                    //var_dump($nbr);die;
                    for ($i=1; $i<$nbr+1; $i++) {

                        $result = $this->Image->updateImg($_GET['id'],$_POST['id_image_'.$i], [
                            'titre' => $_POST['titre_image_'.$i],
                            'legende' => $_POST['legende_image_'.$i],
                            'lien' => $_POST['lien_image_'.$i]
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
        $tableEncours = $this->Post->tableEncours();

        $post = $this->Post->find($_GET['id']);

        $allLangs = $this->Lang->extractAllLang('alpha2', 'nom_fr_fr');
        $langs =$this->Lang->findAllLangToArt($post->id_group_lang);

        $imagesArt  = $this->Image->findAllImgToArt($_GET['id']);

        $categories = $this->Category->extract('id', 'titre');

        $form = new BootstrapForm($post);
        $this->render('admin.posts.edit', compact('categories', 'form', 'imagesArt', 'langs', 'allLangs','tableEncours' ));

    }

    public function delete(){
        if (!empty($_POST)) {
            $result = $this->Post->delete($_POST['id']);
			$result = $this->Image->deleteImgJoin($_POST['id']);
            return $this->index();
        }
    }


}