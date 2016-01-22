<?php
$id_game = $_GET['id'];
$pdo = new PDO('mysql:host=db601175712.db.1and1.com;dbname=db601175712','dbo601175712','Sdk56six', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION ));
// fonction d'update d'image
function uploadImg($id_game,$id_download){
    array();
    $success = null;
    if (!empty($_FILES['link_download']['name'])){
        $ext = strtolower(pathinfo($_FILES['link_download']['name'], PATHINFO_EXTENSION));
        $pathfiles="../../../../public/images/games/downloads/";
        $name="file_game_".$id_game."_download_".$id_download*time().".".$ext."";
        if (!file_exists($pathfiles)) {
            mkdir($pathfiles, 0777, true);
        }
        move_uploaded_file($_FILES['link_download']["tmp_name"], $pathfiles.$name);
    }
}
// end function img

$pdo = new PDO('mysql:host=db601175712.db.1and1.com;dbname=db601175712','dbo601175712','Sdk56six', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION ));


if (isset($_GET['action']) && $_GET['action'] == "delete"){
    $id_image = $_GET['id_download'];
    $image = $_POST['image'];
    $file = $_POST['file'];
    $id_table = $_POST['id_table'];
    $filename = "../../../../public/images/games/downloads/".$image."";
    $filename_thumbnail = "../../../../public/images/games/downloads/thumbnail_".$image."";
    $filename_file = "../../../../public/images/games/downloads/".$file."";
    if (file_exists($filename) AND $id_table==$id_game) {
        @mkdir($filename, 0777, true);
        unlink($filename);
        @mkdir($filename_thumbnail, 0777, true);
        unlink($filename_thumbnail);
        @mkdir($filename_file, 0777, true);
        unlink($filename_file);
        $reqDeleteImgBdd = "DELETE FROM downloads WHERE id = " . $id_image;
        $deleteImgImgBdd = $pdo->prepare($reqDeleteImgBdd);
        $deleteImgImgBdd->execute();
    }
    $reqDeleteJoint = "DELETE FROM games_downloads WHERE id_download = " . $id_image . " AND id_game = " . $id_game;
    $deleteImgJoint = $pdo->prepare($reqDeleteJoint);
    $deleteImgJoint->execute();
    $_GET['action'] = "";
}
if (isset($_GET['action']) && $_GET['action'] == "modify"){
    $id_download = $_GET['id_download'];
    if(isset($_FILES['link_download'])){
        if (isset($_FILES) && $_FILES['link_download']['name'] != ""){
            $ext = strtolower(pathinfo($_FILES['link_download']['name'], PATHINFO_EXTENSION));
            $download_game="file_game_".$id_game."_download_".$id_download*time().".".$ext."";
            uploadImg($id_game,$id_download);
        }else{
            $download_game="";
        }
    }else{
        $download_game = $_POST['link_download'];
    }
    $titre = $_POST['title_download'];
    //$link = $_POST['link_download'];
    $location = "games";
    $reqUpdateJoint = "UPDATE games_downloads SET title ='" . $titre . "', link ='" . $download_game . "', date_update = NOW() WHERE id_download = " . $id_download . " AND id_game = " . $id_game;
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
<body onload="parent.accesIframe4()">
<div class="col-sm-12">
    <?php
    $resultats=$pdo->query("SELECT * FROM downloads LEFT JOIN games_downloads ON downloads.id = games_downloads.id_download WHERE games_downloads.id_game= ".$id_game." ORDER BY id desc");
    $resultats->setFetchMode(PDO::FETCH_OBJ);
    //Calcule du nombre d'enregistrements
    $countImages = $resultats->rowCount();
    echo "<input type='hidden' id='nbr4' value='".$countImages."'/>";
    $cpt=1;
    while( $resultat = $resultats->fetch() )
    {
        $id = $resultat->id;
        $image =$resultat->image_download;
        $titre = $resultat->title;
        $link = $resultat->link;
        $id_table = $resultat->id_table;
        ?>
        <div id="miniatures" class="col-sm-2" style="font-size: 11px;">
            <form name="saves<?=$cpt?>" action="?action=modify&id=<?= $id_game ?>&id_download=<?= $id ?>" method="post" style="display: inline;" enctype="multipart/form-data">
                <input onchange="parent.accesIframe4()" name="title_download" style="margin-bottom:4px;" id="titre_download_<?= $cpt ?>" class="form-control" type="text" placeholder="Titre de l'image" value="<?= $titre ?>">
                <div style="width: 100%;height: 80px;background: url('../../../../public/images/games/downloads/<?= $image ?>') no-repeat center #e1e1e8;background-size: contain;"></div>
                <!--<img width="80px" src="../../../../public/images/games/captures/<?= $image ?>"/>-->
                <input type="hidden" id="id_download_<?= $cpt ?>" name="id_download_<?= $cpt ?>" value="<?= $id ?>" class="form-control">
                <?php
                if ($link!=''){ ?>
                    <span style="padding: 8px 0;text-align: center;display: block"><a href="../../../../public/images/games/downloads/<?= $link ?>">Document à télécharger</a></span>
                    <input type="hidden" name="link_download" value="<?= $link ?>" id="link_download_<?= $cpt ?>">
                <?php
                }else{ ?>
                    <input style="margin-top:5px;" type="file" id="link_download_<?= $cpt ?>" onchange="parent.accesIframe4()" value="<?= $link ?>" name="link_download" style="margin-bottom:4px;">
                <?php } ?>
            </form>
            <form name="deletes<?=$cpt?>" action="?action=delete&id=<?= $id_game ?>&id_download=<?= $id ?>" method="post" style="display: inline;">
                <input type="hidden" name="id_download" value="<?= $id ?>">
                <input type="hidden" name="image" value="<?= $image ?>">
                <input type="hidden" name="file" value="<?= $link ?>">
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