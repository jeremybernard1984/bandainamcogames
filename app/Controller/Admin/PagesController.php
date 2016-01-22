<?php

namespace App\Controller\Admin;

use Core\HTML\BootstrapForm;
class PagesController extends AppController{

    public function __construct(){
        parent::__construct();
        // Je load les modeles VOIR dans le dossier table
        $this->loadModel('Page');
        $this->loadModel('Image');
        $this->loadModel('Lang');
    }

    public function index(){
		$totals = $this->Page->CountEntrer();
		//var_dump($totals);die;
		foreach ($totals as $total) {
			var_dump($total);
			//var_dump($total);die;
			//$total->COUNT(*);
		}
			$epp = 5; // nombre d'entrées à afficher par page (entries per page)
			$nbPages = ceil(3/$epp); // calcul du nombre de pages $nbPages (on arrondit à l'entier supérieur avec la fonction ceil())
			// Récupération du numéro de la page courante depuis l'URL avec la méthode GET
			// S'il s'agit d'un nombre on traite, sinon on garde la valeur par défaut : 1
			$current = 1;
			if (isset($_GET['n']) && is_numeric($_GET['n'])) {
			$page = intval($_GET['n']);
			if ($page >= 1 && $page <= $nbPages) {
				// cas normal
				$current=$page;
			} else if ($page < 1) {
				// cas où le numéro de page est inférieure 1 : on affecte 1 à la page courante
				$current=1;
			} else {
				//cas où le numéro de page est supérieur au nombre total de pages : on affecte le numéro de la dernière page à la page courante
				$current = $nbPages;
				}
			}
			// $start est la valeur de départ du LIMIT dans notre requête SQL (dépend de la page courante)
			$start = ($current * $epp - $epp);
        $pages = $this->Page->allInUserLangPagination($start,$epp);
		$pagination = $this->Page->paginate('/index.php?p=admin.pages.index', '&n=', $nbPages, $current);
		//var_dump($pages);die;
        $this->render('admin.pages.index', compact('pages','pagination'));
		
    }


    public function add(){
        //var_dump($_POST);
        if (!empty($_POST)) {
                $result = $this->Page->create([
                    'title_page' => $_POST['title_page'],
                    'resum_page' => $_POST['resum_page'],
                    'description_page' => $_POST['description_page'],
                    'actif' => $_POST['actif'],
                    'lang' => $_POST['lang'],
                ]);
            // Je récupere l'id de la langue pour la transmettre aux tables liées
            $findLastIdPages = $this->Page->findLastIdPages();
            foreach ($findLastIdPages as $idNewPage) {
                // Je vérifie si le Bt save est envoyé avant de rediriger vers l'index
                if($result AND !empty($_POST['BtSave'])){
                    //return $this->index();
                    header('Location: /bandainamco/public/index.php?p=admin.pages.edit&id='.$idNewPage->id);
                }
            }
        }
        $langs="";
        $tableEncours = $this->Page->tableEncours();
        $lastId = $this->Page->lastId();
        $allLangs = $this->Lang->extractAllLang('alpha2', 'nom_fr_fr');
        $form = new BootstrapForm($_POST);
        $this->render('admin.pages.edit', compact('langs', 'form', 'lastId', 'allLangs', 'tableEncours'));

    }

