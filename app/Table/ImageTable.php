<?php
namespace App\Table;

use Core\Table\Table;

class ImageTable extends Table{



    /**
     * Récupère les derniers articles de la category demandée
     */
    // Je passe le parametre du bas pour faire un fetche all > Voir mysqldatabase
    public function findAllImgToArt($id){
        return $this->query("
            SELECT *
            FROM images
            LEFT JOIN articles_images
            ON images.id = articles_images.id_image
            WHERE articles_images.id_article= ?
            ORDER BY id desc", [$id], false);
    }


    // POUR DELETE LES IMAGES LIEES
    public function deleteImgJoin($id){
        return $this->query("DELETE FROM articles_images WHERE id_image = ?", [$id], true);
    }


    // fonction d'update d'image
    public function updateImg($id,$idImg, $fields){
        $sql_parts = [];
        $attributes = [];
        foreach($fields as $k => $v){
            $sql_parts[] = "$k = ?";
            $attributes[] = $v;
        }
        $attributes[] = $id;
        $attributes[] = $idImg;

        $sql_part = implode(', ', $sql_parts);
        return $this->query("UPDATE articles_images SET $sql_part, date_modif = NOW()  WHERE id_article = ? AND id_image = ? ", $attributes, true);

    }

    // fonction d'update d'image
    public function createImg($fields){
        $sql_parts = [];
        $attributes = [];
        foreach($fields as $k => $v){
            $sql_parts[] = "$k = ?";
            $attributes[] = $v;
        }
        $sql_part = implode(', ', $sql_parts);
        return $this->query("INSERT INTO articles_images SET $sql_part, date_modif = NOW(), id_article = last_insert_id()", $attributes, true);
    }
    // fonction delete de d'images check
    public function deleteImgCheck($id,$nameImg,$foldername,$table)
    {
        //var_dump($nameImg);
        $filename = "../public/images/" . $foldername . "/" . $nameImg . "";
        $filename_thumbnail = "../public/images/" . $foldername . "/thumbnail_" . $nameImg . "";
        //var_dump($nameImg);

            if (file_exists($filename)) {
                if(strstr($nameImg, "demo_".$id."") || strstr($nameImg, "game_".$id."")){
                    @mkdir($filename, 0777, true);
                    unlink($filename);
                    @mkdir($filename_thumbnail, 0777, true);
                    unlink($filename_thumbnail);
                }
                if ($table == "background_demo") {
                    $this->query("UPDATE demos SET " . $table . " = '', date_update = NOW() WHERE id = '" . $id . "'");
                } else {
                    $this->query("UPDATE games SET " . $table . " = '', date_update = NOW() WHERE id = '" . $id . "'");
                }

            } else {
                echo 'Could not delete ' . $filename . ', file does not exist';
            }

    }
    // fonction d'update d'image
    public function uploadImg($fields,$id_game){
        array();
        $images = $fields;
        $allowedExts = array("gif", "jpeg", "jpg", "png");
        $success = null;

        foreach ( $images as $key => $value){
           // var_dump($key);
            if (!empty($value['name'])){
                // je récupere l'extension
                $ext = strtolower(pathinfo($value['name'], PATHINFO_EXTENSION));
                // Ici je vérifie de quelle image il s'agit afin d'uploader et de nommer en fonction dans le bon dossier
                if ($key=="copyright_logo_game_img"){
                    $pathfiles="../public/images/games/Copyrights/";
                    $image_name="copyright_logo_game_".$id_game.".".$ext."";
                    // J'enregistre en base game
                   $this->query("UPDATE games SET copyright_logo_game = '".$image_name."', date_update = NOW() WHERE id = '".$id_game."'");
                }
                if ($key=="banner_game_img"){
                    $pathfiles="../public/images/games/banners/";
                    $image_name="banner_game_".$id_game.".".$ext."";// J'enregistre en base game
                    $this->query("UPDATE games SET banner_game = '".$image_name."', date_update = NOW() WHERE id = '".$id_game."'");
                }
                if ($key=="background_demo_img"){
                    $pathfiles="../public/images/demos/backgrounds/";
                    $image_name="background_demo_".$id_game.".".$ext."";// J'enregistre en base game
                    $this->query("UPDATE demos SET background_demo = '".$image_name."', date_update = NOW() WHERE id = '".$id_game."'");
                }
                if ($key=="background_highlight_1_img" || $key=="background_highlight_2_img" || $key=="background_highlight_3_img"){
                    $pathfiles="../public/images/highlights/backgrounds/";
                    $image_name="".substr($key,0,-4)."_".$id_game.".".$ext."";// J'enregistre en base game
                    $this->query("UPDATE highlights SET ".substr($key,0,-4)." = '".$image_name."', date_update = NOW() WHERE id = '".$id_game."'");
                    //var_dump($test);
                }
                $i = $key+1;
                if (!file_exists($pathfiles)) {
                    mkdir($pathfiles, 0777, true);
                }
                //$image_name = $value['name'];
                $name = $image_name;
                $image_size = $value["size"] / 1024;
                $image_size = $value["size"] / 10000;
                $image_flag = true;
                $max_size = 10000;
                if( in_array($ext, $allowedExts) && $image_size < $max_size ){
                    $image_flag = true;
                } else {
                    $image_flag = false;
                    return $ProblemImg = 'Maybe '.$image_name. ' exceeds max '.$max_size.' KB size or incorrect file extension';
                }
                if($image_flag){
                    // Je verifie si le fichier existe et si oui je l'efface pour mettre le nouveau
                    //if( file_exists ($pathfiles.$name)){unlink($pathfiles.$name);}
                    move_uploaded_file($value["tmp_name"], $pathfiles.$name);
                    $src = $pathfiles.$name;
                    $dist = $pathfiles."thumbnail_".$name;
                    $data[$i]['success'] = $thumbnail = 'thumbnail_'.$name;
                    $dis_width = 100;
                    $img = '';
                    $extension = strtolower(strrchr($src, '.'));
                    switch($extension)
                    {
                        case '.jpg':
                        case '.jpeg':
                            $img = @imagecreatefromjpeg($src);
                            break;
                        case '.gif':
                            $img = @imagecreatefromgif($src);
                            break;
                        case '.png':
                            $img = @imagecreatefrompng($src);
                            break;
                    }
                    $width = imagesx($img);
                    $height = imagesy($img);
                    $dis_height = $dis_width * ($height / $width);
                    $new_image = imagecreatetruecolor($dis_width, $dis_height);
                    imagecopyresampled($new_image, $img, 0, 0, 0, 0, $dis_width, $dis_height, $width, $height);
                    $imageQuality = 100;
                    switch($extension)
                    {
                        case '.jpg':
                        case '.jpeg':
                            if (imagetypes() & IMG_JPG) {
                                imagejpeg($new_image, $dist, $imageQuality);
                            }
                            break;

                        case '.gif':
                            if (imagetypes() & IMG_GIF) {
                                imagegif($new_image, $dist);
                            }
                            break;

                        case '.png':
                            $scaleQuality = round(($imageQuality/100) * 9);
                            $invertScaleQuality = 9 - $scaleQuality;

                            if (imagetypes() & IMG_PNG) {
                                imagepng($new_image, $dist, $invertScaleQuality);
                            }
                            break;
                    }
                    imagedestroy($new_image);

                    }
                }
            }

        }


    // fonction d'update d'image
    public function updateImageNews($id,$idImg, $fields){
        $sql_parts = [];
        $attributes = [];
        foreach($fields as $k => $v){
            $sql_parts[] = "$k = ?";
            $attributes[] = $v;
        }
        $attributes[] = $id;
        $attributes[] = $idImg;

        $sql_part = implode(', ', $sql_parts);
        return $this->query("UPDATE news_images SET $sql_part, date_update = NOW()  WHERE id_news = ? AND id_image = ? ", $attributes, true);

    }

    // fonction
    public function createImageNews($fields){
        $sql_parts = [];
        $attributes = [];
        foreach($fields as $k => $v){
            $sql_parts[] = "$k = ?";
            $attributes[] = $v;
        }
        $sql_part = implode(', ', $sql_parts);
        return $this->query("INSERT INTO news_images SET $sql_part, date_insert = NOW()", $attributes, true);
    }

    // POUR DELETE LES IMAGES LIEES
    public function deleteImageNewsJoin($id,$dossier){
        if($liste = opendir($dossier)){
            while(false !== ($fichier = readdir($liste))){
                if(strstr($fichier, "news_".$id."")){
                    $filename = $dossier."/".$fichier."";
                    @mkdir($filename, 0777, true);
                    unlink($filename);
                    $this->query("DELETE FROM images WHERE image_image = '".$fichier."' AND id_table = ?", [$id], true);
                }
            }
        }
        return $this->query("DELETE FROM news_images WHERE id_news = ?", [$id], true);
    }


    // PAGE
    public function updateImagePages($id,$idImg, $fields){
        $sql_parts = [];
        $attributes = [];
        foreach($fields as $k => $v){
            $sql_parts[] = "$k = ?";
            $attributes[] = $v;
        }
        $attributes[] = $id;
        $attributes[] = $idImg;

        $sql_part = implode(', ', $sql_parts);
        return $this->query("UPDATE pages_images SET $sql_part, date_update = NOW()  WHERE id_page = ? AND id_image = ? ", $attributes, true);
    }
    public function createImagePages($fields){
        $sql_parts = [];
        $attributes = [];
        foreach($fields as $k => $v){
            $sql_parts[] = "$k = ?";
            $attributes[] = $v;
        }
        $sql_part = implode(', ', $sql_parts);
        return $this->query("INSERT INTO pages_images SET $sql_part, date_insert = NOW()", $attributes, true);
    }
    public function deleteImagePagesJoin($id,$dossier){
        if($liste = opendir($dossier)){
            while(false !== ($fichier = readdir($liste))){
                if(strstr($fichier, "pages_".$id."")){
                    $filename = $dossier."/".$fichier."";
                    @mkdir($filename, 0777, true);
                    unlink($filename);
                    $this->query("DELETE FROM images WHERE image_image = '".$fichier."' AND id_table = ?", [$id], true);
                }
            }
        }
        return $this->query("DELETE FROM pages_images WHERE id_page = ?", [$id], true);
    }
    public function findAllImgToPage($id){
        return $this->query("
            SELECT *
            FROM images
            LEFT JOIN pages_images
            ON images.id = pages_images.id_image
            WHERE pages_images.id_page= ?
            ORDER BY id desc", [$id], false);
    }


    // DEMO
    public function updateImageDemos($id,$idImg, $fields){
        $sql_parts = [];
        $attributes = [];
        foreach($fields as $k => $v){
            $sql_parts[] = "$k = ?";
            $attributes[] = $v;
        }
        $attributes[] = $id;
        $attributes[] = $idImg;

        $sql_part = implode(', ', $sql_parts);
        return $this->query("UPDATE demos_images SET $sql_part, date_update = NOW()  WHERE id_demo = ? AND id_image = ? ", $attributes, true);
    }
    public function createImageDemos($fields){
        $sql_parts = [];
        $attributes = [];
        foreach($fields as $k => $v){
            $sql_parts[] = "$k = ?";
            $attributes[] = $v;
        }
        $sql_part = implode(', ', $sql_parts);
        return $this->query("INSERT INTO demos_images SET $sql_part, date_insert = NOW()", $attributes, true);
    }
    public function deleteImageDemosJoin($id,$dossier){
        if($liste = opendir($dossier)){
            while(false !== ($fichier = readdir($liste))){
                if(strstr($fichier, "demos_".$id."")){
                    $filename = $dossier."/".$fichier."";
                    @mkdir($filename, 0777, true);
                    unlink($filename);
                    $this->query("DELETE FROM images WHERE image_image = '".$fichier."' AND id_table = ?", [$id], true);
                }
            }
        }
        return $this->query("DELETE FROM demos_images WHERE id_demo = ?", [$id], true);
    }
    public function findAllImgToDemo($id){
        return $this->query("
            SELECT *
            FROM images
            LEFT JOIN demos_images
            ON images.id = demos_images.id_image
            WHERE demos_images.id_demo= ?
            ORDER BY id desc", [$id], false);
    }

}