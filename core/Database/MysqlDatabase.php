<?php
namespace Core\Database;
// Je precise que je fait appel a PDO a la racine de mon serveur.
use \PDO;

class MysqlDatabase extends Database{

    private $db_name;
    private $db_user;
    private $db_pass;
    private $db_host;
    private $pdo;

    public function __construct($db_name, $db_user, $db_pass, $db_host){
        $this->db_name = $db_name;
        $this->db_user = $db_user;
        $this->db_pass = $db_pass;
        $this->db_host = $db_host;
    }
    // NOTRE ACCESSEUR A LA BASE DE DONNEE : Vérifie la connexion = 1 fois
    public function getPDO(){
        // Pour eviter de refaire des appels a GET PDO sans arret, on verifie si celui ci est initialisé
        if($this->pdo === null){
            $pdo = new PDO('mysql:host=db601175712.db.1and1.com;dbname=db601175712','dbo601175712','Sdk56six');
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->pdo = $pdo;
            // test d'initialisation
            //var_dump('PDO INITIALISÉ');
        }
        // test d'initialisation
        //var_dump('PDO APPELE');
        return $this->pdo;
    }
//$statement : reference a la requete envoye
// $class_name : reference a l'id de la classe puisqu'il s'agira d'un objet en retour
    public function query($statement, $class_name = null, $one = false){
        $req = $this->getPDO()->query($statement);

        if(
            strpos($statement, 'UPDATE') === 0 ||
            strpos($statement, 'INSERT') === 0 ||
            strpos($statement, 'DELETE') === 0
        ) {
            //var_dump($req);die;
            return $req;
        }
        if($class_name === null){
            $req->setFetchMode(PDO::FETCH_OBJ);
            var_dump($req);die;
        } else {
            $req->setFetchMode(PDO::FETCH_CLASS, $class_name);
        }
        if($one) {
            $datas = $req->fetch();
        } else {
            $datas = $req->fetchAll();
        }

        return $datas;


    }

    public function prepare($statement, $attributes, $class_name = null, $one = false){
        $req = $this->getPDO()->prepare($statement);
        $res = $req->execute($attributes);

        if(
            strpos($statement, 'UPDATE') === 0 ||
            strpos($statement, 'INSERT') === 0 ||
            strpos($statement, 'DELETE') === 0
        ) {
            return $res;
        }
        // SELON SI on utilise Fetch ou fetch class
        // On vérifi lequel on va utiliser... Si le parametre classname est defini ce sera fetch class
        // Du coup on passera le parametre classname qui defini la class utilisée. (POST, Categorie...)
        if($class_name === null){
            $req->setFetchMode(PDO::FETCH_OBJ);
        } else {
            $req->setFetchMode(PDO::FETCH_CLASS, $class_name);
        }
        // Le 4eme parametre correspond a savoir s'il s'agit de recuperer un ou plusieurs parametres...
        // Le FETCHE retourne un OBJET alors que le FETCH ALL retourne un tableau.
        if($one) {
            $datas = $req->fetch();
        } else {
            $datas = $req->fetchAll();
        }
        //var_dump($req);
        return $datas;
    }

    public function lastInsertId(){
        return $this->getPDO()->lastInsertId();
        //$lasttId = $this->getPDO()->lastInsertId();
    }

}