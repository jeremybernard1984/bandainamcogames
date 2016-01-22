<?php
$id = $_GET['id'];
$tableEncours = $_GET['tableEncours'];
$folder = $_GET['folder'];
// getion de la taille des miniature selon la page (game, article, news...)
if ($tableEncours == "games") {
    $taille = "2";
}else{
    $taille = "4";
}
$pdo = new PDO('mysql:host=db601175712.db.1and1.com;dbname=db601175712','dbo601175712','Sdk56six', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION ));

$pathfiles = "../../../../public/images/".$tableEncours."/".$folder."/";


if (isset($_GET['action']) && $_GET['action'] == "delete"){
    $id_image = $_GET['id_videolink'];
    $image = $_POST['image'];
    $id_table = $_POST['id_table'];
    $filename = $pathfiles.$image."";
    $filename_thumbnail = $pathfiles."thumbnail_".$image."";
    if ($tableEncours == "games"){
        $reqDeleteImgBdd = "DELETE FROM videoslinks WHERE image_videolink = '" . $image ."'";
        $reqDeleteJoint = "DELETE FROM games_videoslinks WHERE id_videolink = " . $id_image . " AND id_game = " . $id;
    }elseif($tableEncours == "posts"){

    }elseif($tableEncours == "news"){
        $reqDeleteImgBdd = "DELETE FROM videoslinks WHERE image_videolink = '" . $image ."'";
        $reqDeleteJoint = "DELETE FROM news_videoslinks WHERE id_videolink = " . $id_image . " AND id_news = " . $id;
    }
    if (file_exists($filename) AND $id_table==$id) {
        @mkdir($filename, 0777, true);
        unlink($filename);
        @mkdir($filename_thumbnail, 0777, true);
        unlink($filename_thumbnail);
        $deleteImgImgBdd = $pdo->prepare($reqDeleteImgBdd);
        $deleteImgImgBdd->execute();
    }
    $deleteImgJoint = $pdo->prepare($reqDeleteJoint);
    $deleteImgJoint->execute();
    $_GET['action'] = "";
}

if (isset($_GET['action']) && $_GET['action'] == "modify"){
    $id_image = $_GET['id_videolink'];
    $titre = $_POST['title_videolink'];
    $link = $_POST['link_videolink'];
    if ($tableEncours == "games"){
        $location = "games";
        $reqUpdateJoint = "UPDATE games_videoslinks SET title ='" . $titre . "', link ='" . $link . "', date_update = NOW() WHERE id_videolink = " . $id_image . " AND id_game = " . $id;
    }elseif($tableEncours == "posts"){

    }elseif($tableEncours == "news"){
        $location = "news";
        //var_dump($_POST);
        $reqUpdateJoint = "UPDATE news_videoslinks SET title ='" . $titre . "', link ='" . $link . "', date_update = NOW() WHERE id_videolink = " . $id_image . " AND id_news = " . $id;
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

    <title>Page upload vidéos</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css" rel="stylesheet">
    <style rel="stylesheet">
        #miniatures {margin-bottom: 10px}
        #miniatures input,#miniatures textarea{font-size: 11px;}
        #miniatures input{font-weight: bold;}
    </style>

</head>
<body onload="parent.accesIframe1()">
<div class="col-sm-12">
        <?php
        if ($tableEncours == "games"){
            $resultats=$pdo->query("SELECT * FROM videoslinks LEFT JOIN games_videoslinks ON videoslinks.id = games_videoslinks.id_videolink WHERE games_videoslinks.id_game= ".$id." ORDER BY id desc");
        }elseif($tableEncours == "posts"){

        }elseif($tableEncours == "news"){
            $resultats=$pdo->query("SELECT * FROM videoslinks LEFT JOIN news_videoslinks ON videoslinks.id = news_videoslinks.id_videolink WHERE news_videoslinks.id_news= ".$id." ORDER BY id desc");
        }
        $resultats->setFetchMode(PDO::FETCH_OBJ);
        //Calcule du nombre d'enregistrements
        $countImages = $resultats->rowCount();
        echo "<input type='hidden' id='nbr1' value='".$countImages."'/>";
        $cpt=1;
        while( $resultat = $resultats->fetch() )
        {
            //$id = $resultat->id;
            $idImg = $resultat->id_videolink;
            $image = $resultat->image_videolink;
            $titre = $resultat->title;
            $link = $resultat->link;
            $id_table = $resultat->id_table;
            ?>
            <div id="miniatures" class="col-sm-<?=$taille?>" style="font-size: 11px;">
                <form name="saves<?=$cpt?>" action="?action=modify&id=<?= $id ?>&id_videolink=<?= $idImg ?>&tableEncours=<?=$tableEncours?>&folder=<?=$folder?>" method="post" style="display: inline;">
                    <input onchange="parent.accesIframe1()" name="title_videolink" style="margin-bottom:4px;" id="titre_videolink_<?= $cpt ?>" class="form-control" type="text" placeholder="Titre de l'image" value="<?= $titre ?>">
                    <div style="width: 100%;height: 80px;background: url('<?= $pathfiles.$image ?>') no-repeat center #e1e1e8;background-size: contain;"></div>
                        <input type="hidden" id="id_videolink_<?= $cpt ?>" name="id_videolink_<?= $cpt ?>" value="<?= $idImg ?>" class="form-control">
                    <input type="url" id="link_videolink_<?= $cpt ?>" placeholder="link" onchange="parent.accesIframe1()" value="<?= $link ?>" name="link_videolink" style="margin-bottom:4px;width:100%;padding:5px;">
                </form>
                    <form name="deletes<?=$cpt?>" action="?action=delete&id=<?= $id ?>&id_videolink=<?= $idImg ?>&tableEncours=<?=$tableEncours?>&folder=<?=$folder?>" method="post" style="display: inline;">
                        <input type="hidden" name="id_videolink" value="<?= $idImg ?>">
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