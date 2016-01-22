<?php

namespace App\Controller\Admin;

use Core\Auth\DBAuth;
use Core\HTML\BootstrapForm;
class UsersController extends AppController{

    public function __construct(){
        parent::__construct();
        // Je load les modeles VOIR dans le dossier table
        $this->loadModel('User');
        $this->loadModel('Lang');
    }

    public function index(){
        $users = $this->User->all();
        $this->render('admin.users.index', compact('users'));
    }

    public function add(){
        //verif du mail... Sans ça pas de contact enregistré...
        $reg = '/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/';
        if (!empty($_POST) && empty($_GET['id']) && isset($_POST['mail_user']) && preg_match($reg, $_POST['mail_user'])) {
            //Cryptage du password Voir edit dessous pour explications PS. Penser a créer une fonction
            $password = $_POST['password'];
            $salt = uniqid();
            $Algo = '6';
            $Rounds = '5000';
            $CryptSalt = '$' . $Algo . '$rounds=' . $Rounds . '$' . $salt;
            $HashedPassword = crypt($password , $CryptSalt);

                $result = $this->User->create([
                    'mail_user' => $_POST['mail_user'],
                    'password' => $HashedPassword."-IDU-".$salt,
                    'uniqueKey' => $salt,
                    'admin_user' => $_POST['admin_user'],
                    'name_user' => $_POST['name_user'],
                    'resum_user' => $_POST['resum_user'],
                    'surname_user' => $_POST['surname_user'],
                    'lang' => $_POST['lang'],
                    'actif' => $_POST['actif'],
                    'mail_user' => $_POST['mail_user'],
                ]);
            $findLastIdUsers = $this->User->findLastIdPages();
            foreach ($findLastIdUsers as $idNewUser) {
                if($result){
                    header('Location: /poo_graphicart/project/public/index.php?p=admin.users.edit&id='.$idNewUser->id);
                }
            }
        }
        $tableEncours = $this->User->tableEncours();
        $lastId = $this->User->lastId();
        $allLangs = $this->Lang->extractAllLang('alpha2', 'nom_fr_fr');
        $langs = "";
        $form = new BootstrapForm($_POST);
        $this->render('admin.users.edit', compact('form', 'lastId', 'tableEncours', 'allLangs', 'langs'));
    }

    /**
     *
     */
    public function edit(){
        $reg = '/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/';
        if (!empty($_POST) && isset($_POST['mail_user']) && preg_match($reg, $_POST['mail_user'])) {
            //var_dump($_POST);
            if (isset($_POST['password']) && !empty($_POST['password'])){
                $password = $_POST['password'];
                /*CRYPT_SHA512 - Hachage SHA-512 dont le salt est composé de 16 caractères préfixé par $6$.
                Si le salt commence par 'rounds=<N>$', la valeur numérique de N sera utilisée pour indiquer
                le nombre de fois que la boucle de hachage doit être exécutée, un peu comme le paramètre dans
                l'algorithme Blowfish. La valeur par défaut de rounds est de 5000, le minimum pouvant être de 1000 et le maximum, de 999,999,999.
                Tout autre sélection de N en dehors de cet intervalle sera tronqué à la plus proche des 2 limites
                 */
                $salt = uniqid(); // Could use the second parameter to give it more entropy.
                $Algo = '6'; // This is CRYPT_SHA512 as shown on http://php.net/crypt
                $Rounds = '5000'; // The more, the more secure it is!
                // This is the "salt" string we give to crypt().
                $CryptSalt = '$' . $Algo . '$rounds=' . $Rounds . '$' . $salt;
                $HashedPassword = crypt($password , $CryptSalt);
                //var_dump("Generated a hashed password: " . $HashedPassword);
                $password = $HashedPassword."-IDU-".$salt;
            }else{
                $password = $_POST['old_password'];
                $salt = $_POST['old_salt'];
            }
                $result = $this->User->updateUser($_GET['id'], [
                    'password' => $password,
                    'uniqueKey' => $salt,
                    'admin_user' => $_POST['admin_user'],
                    'name_user' => $_POST['name_user'],
                    'resum_user' => $_POST['resum_user'],
                    'surname_user' => $_POST['surname_user'],
                    'lang' => $_POST['lang'],
                    'actif' => $_POST['actif'],
                    'mail_user' => $_POST['mail_user'],
                ]);
            if($result){
                echo "<script language='JavaScript'>alert('User(s) enregistrée(s)')</script>";
            }

        }
        $tableEncours = $this->User->tableEncours();
        $user = $this->User->find($_GET['id']);
        $allLangs = $this->Lang->extractAllLang('alpha2', 'nom_fr_fr');
        $langs = "";
        $form = new BootstrapForm($user);
        $this->render('admin.users.edit', compact('user', 'form', 'tableEncours', 'allLangs','langs' ));
    }

    public function delete(){
        if (!empty($_POST)) {
            $result = $this->User->delete($_POST['id']);
            return $this->index();
        }


    }


}