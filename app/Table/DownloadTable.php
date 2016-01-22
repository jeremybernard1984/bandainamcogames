<?php
namespace App\Table;

use Core\Table\Table;

class DownloadTable extends Table{



    /**
     * Récupère les derniers articles de la category demandée
     */
    // Je passe le parametre du bas pour faire un fetche all > Voir mysqldatabase
    public function findAllDownloadToGame($id){
        return $this->query("
            SELECT *
            FROM downloads
            LEFT JOIN games_downloads
            ON downloads.id = games_downloads.id_download
            WHERE games_downloads.id_game= ?
            ORDER BY id desc", [$id], false);
    }


    // POUR DELETE LES IMAGES LIEES
    public function deleteDownloadJoin($id,$dossier){
        if($liste = opendir($dossier)){
            while(false !== ($fichier = readdir($liste))){
                if(strstr($fichier, "game_".$id."")){
                    $filename = $dossier."/".$fichier."";
                    @mkdir($filename, 0777, true);
                    unlink($filename);
                    $this->query("DELETE FROM downloads WHERE image_download = '".$fichier."' AND id_table = ?", [$id], true);
                }
            }
        }
        return $this->query("DELETE FROM games_downloads WHERE id_game = ?", [$id], true);
    }


    // fonction d'update d'image
    public function updateDownload($id,$idImg, $fields){
        $sql_parts = [];
        $attributes = [];
        foreach($fields as $k => $v){
            $sql_parts[] = "$k = ?";
            $attributes[] = $v;
        }
        $attributes[] = $id;
        $attributes[] = $idImg;

        $sql_part = implode(', ', $sql_parts);
        return $this->query("UPDATE games_downloads SET $sql_part, date_update = NOW()  WHERE id_game = ? AND id_download = ? ", $attributes, true);

    }

    // fonction d'update d'image
    public function createDownload($fields){

        $sql_parts = [];
        $attributes = [];
        foreach($fields as $k => $v){
            $sql_parts[] = "$k = ?";
            $attributes[] = $v;
        }
        $sql_part = implode(', ', $sql_parts);
        return $this->query("INSERT INTO games_downloads SET $sql_part, date_insert = NOW()", $attributes, true);

    }
	
}