<?php
if(isset($lastId)) {
    if (isset($tableEncours) && $tableEncours == 'games'){
        foreach($lastId as $game):
            $idExist = $game->id;
        endforeach;
    }
    if (isset($tableEncours) && $tableEncours == 'posts'){
        foreach($lastId as $post):
            //$idExist = $post->id;
        endforeach;
    }
    if (isset($tableEncours) && $tableEncours == 'pages'){
        foreach($lastId as $page):
            $idExist = $page->id;
        endforeach;
    }
    if (isset($tableEncours) && $tableEncours == 'news'){
        foreach($lastId as $new):
            $idExist = $new->id;
        endforeach;
    }
    if (isset($tableEncours) && $tableEncours == 'demos'){
        foreach($lastId as $demo):
            $idExist = $demo->id;
        endforeach;
    }
    if (isset($tableEncours) && $tableEncours == 'users'){
        foreach($lastId as $user):
            $idExist = $user->id;
        endforeach;
    }
};

if (!empty($idExist)){
    $redirect='?p=admin.'.$tableEncours.'.edit&id='.$idExist;
    if ($_SESSION['level']=='1'){
        $btAllDisabled="";
    }else{
        $btAllDisabled="disabled='disabled' style='background:#cecece;color:#333;border:1px solid #777;'";
    }
    echo "lolo";

}else{
    if(isset($_GET['id'])) {
        echo "titi";
        $idExist=$_GET['id'];
        echo $idExist;
        $redirect='?p=admin.'.$tableEncours.'.edit&id='.$idExist;
        // je compte si plusieurs langues pour activer le bt d'envoi de plusieurs langues
        $countLang = Count($langs);
        //echo $countLang;
        if($countLang > 1){
            $btAllDisabled="disabled='disabled' style='background:#cecece;color:#333;border:1px solid #777;'";
            echo "roro";
        }else{
            if ($_SESSION['level']=='1'){
                $btAllDisabled="";
            }else{
                $btAllDisabled="disabled='disabled' style='background:#cecece;color:#333;border:1px solid #777;'";
            }
        }

    }else{
        echo "toto";
        $idExist = "";
        $countImages="";
        $redirect ='?p=admin.'.$tableEncours.'.add';
        $btAllDisabled="disabled='disabled' style='background:#cecece;color:#333;border:1px solid #777;'";
    }
}
?>