<?php
$id = $_GET['id'];
$tableEncours = $_GET['tableEncours'];
$folder = $_GET['folder'];
// getion de la taille des miniature selon la page (game, article, news...)
if ($tableEncours == "games") {
    $taille = "2";
}elseif ($tableEncours == "pages") {
    $taille = "6";
}else{
    $taille = "4";
}
$pdo = new PDO('mysql:host=db601175712.db.1and1.com;dbname=db601175712','dbo601175712','Sdk56six', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION ));

$pathfiles = "../../../../public/images/".$tableEncours."/".$folder."/";


if (isset($_GET['action']) && $_GET['action'] == "delete"){
    $id_image = $_GET['id_capture'];
    $image = $_POST['image'];
    $id_table = $_POST['id_table'];

    // MODIF des chemins
    $filename = $pathfiles.$image."";
    $filename_thumbnail = $pathfiles."thumbnail_".$image."";
    //var_dump($filename);
    // Je vérifie que l'image a bien été créé par ce cet ID de jeu,article,news... avant de supprimer !!!

    if ($tableEncours == "games"){
        $reqDeleteImgBdd = "DELETE FROM captures WHERE image_capture = '" . $image ."'";
        $reqDeleteJoint = "DELETE FROM games_captures WHERE id_capture = " . $id_image . " AND id_game = " . $id;
    }elseif($tableEncours == "posts"){

    }elseif($tableEncours == "news"){
        $reqDeleteImgBdd = "DELETE FROM images WHERE image_image = '" . $image ."'";
        $reqDeleteJoint = "DELETE FROM news_images WHERE id_image = " . $id_image . " AND id_news = " . $id;
    }elseif($tableEncours == "pages"){
        $reqDeleteImgBdd = "DELETE FROM images WHERE image_image = '" . $image ."'";
        $reqDeleteJoint = "DELETE FROM pages_images WHERE id_image = " . $id_image . " AND id_page = " . $id;
    }elseif($tableEncours == "demos"){
        $reqDeleteImgBdd = "DELETE FROM images WHERE image_image = '" . $image ."'";
        $reqDeleteJoint = "DELETE FROM demos_images WHERE id_image = " . $id_image . " AND id_demo = " . $id;
    }

    if (file_exists($filename) AND $id_table==$id) {
        @mkdir($filename, 0777, true);
        unlink($filename);
        @mkdir($filename_thumbnail, 0777, true);
        unlink($filename_thumbnail);
        $deleteImgImgBdd = $pdo->prepare($reqDeleteImgBdd);
        $deleteImgImgBdd->execute();
    }

    //var_dump($reqDeleteJoint);
    $deleteImgJoint = $pdo->prepare($reqDeleteJoint);
    $deleteImgJoint->execute();
    $_GET['action'] = "";
}
if (isset($_GET['action']) && $_GET['action'] == "modify"){
    $id_image = $_GET['id_capture'];
    $titre = $_POST['title_capture'];
    $legende = $_POST['legend_capture'];
    if ($tableEncours == "games"){
        $location = "games";
        $reqUpdateJoint = "UPDATE games_captures SET title ='" . $titre . "', legend ='" . $legende . "', date_update = NOW() WHERE id_capture = " . $id_image . " AND id_game = " . $id;
    }elseif($tableEncours == "posts"){

    }elseif($tableEncours == "news"){
        $location = "news";
        $reqUpdateJoint = "UPDATE news_images SET title ='" . $titre . "', legend ='" . $legende . "', date_update = NOW() WHERE id_image = " . $id_image . " AND id_news = " . $id;
    }elseif($tableEncours == "pages"){
        $location = "news";
        $reqUpdateJoint = "UPDATE pages_images SET title ='" . $titre . "', legend ='" . $legende . "', date_update = NOW() WHERE id_image = " . $id_image . " AND id_page = " . $id;
    }elseif($tableEncours == "demos"){
        $location = "demos";
        $reqUpdateJoint = "UPDATE demos_images SET title ='" . $titre . "', legend ='" . $legende . "', date_update = NOW() WHERE id_image = " . $id_image . " AND id_demo = " . $id;
    }
    //var_dump($reqUpdateJoint);die;
    $UpdateImgJoint = $pdo->prepare($reqUpdateJoint);
    $UpdateImgJoint->execute();
    $_GET['action'] = "";
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">

    <title>Page upload captures</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css" rel="stylesheet">
    <style rel="stylesheet">
        #miniatures {margin-bottom: 10px}
        #miniatures input,#miniatures textarea{font-size: 11px;}
        #miniatures input{font-weight: bold;}
    </style>

</head>
<body onload="parent.accesIframe()">
<div class="col-sm-12">
        <?php
        if ($tableEncours == "games"){
            $resultats=$pdo->query("SELECT * FROM captures LEFT JOIN games_captures ON captures.id = games_captures.id_capture WHERE games_captures.id_game= ".$id." ORDER BY id desc");
        }elseif($tableEncours == "posts"){

        }elseif($tableEncours == "news"){
            $resultats=$pdo->query("SELECT * FROM images LEFT JOIN news_images ON images.id = news_images.id_image WHERE news_images.id_news= ".$id." ORDER BY id desc");
        }elseif($tableEncours == "pages"){
            $resultats=$pdo->query("SELECT * FROM images LEFT JOIN pages_images ON images.id = pages_images.id_image WHERE pages_images.id_page= ".$id." ORDER BY id desc");
        }elseif($tableEncours == "demos"){
            $resultats=$pdo->query("SELECT * FROM images LEFT JOIN demos_images ON images.id = demos_images.id_image WHERE demos_images.id_demo= ".$id." ORDER BY id desc");
        }
        $resultats->setFetchMode(PDO::FETCH_OBJ);
        //Calcule du nombre d'enregistrements
        $countImages = $resultats->rowCount();
        echo "<input type='hidden' id='nbr' value='".$countImages."'/>";
        $cpt=1;
        while( $resultat = $resultats->fetch() )
        {
            $idImg = $resultat->id;
            if ($tableEncours == "games") {
                $image = $resultat->image_capture;
            }else{
                $image = $resultat->image_image;
            }
            $titre = $resultat->title;
            $legende = $resultat->legend;
            $id_table = $resultat->id_table;
            ?>
            <div id="miniatures" class="col-xs-<?=$taille?>" style="font-size: 11px;">
                <form name="saves<?=$cpt?>" action="?action=modify&id=<?= $id ?>&id_capture=<?= $idImg ?>&tableEncours=<?=$tableEncours?>&folder=<?=$folder?>" method="post" style="display: inline;">
                    <input name="title_capture" style="margin-bottom:4px;" id="titre_image_<?= $cpt ?>" class="form-control" type="text" placeholder="Titre de l'image" value="<?= $titre ?>" onchange="parent.accesIframe()">
                    <div style="width: 100%;height: 80px;background: url('<?= $pathfiles.$image ?>') no-repeat center #e1e1e8;background-size: contain;"></div>
                        <!--<img width="80px" src="../../../../public/images/games/captures/<?= $image ?>"/>-->
                        <input type="hidden" id="id_capture_<?= $cpt ?>" name="id_capture_<?= $cpt ?>" value="<?= $idImg ?>" class="form-control">
                    <textarea name="legend_capture" style="margin-bottom:4px;" class="form-control" id="legend_capture_<?= $cpt ?>" placeholder="Légende" rows="2" onchange="parent.accesIframe()"><?= $legende ?></textarea>
                    <!--<button type="submit" class="btn btn-primary">Enregister</button>-->

                </form>
                    <form name="deletes<?=$cpt?>" action="?action=delete&id=<?= $id ?>&id_capture=<?= $idImg ?>&tableEncours=<?=$tableEncours?>&folder=<?=$folder?>" method="post" style="display: inline;">
                        <input type="hidden" name="id_capture" value="<?= $idImg ?>">
                        <input type="hidden" name="image" value="<?= $image ?>">
                        <!-- PERMETTRA DE COMPARER SI LE JE ACTUEL EST LE CREATEUR DE l'image... SINON il ne peu pas supprimer l'image car utiliser ailleur -->
                        <input type="hidden" name="id_table" value="<?= $id_table ?>">
                    </form>
                    <div class="btn-group btn-group-justified" style="margin-top: 3px" aria-label="enregistre" role="group">
                        <div class="btn-group" role="group">
                            <button class="btn btn-primary" onClick="document.forms.saves<?=$cpt?>.submit()">Save</button>
                        </div>
                        <div class="btn-group" role="group">
                            <button class="btn btn-danger" name="delete" onClick="confirm('Êtes-vous sûr de votre choix ?'),document.forms.deletes<?=$cpt?>.submit()">Delete</button>
                        </div>
                    </div>
            </div>
            <?php
            $cpt=$cpt+1;
        }
        $resultats->closeCursor();
        ?>

</div>

</body>
</html>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js" type="text/javascript"></script>