    /**
     *
     */
    public function edit(){
        if (!empty($_POST)) {
            if (!empty($_POST['BtAllLang'])){
                foreach($_POST['ChoixLang'] AS $key => $value){
                    // J'enregistre la premiere langue
                    $result = $this->Page->create([
                        'title_page' => $_POST['title_page'],
                        'resum_page' => $_POST['resum_page'],
                        'description_page' => $_POST['description_page'],
                        'actif' => $_POST['actif'],
                       // 'game_id_join' => $_POST['game_id_join'],
                        'lang' => $value,
                        'id_group_lang' => $_GET['id']
                    ]);
                    // Je récupere l'id de la langue pour la transmettre aux tables liées
                    $findLastIdPages = $this->Page->findLastIdPages();
                    foreach ($findLastIdPages as $idNewPages) {
                        // J'upload les infos des images si il y a des image. Je compte pour voir
                        if (isset($_POST['nbr'])) {
                            $nbr = $_POST['nbr'];
                            for ($i = 1; $i < $nbr + 1; $i++) {
                                $result = $this->Image->createImagePages([
                                    'id_page' => $idNewPages->id,
                                    'id_image' => $_POST['id_capture_' . $i],
                                    'title' => $_POST['title_capture_' . $i],
                                    'legend' => $_POST['legend_capture_' . $i],
                                ]);
                            }
                        }
                    }
                }

                $result = $this->Page->update($_GET['id'], [
                    'title_page' => $_POST['title_page'],
                    'resum_page' => $_POST['resum_page'],
                    'description_page' => $_POST['description_page'],
                    'actif' => $_POST['actif'],
                   // 'game_id_join' => $_POST['game_id_join'],
                    'lang' => $_POST['lang'],
                    'id_group_lang' => $_GET['id']
                ]);
                // J'upload les infos des images
                if (!empty($_POST['nbr'])) {
                    $nbr = $_POST['nbr'];
                    for ($i = 1; $i < $nbr + 1; $i++) {
                        $result = $this->Image->updateImagePages($_GET['id'], $_POST['id_capture_' . $i], [
                            'id_image' => $_POST['id_capture_' . $i],
                            'title' => $_POST['title_capture_' . $i],
                            'legend' => $_POST['legend_capture_' . $i]
                        ]);
                    }
                }

            }else{
                $result = $this->Page->update($_GET['id'], [
                    'title_page' => $_POST['title_page'],
                    'resum_page' => $_POST['resum_page'],
                    'description_page' => $_POST['description_page'],
                    'actif' => $_POST['actif'],
                ]);
                // J'upload les infos des images
                if (!empty($_POST['nbr'])) {
                    $nbr = $_POST['nbr'];
                    for ($i=1; $i <= $nbr; $i++) {
                        $result = $this->Image->updateImagePages($_GET['id'],$_POST['id_capture_'.$i], [
                            'id_image' => $_POST['id_capture_' . $i],
                            'title' => $_POST['title_capture_' . $i],
                            'legend' => $_POST['legend_capture_' . $i],
                        ]);
                    }
                }
            }
            if($result){
                echo "<script language='JavaScript'>alert('Page(s) enregistrée(s)')</script>";
            }

        }
        $tableEncours = $this->Page->tableEncours();
        $page = $this->Page->find($_GET['id']);
        $allLangs = $this->Lang->extractAllLang('alpha2', 'nom_fr_fr');
        $langs =$this->Lang->findAllLangToPages($page->id_group_lang);
        $imagesPage  = $this->Image->findAllImgToPage($_GET['id']);

        $form = new BootstrapForm($page);
        $this->render('admin.pages.edit', compact('page', 'form', 'imagesPage', 'langs', 'allLangs','tableEncours' ));
    }

    public function delete(){
        if (!empty($_POST)) {

            $result = $this->Page->delete($_POST['id']);
            $result = $this->Image->deleteImgJoin($_POST['id']);

            $dossier = "../public/images/pages/";
            // Si je transmet les infos master Je supprime tous les jeux du group langue.
            if (isset($_GET['master']) && $_GET['master']=='EU') {
                $langs = $this->Lang->findAllLangToPages($_GET['group']);
                foreach($langs as $lang):
                    $result = $this->Page->delete($lang->id);
                    $result = $this->Image->deleteImagePagesJoin($lang->id, $dossier.'images');
                endforeach;
                $result = $this->Page->delete($_POST['id']);
                $result = $this->Image->deleteImagePagesJoin($_POST['id'], $dossier.'images');
            }
            // Sinon je supprime juste la langue en question
            else{
                $result = $this->Page->delete($_POST['id']);
                $result = $this->Image->deleteImagePagesJoin($_POST['id'], $dossier.'images');
            }
            return $this->index();
        }


    }


}