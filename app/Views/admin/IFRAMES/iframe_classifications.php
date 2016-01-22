<?php
$id_game = $_GET['id'];
$pdo = new PDO('mysql:host=db601175712.db.1and1.com;dbname=db601175712','dbo601175712','Sdk56six', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION ));

if (isset($_GET['action']) && $_GET['action'] == "modify" && isset($_POST)){
    if (isset($_POST['choix_classification'])){
        $check_classifications = $_POST['choix_classification'];
        foreach ($check_classifications as $key => $value) {
            $id=$key+1 ;
            $reqUpdateJoint = "UPDATE games_classifications SET check_classification ='" . $value . "' WHERE id_classification = " . $id . " AND id_game = " . $id_game;
            $UpdateImgJoint = $pdo->prepare($reqUpdateJoint);
            $UpdateImgJoint->execute();
        }
    }else{

    }
    //var_dump($_POST);
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
        <title>Page classifications game</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
    </head>
    <body onload="parent.accesIframe3()">

    <div class="col-sm-12" style="text-align: center">
        <form action="?action=modify&id=<?= $id_game ?>" method="post">
            <button type="submit" class="btn btn-success" onchange="check()">Enregister</button>
            <?php
            $resultat=$pdo->query("SELECT * FROM classifications LEFT JOIN games_classifications ON classifications.id_classification = games_classifications.id_classification WHERE games_classifications.id_game=$id_game ORDER BY classifications.id_classification asc ");
            //$resultat=$pdo->query("SELECT * FROM classifications  ORDER BY id_classification asc");
            $resultat->setFetchMode(PDO::FETCH_OBJ);
            $countImages = $resultat->rowCount();
            echo "<input type='hidden' id='nbr3' value='".$countImages."'/>";
            $cpt=1;
            while( $resultats = $resultat->fetch() ) {
                $id_classification = $resultats->id_classification;
                $titre = $resultats->titre_classification;
                $image = $resultats->image_classification;
                $infos = $resultats->infos_classification;
                $check_classification = $resultats->check_classification;
                if ($check_classification==1){
                    $attributes = "active";
                    $attributes2 = "checked = 'checked'";
                    $check="1";
                }else{
                    $attributes = "";
                    $attributes2 = "";
                    $check="0";
                }
                if($cpt==1){?>
                    <h3>European classification (PEGI)</h3>
                    <div class="btn-group btn-group-justified" style="width: 100%; " data-toggle="buttons">
                <?php }?>
                <input type="hidden" style="display:none;" id="check_classification<?= $cpt ?>" name="choix_classification[]" value="<?=$check?>" />
                <input type="hidden" name="id_classification<?= $cpt ?>" id="id_classification<?= $cpt ?>" value="<?= $id_classification ?>">
                <label class="btn btn-default <?=$attributes?>">
                    <input type="checkbox" autocomplete="off" <?=$attributes2?> name="check_classification<?= $cpt ?>" onchange="javascript:checkBoxFunction('check_classification<?= $cpt ?>')">
                    <img title="<?=$image?>" width="70" src="../../../../public/images/classifications/<?= str_replace("_", "-", $image); ?>" >
                </label>
            <?php
                if($cpt==6){?>
                        </div>
                        <div class="btn-group btn-group-justified" style="width: 100%; " data-toggle="buttons">
                <?php
                }elseif($cpt==12){?>
                        </div>
                        <h3>singapur classification</h3>
                        <div class="btn-group btn-group-justified" style="width: 100%; " data-toggle="buttons">
                <?php
                }elseif($cpt==18){ ?>
                        </div>
                        <h3>Australian classification</h3>
                        <div class="btn-group btn-group-justified" style="width: 100%; " data-toggle="buttons">
                <?php
                }elseif($cpt==24){ ?>
                        </div>
            <?php
            }
            $cpt=$cpt+1;
            }
            $resultat->closeCursor();
            ?>


    </form>
    </div>



    </body>
    </html>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
    <script>
        function checkBoxFunction (checkBoxID) {
            var baliseChoix = document.getElementById(checkBoxID);
            if (baliseChoix.value == "0") {
                baliseChoix.value = "1";
                parent.accesIframe3();
            }
            else baliseChoix.value = "0";
            //
        }
    </script>
