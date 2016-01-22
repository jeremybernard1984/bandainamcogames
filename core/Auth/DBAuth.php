<?php
namespace Core\Auth;

use Core\Database\Database;

class DBAuth {

    private $db;

    public function __construct(Database $db){
        $this->db = $db;
    }

    public function getUserId(){
        if($this->logged()){
            return $_SESSION['auth'];

        }
        return false;
    }

    /**
     * @param $username
     * @param $password
     * @return boolean
     */
    public function login($username, $HashedPassword, $uniqueKey){
        // ICI je test a l'envers ma fonction crypt de PHP... Celui ci doit etre egale au password enregistrer en ligne
        // VOIR process de controler user

        if ((crypt($_POST['password'], $HashedPassword)."-IDU-".$uniqueKey)== $HashedPassword) {
            echo "Hashed Password matched Password2";
                $user = $this->db->prepare('SELECT * FROM users WHERE mail_user = ? AND actif = 1', [$username], null, true);
                if($user){
                        $_SESSION['auth'] = $user->id;
                        $_SESSION['name'] = $user->name_user." ".$user->surname_user;
                        $_SESSION['level'] = $user->admin_user;
                        $_SESSION['lang'] = $user->lang;
                        return true;
                }
        }
        return false;
    }

    public function logged(){
        return isset($_SESSION['auth']);
    }

    public function SearchUserPassword($username){
        $userCompare = $this->db->prepare('SELECT * FROM users WHERE mail_user = ?', [$username], null, true);
        if($userCompare){
            $password = $userCompare->password;
            return $password;
        }
    }

    public function SearchUserKey($username){
        $userCompare = $this->db->prepare('SELECT * FROM users WHERE mail_user = ?', [$username], null, true);
        if($userCompare){
            $uniqueKey = $userCompare->uniqueKey;
            return $uniqueKey;
        }
    }



}