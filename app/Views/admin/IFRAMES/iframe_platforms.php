<?php
$id_game = $_GET['id_game'];
$pdo = new PDO('mysql:host=db601175712.db.1and1.com;dbname=db601175712','dbo601175712','Sdk56six', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION ));
// fonction delete de d'images check
function deleteImgCheck($id_game,$nameImg){
    //var_dump($nameImg);
    $filename = "../../../../public/images/games/covers/".$nameImg."";
    $filename_thumbnail = "../../../../public/images/games/covers/thumbnail_".$nameImg."";
    //var_dump($filename);
    if (file_exists($filename)) {
        @mkdir($filename, 0777, true);
        unlink($filename);
        @mkdir($filename_thumbnail, 0777, true);
        unlink($filename_thumbnail);
    }
}
// fonction d'update d'image
function uploadImg($id_game,$id_platforms){
    array();
    $allowedExts = array("gif", "jpeg", "jpg", "png");
    $success = null;
        if (!empty($_FILES['cover_game']['name'])){
            //var_dump($_FILES);
            // je récupere l'extension
            $ext = strtolower(pathinfo($_FILES['cover_game']['name'], PATHINFO_EXTENSION));
            // Ici je vérifie de quelle image il s'agit afin d'uploader et de nommer en fonction dans le bon dossier
            $pathfiles="../../../../public/images/games/covers/";
            $name="cover_game_".$id_game."_platform_".$id_platforms.".".$ext."";
            if (!file_exists($pathfiles)) {
                mkdir($pathfiles, 0777, true);
            }
            $image_size = $_FILES['cover_game']["size"] / 1024;
            $image_size = $_FILES['cover_game']["size"] / 10000;
            $image_flag = true;
            $max_size = 10000;
            if( in_array($ext, $allowedExts) && $image_size < $max_size ){
                $image_flag = true;
            } else {
                $image_flag = false;
                return $ProblemImg = 'Maybe '.$name. ' exceeds max '.$max_size.' KB size or incorrect file extension';
            }
            if($image_flag){
                // Je verifie si le fichier existe et si oui je l'efface pour mettre le nouveau
                //if( file_exists ($pathfiles.$name)){unlink($pathfiles.$name);}
                move_uploaded_file($_FILES['cover_game']["tmp_name"], $pathfiles.$name);
                $src = $pathfiles.$name;
                $dist = $pathfiles."thumbnail_".$name;
                $data[0]['success'] = $thumbnail = 'thumbnail_'.$name;
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
// end function img

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Page platform game</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
    <link href="../../../../public/css/bootstrap-tabs-x.css" media="all" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="../../../../public/css/datepicker.css">
    <style rel="stylesheet">
        li a.menu_platforms{padding:4px 6px;font-size: 12px;text-align: right;}
    </style>
</head>
<body onload="parent.accesIframe2()">

<?php
$message="";
//enregistrement
if (isset($_GET['action']) && $_GET['action'] == "update"){
    //var_dump($_POST);
    $id_game = $_GET['id_game'];
    $platformId_game = $_POST['platformId_game'];
    if (isset($_FILES) && $_FILES['cover_game']['name'] != ""){
        $ext = strtolower(pathinfo($_FILES['cover_game']['name'], PATHINFO_EXTENSION));
        $cover_game = "cover_game_".$id_game."_platform_".$platformId_game.".".$ext."";
        $requeteCover = "cover_game = '".$cover_game."',";
        uploadImg($_GET['id_game'],$platformId_game);
    }else if (isset($_POST['cover_game_name_delete']) && $_POST['cover_game_name_delete'] == true){
        deleteImgCheck($id_game,$_POST['cover_game']);
        $requeteCover = "cover_game = '',";
    }else{
        $requeteCover="";
    }

    $date = str_replace('/', '-', $_POST['release_date_game']);
    $release_date_game = date('Y-m-d H:i:s', strtotime($date));
    $informations_game = $_POST['informations_game'];
    $characteristics_game = $_POST['characteristics_game'];
    $download_link_game = $_POST['download_link_game'];
    $location = "games_platforms";

    $reqUpdateJoint = "
            UPDATE games_platforms
              SET ".$requeteCover." release_date_game = '".$release_date_game."',
                informations_game = '".$informations_game."',
                characteristics_game = '".$characteristics_game."',download_link_game = '".$download_link_game."',
                date_update = NOW()
              WHERE id_game = '".$id_game."' AND id_platform = '".$platformId_game."'";
    //var_dump($reqUpdateJoint);//die;
    $updatePlatformJoint = $pdo->prepare($reqUpdateJoint);
    $updatePlatformJoint->execute();
    $_GET['action'] = "";
    $message="La platform à été modifiée";
}
if (isset($_GET['action']) && $_GET['action'] == "delete"){
    $id_game = $_GET['id_game'];
    $id_platform = $_GET['id_platform'];
    $reqDeleteJoint = "DELETE FROM games_platforms WHERE id_game = '".$id_game."' AND id_platform = '".$id_platform."'";
    $DeletePlatformJoint = $pdo->prepare($reqDeleteJoint);
    $DeletePlatformJoint->execute();
    $_GET['action'] = "";
    ?>
    <script>
        parent.location.href = 'http://localhost/poo_graphicart/project/public/index.php?p=admin.games.edit&id=<?=$id_game;?>';
    </script>
<?php


}
//affichage
$resultats=$pdo->query("SELECT * FROM platforms LEFT JOIN games_platforms ON platforms.id = games_platforms.id_platform WHERE games_platforms.id_game= ".$id_game." ORDER BY id desc");
$resultats->setFetchMode(PDO::FETCH_OBJ);
$countPlatform = $resultats->rowCount();
//Calcule du nombre d'enregistrements

//var_dump($countPlatform);
?>
<input type="hidden" name="nbr2" id="nbr2" value="<?=$countPlatform?>">
<table style="width: 100%;">
    <tr>
        <td style="width:20%" valign="top">
            <div class="tabbable tabs-left">
                <ul class="nav nav-tabs" style="min-height: 743px">
                    <?php
                    $i=0;
                    while( $resultat = $resultats->fetch()){
                        $id = $resultat->id;
                        $titre = $resultat->name_platform_EU;
                        ?>
                        <li id="tab<?=$i?>"><a href="#<?=$i?>" data-toggle="tab" class="menu_platforms"><?=$titre?></a></li>
                        <?php
                        $i=$i+1;
                    }
                    ?>
                </ul>
            </div>
        <td style="width:80%" valign="top">
            <div class="tab-content">
                <?php
                $resultats2=$pdo->query("SELECT * FROM platforms LEFT JOIN games_platforms ON platforms.id = games_platforms.id_platform WHERE games_platforms.id_game= ".$id_game." ORDER BY id desc");
                $resultats2->setFetchMode(PDO::FETCH_OBJ);
                $e=0;
                while( $resultat = $resultats2->fetch()){
                    $id_game = $resultat->id_game;
                    $id_platform = $resultat->id_platform;
                    $cover_game = $resultat->cover_game;
                    $release_date_game = $resultat->release_date_game;
                    $informations_game = $resultat->informations_game;
                    $characteristics_game = $resultat->characteristics_game;
                    $download_link_game = $resultat->download_link_game;
                    ?>

                    <div class="tab-pane fade" id="<?=$e?>" style="font-size: 11px;">
                        <form name="saves<?=$e?>" action="?action=update&id_game=<?= $id_game ?>" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="tab" value="<?=$e?>">
                            <input name="platformId_game" type="hidden" id="platformId_game_<?=$e+1?>" value="<?php if (isset($id_platform)){echo $id_platform;}?>">
                            <?php if ($message!="" && $_POST['tab'] == $e){ ?>
                                <div class="alert alert-success">
                                    <a href="#" class="close" data-dismiss="alert">&times;</a>
                                    <strong>Success!</strong> <?=$message?>.
                                </div>
                            <?php } ?>
                            <table width="100%">
                                <tr>
                                    <td width="40%">
                                        <div class='form-group' style="text-align: center;">
                                            <label>Cover</label></br>
                                            <span style="background: #e1e1e8;display: block">
                                                <input id="cover_game_name_delete" type="checkbox" name="cover_game_name_delete">
                                                <label style="color: #d9534f;font-size: 11px;cursor:pointer;" for="cover_game_name_delete">Delete</label>
                                            </span>
                                            <?php if (isset($cover_game)){ ?>
                                                <div style="width:100%;height: 110px;background: url('../../../../public/images/games/covers/<?=$cover_game?>?<?=time()?>') no-repeat center #e1e1e8;background-size: contain;"></div>
                                            <?php } ?>

                                            <input style="margin-top:5px;" name="cover_game" type="file" id="cover_game_<?=$e+1?>" value="<?php if (isset($cover_game)){echo $cover_game;}?>">
                                            <input onchange="parent.accesIframe2()" type="hidden" name="cover_game" id="cover_game_name_<?=$e+1?>" value="<?php if (isset($cover_game)){echo $cover_game;}?>">

                                        </div>
                                    </td>
                                    <td width="60%" valign="top" style="padding: 0 5px">
                                        <div class="form-group">
                                            <label>Date de sortie :</label>
                                            <?php
                                            if (isset($release_date_game)){
                                                //$release_date_game = str_replace('-', '/', $release_date_game);
                                                $release_date_game = date('d-m-Y', strtotime($release_date_game));
                                            }?>
                                            <input onchange="parent.accesIframe2()" class="form-control"  name="release_date_game" type="text" placeholder="click to show datepicker" value="<?=$release_date_game?>"  id="datepicker<?=$e?>">
                                        </div>
                                        <div class="form-group">
                                            <label>Infos sur la sortie :</label>
                                            <textarea rows="4" onchange="parent.accesIframe2()" class="form-control" name="informations_game" id="informations_game_<?=$e+1?>"><?php if (isset($informations_game)){echo $informations_game;}?></textarea>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                            <div class="form-group">
                                <label>Caractéristiques :</label>
                                <textarea onchange="parent.accesIframe2()" class="form-control" name="characteristics_game" id="characteristics_game_<?=$e+1?>"><?php if (isset($characteristics_game)){echo $characteristics_game;}?></textarea>
                            </div>

                            <div class="form-group">
                                <label>Lien de téléchargement du jeu :</label>
                                <input onchange="parent.accesIframe2()" name="download_link_game" type="url" class="form-control" id="download_link_game_<?=$e+1?>" placeholder=" <?=$e?>" <?php if (isset($download_link_game)){echo "value='".$download_link_game."'";}?>>
                            </div>

                            <input type="hidden" name="id_platform" value="<?php if (isset($id_platform)){echo $id_platform;}?>">
                            <input type="hidden" name="id_game" value="<?php if (isset($id_game)){echo $id_game;}?>">
                            <!--<button class="btn btn-lg btn-primary col-sm-9">Enregister</button>-->
                        </form>
                        <form name="deletes<?=$e?>" action="?action=delete&id_game=<?= $id_game ?>&id_platform=<?= $id_platform ?>" method="post" >
                            <input type="hidden" name="id_platform" value="<?php if (isset($id_platform)){echo $id_platform;}?>">
                            <input type="hidden" name="id_game" value="<?php if (isset($id_game)){echo $id_game;}?>">
                            <!--<button type="submit" class="btn btn-danger" onclick="return confirm('Êtes-vous sûr de votre choix ?')">Supprimer</button>-->
                        </form>

                        <div class="btn-group btn-group-justified" style="margin-top: 20px" aria-label="enregistre" role="group">
                            <div class="btn-group" role="group">
                                <button class="btn btn-primary" onClick="document.forms.saves<?=$e?>.submit()">Enregister</button>
                            </div>
                            <div class="btn-group" role="group">
                                <button class="btn btn-danger" name="delete" onClick="confirm('Êtes-vous sûr de votre choix ?'),document.forms.deletes<?=$e?>.submit()">Supprimer</button>
                            </div>
                        </div>
                    </div>
                    <?php
                    $e=$e+1;
                }  ?>
        </td>
        </div>

    </tr>

</body>
</html>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
<script src="../../../../public/js/lib/ckeditor/ckeditor.js"></script>
<script src="../../../../public/js/bootstrap-datepicker.js"></script>
<script src="../../../../public/js/bootstrap-tabs-x.js" type="text/javascript"></script>
<script type="text/javascript">
    $(document).ready(function () {
        <?php
        //print_r($_POST['tab']) ;
         if (isset($_POST['tab']) && $_POST['tab'] != ""){
        //var_dump($_POST['tab']);
        ?>
        $( "#tab<?=$_POST['tab']?>" ).first().addClass( "active" );
        $( "#<?=$_POST['tab']?>" ).first().addClass( "tab-pane fade form-group active in" );
        <?php }else{?>
        $( "#tab0" ).first().addClass( "active" );
        $( "#0" ).first().addClass( "tab-pane fade form-group active in" );

        <?php } ?>
        $('#datepicker0,#datepicker1,#datepicker2,#datepicker3,#datepicker4,#datepicker5,#datepicker6,#datepicker7,#datepicker8,#datepicker9,#datepicker10,#datepicker11,#datepicker12,#datepicker13,#datepicker14,#datepicker15,#datepicker16,#datepicker17,#datepicker18,#datepicker19').datepicker({
            format: "dd-mm-yyyy"
        });
        <?php for ($i = 1; $i <= $countPlatform; $i++) { ?>
        CKEDITOR.replace('characteristics_game_<?=$i?>');
        <?php } ?>
    });
</script>


