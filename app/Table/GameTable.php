<?php
namespace App\Table;

use Core\Table\Table;

class GameTable extends Table{

    protected $tableEncours = 'games';


    public function tableEncours(){
        return $tableEncours = 'games';
    }
    /**
     * Récupère les derniers article
     * @return array
     */
    public function last(){
        return $this->query("
            SELECT *, categories.titre as categorie
            FROM games
            LEFT JOIN categories ON category_id = categories.id
            ORDER BY games.date_Insert DESC");
    }

    /**
     * Récupère les derniers articles de la category demandée
     * @param $category_id int
     * @return array
     */
    public function lastByCategory($category_id){
        return $this->query("
            SELECT *, categories.titre as categorie
            FROM games
            LEFT JOIN categories ON category_id = categories.id
            WHERE games.category_id = ?
            ORDER BY games.date_Insert DESC", [$category_id]);
    }

    /**
     * Récupère un article en liant la catégorie associée
     * @param $id int
     * @return \App\Entity\PostEntity
     */
    public function findWithCategory($id){
        return $this->query("
            SELECT *, categories.titre as categorie
            FROM games
            LEFT JOIN categories ON category_id = categories.id
            WHERE games.id = ?", [$id], true);
    }


    // POUR DELETE LES IMAGES LIEES
    public function deleteGame($id,$dossier1,$dossier2){
        if($liste = opendir($dossier1)){
            while(false !== ($fichier = readdir($liste))){
                if(strstr($fichier, "game_".$id."")){
                    $filename = $dossier1."/".$fichier."";
                    @mkdir($filename, 0777, true);
                    unlink($filename);
                }
            }
        }
        if($liste = opendir($dossier2)){
            while(false !== ($fichier = readdir($liste))){
                if(strstr($fichier, "game_".$id."")){
                    $filename = $dossier2."/".$fichier."";
                    @mkdir($filename, 0777, true);
                    unlink($filename);
                }
            }
        }
    return $this->query("DELETE FROM games WHERE id = ?", [$id], true);
    }

    public function findLastIdGame(){
        return $this->query("SELECT id FROM games WHERE id = last_insert_id()");
    }

    public function findGame($id){
        return $this->query("SELECT * FROM {$this->table} WHERE id= ? ORDER BY id_group_lang", [$id], true);
    }

}