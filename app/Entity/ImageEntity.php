<?php
namespace App\Entity;

use Core\Entity\Entity;

class ImageEntity extends Entity{

public function getImgArt(){
    $html = '
    <table class="col-sm-6" style="float: left;margin-bottom: 5px">
        <tr>
            <th class="col-sm-12" scope="col" style="width: 130px">
                <img width="125px" src="images/'.$image.'"/>
            </th>
            <th scope="col">
                <div class="form-group">
                    <input type="hidden" name="id_image_'.$cpt.'" value="'.$id.'">
                    <input name="titre_image_'.$cpt.'" style="margin-bottom:4px;" id="titre_image_'.$cpt.'" class="form-control" type="text" placeholder="Titre de l\'image" value="'.$titre.'">
                    <textarea name="legende_image_'.$cpt.'" style="margin-bottom:4px;" class="form-control" placeholder="Légende" rows="2">'.$legende.'</textarea>
                    <input name="lien_image_'.$cpt.'" style="margin-bottom:4px;" id="lien_image_'.$cpt.'" class="form-control" type="text" placeholder="Lien (URL)" value="'.$lien.'">
                    <a class="btn btn-danger" style="float: right;" href="javascript: if (confirm("Continue?")) { window.location.href="../app/Views/admin/AJAX/ajaxDelete.php?id_image='.$image_article->id.'&id_article='.$idExist.'" } else { void("") }; ">Supprimer l\'image</a>
                </div>
            </th>
        </tr>
    </table>
';
return $html;
}
}