<?php
namespace App\Table;

use Core\Table\Table;

class PlatformTable extends Table{

    public function extractAllPlatform($key, $value){
        $records = $this->query('SELECT * FROM platforms ORDER BY id DESC');

        $return = [];
        foreach($records as $v){
            $return[$v->$key] = $v->$value;
        }
        return $return;
    }


    // Je passe le parametre du bas pour faire un fetche all > Voir mysqldatabase
    public function findAllPlatformToGame($id){
        return $this->query("
            SELECT *
            FROM platforms
            LEFT JOIN games_platforms
            ON platforms.id = games_platforms.id_platform
            WHERE games_platforms.id_game= ?
            ORDER BY id desc", [$id], false);
    }


    // POUR DELETE LES IMAGES LIEES
    public function deletePlatformJoin($id,$dossier){
        if($liste = opendir($dossier)){
            while(false !== ($fichier = readdir($liste))){
                if(strstr($fichier, "game_".$id."")){
                    $filename = $dossier."/".$fichier."";
                    @mkdir($filename, 0777, true);
                    unlink($filename);
                }
            }
        }
        return $this->query("DELETE FROM games_platforms WHERE id_game = ?", [$id], true);
    }

    // fonction d'update d'image
    public function updatePlatform($id_game,$id_platform, $fields){
        $sql_parts = [];
        $attributes = [];
        foreach($fields as $k => $v){
            $sql_parts[] = "$k = ?";
            $attributes[] = $v;
        }
        $attributes[] = $id_game;
        $attributes[] = $id_platform;

        $sql_part = implode(', ', $sql_parts);
        return $this->query("UPDATE games_platforms SET $sql_part, date_update = NOW()  WHERE id_game = ? AND id_platform = ? ", $attributes, true);

    }



    // fonction d'update d'image
    public function createPlatform($fields){
        //var_dump($fields);
        $sql_parts = [];
        $attributes = [];
        foreach($fields as $k => $v){
            $sql_parts[] = "$k = ?";
            $attributes[] = $v;
        }
        $sql_part = implode(', ', $sql_parts);
        return $this->query("INSERT INTO games_platforms SET $sql_part, date_insert = NOW()", $attributes, true);
    }

    public function findPlatformCheckCreate(){
        return $this->query("
            SELECT id_platform
            FROM games_platforms
            WHERE id_game= last_insert_id()
            ", false);
    }

    public function findPlatformCheck($id){
        return $this->query("
            SELECT id_platform
            FROM games_platforms
            WHERE id_game= ?
            ", [$id], false);
    }

	
}