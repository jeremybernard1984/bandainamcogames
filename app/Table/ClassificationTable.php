<?php
namespace App\Table;

use Core\Table\Table;

class ClassificationTable extends Table{


    // fonction d'update d'image
    public function createClassifications($id_game){
        // Je créé de base les 24 classifications possibles
        for ($i=1; $i<=24; $i++){
            $this->query("INSERT INTO games_classifications SET id_game=$id_game, id_classification=$i, check_classification='0'");
        }
    }
    // fonction d'update d'image
    public function createClassificationsLang($id_game,$i){
            $this->query("INSERT INTO games_classifications SET id_game=$id_game, id_classification=$i, check_classification='0'");
    }
    // fonction d'update d'image
    public function UpdateClassifications($id_game,$id_classification,$check_classification){
        $this->query("UPDATE games_classifications SET check_classification = $check_classification WHERE id_game = $id_game AND id_classification = $id_classification ");
    }

    // fonction d'update d'image
    public function deleteClassificationJoin($id_game){
            $this->query("DELETE FROM games_classifications WHERE id_game=$id_game");
    }
}