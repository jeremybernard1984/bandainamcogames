<?php
namespace App\Table;

use Core\Table\Table;

class videolinkTable extends Table{



    /**
     * Récupère les derniers articles de la category demandée
     */
    // Je passe le parametre du bas pour faire un fetche all > Voir mysqldatabase
    public function findAllVideoLinkToGame($id){
        return $this->query("
            SELECT *
            FROM videoslinks
            LEFT JOIN games_videoslinks
            ON videoslinks.id = games_videoslinks.id_videolink
            WHERE games_videoslinks.id_game= ?
            ORDER BY id desc", [$id], false);
    }

    // POUR DELETE LES IMAGES LIEES
    public function deleteVideoLinkJoin($id,$dossier){
        if($liste = opendir($dossier)){
            while(false !== ($fichier = readdir($liste))){
                if(strstr($fichier, "game_".$id."")){
                    $filename = $dossier."/".$fichier."";
                    @mkdir($filename, 0777, true);
                    unlink($filename);
                    $this->query("DELETE FROM videoslinks WHERE image_videolink = '".$fichier."' AND id_table = ? ", [$id], true);
                }
            }
        }
        return $this->query("DELETE FROM games_videoslinks WHERE id_game = ?", [$id], true);
    }

    // POUR DELETE LES IMAGES LIEES
    public function deleteVideoLinkNewsJoin($id,$dossier){
        if($liste = opendir($dossier)){
            while(false !== ($fichier = readdir($liste))){
                if(strstr($fichier, "news_".$id."")){
                    $filename = $dossier."/".$fichier."";
                    @mkdir($filename, 0777, true);
                    unlink($filename);
                    $this->query("DELETE FROM videoslinks WHERE image_videolink = '".$fichier."' AND id_table = ? ", [$id], true);
                }
            }
        }
        return $this->query("DELETE FROM games_videoslinks WHERE id_game = ?", [$id], true);
    }

    // AMELIORATION : PENSER A PASSER EN VARIABLE LE NOM DE LA TABLE

    // fonction d'update d'image
    public function updateVideoLink($id,$idImg, $fields){
        $sql_parts = [];
        $attributes = [];
        foreach($fields as $k => $v){
            $sql_parts[] = "$k = ?";
            $attributes[] = $v;
        }
        $attributes[] = $id;
        $attributes[] = $idImg;

        $sql_part = implode(', ', $sql_parts);
        return $this->query("UPDATE games_videoslinks SET $sql_part, date_update = NOW()  WHERE id_game = ? AND id_videolink = ? ", $attributes, true);

    }

    // fonction d'update d'image
    public function createVideoLink($fields){

        $sql_parts = [];
        $attributes = [];
        foreach($fields as $k => $v){
            $sql_parts[] = "$k = ?";
            $attributes[] = $v;
        }
        $sql_part = implode(', ', $sql_parts);
        return $this->query("INSERT INTO games_videoslinks SET $sql_part, date_insert = NOW()", $attributes, true);

    }


    // NEWS
    // fonction d'update d'image
    public function updateVideoLinkNews($id,$idImg, $fields){
        $sql_parts = [];
        $attributes = [];
        foreach($fields as $k => $v){
            $sql_parts[] = "$k = ?";
            $attributes[] = $v;
        }
        $attributes[] = $id;
        $attributes[] = $idImg;

        $sql_part = implode(', ', $sql_parts);
        return $this->query("UPDATE news_videoslinks SET $sql_part, date_update = NOW()  WHERE id_news = ? AND id_videolink = ? ", $attributes, true);

    }

    // fonction d'update d'image
    public function createVideoLinkNews($fields){

        $sql_parts = [];
        $attributes = [];
        foreach($fields as $k => $v){
            $sql_parts[] = "$k = ?";
            $attributes[] = $v;
        }
        $sql_part = implode(', ', $sql_parts);
        return $this->query("INSERT INTO news_videoslinks SET $sql_part, date_insert = NOW()", $attributes, true);

    }
	
}