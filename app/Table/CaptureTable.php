<?php
namespace App\Table;

use Core\Table\Table;

class CaptureTable extends Table{



    /**
     * Récupère les derniers articles de la category demandée
     */
    // Je passe le parametre du bas pour faire un fetche all > Voir mysqldatabase
    public function findAllCaptToGame($id){
        return $this->query("
            SELECT *
            FROM captures
            LEFT JOIN games_captures
            ON captures.id = games_captures.id_capture
            WHERE games_captures.id_game= ?
            ORDER BY id desc", [$id], false);
    }


    // POUR DELETE LES IMAGES LIEES
    public function deleteCaptJoin($id,$dossier){
        if($liste = opendir($dossier)){
            while(false !== ($fichier = readdir($liste))){
                if(strstr($fichier, "game_".$id."")){
                    $filename = $dossier."/".$fichier."";
                    @mkdir($filename, 0777, true);
                    unlink($filename);
                    $this->query("DELETE FROM captures WHERE image_capture = '".$fichier."' AND id_table = ?", [$id], true);
                }
            }
        }
        return $this->query("DELETE FROM games_captures WHERE id_game = ?", [$id], true);
    }


    // fonction d'update d'image
    public function updateCapt($id,$idImg, $fields){
        $sql_parts = [];
        $attributes = [];
        foreach($fields as $k => $v){
            $sql_parts[] = "$k = ?";
            $attributes[] = $v;
        }
        $attributes[] = $id;
        $attributes[] = $idImg;

        $sql_part = implode(', ', $sql_parts);
        return $this->query("UPDATE games_captures SET $sql_part, date_update = NOW()  WHERE id_game = ? AND id_capture = ? ", $attributes, true);

    }

    // fonction d'update d'image
    public function createCapt($fields){

        $sql_parts = [];
        $attributes = [];
        foreach($fields as $k => $v){
            $sql_parts[] = "$k = ?";
            $attributes[] = $v;
        }
        $sql_part = implode(', ', $sql_parts);
        return $this->query("INSERT INTO games_captures SET $sql_part, date_insert = NOW()", $attributes, true);

    }
	
}