<ul class="nav nav-tabs" style="margin-bottom: 30px">
<?php
if (isset($langs) AND ($langs != "") AND ($_SESSION['level']=='1')){
        foreach($langs as $lang):
                if ($_GET['id'] == $lang->id){$btActif="active";}else{$btActif="";} ?>
                <li role="presentation" class="<?=$btActif?>"><a href="?p=admin.<?=$tableEncours?>.edit&id=<?= $lang->id?>"><img src="images/flags/32/<?= $lang->lang?>.png"/></a></li>
        <?php endforeach;
}else{
        echo"<li role='presentation' class='active'><a href='#'><img src='images/flags/32/".$_SESSION['lang'].".png'/></a></li>";
}
?>
</ul>