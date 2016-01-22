<?php  require ROOT . '/app/Views/templates/INC/inc_params_edit.php' ?>
    <form method="post" action="<?=$redirect?>" name="gameForm" enctype="multipart/form-data">
    <div class="col-lg-12">
        <h1>
            Edit game : <span class="sousTitle"><?php if(isset($game->title_game)){echo $game->title_game;}?></span>
        </h1>
        <ol class="breadcrumb">
            <li>
                 <a href="index.php?p=admin.dashboards.index">Dashboard</a>
            </li>
            <li>
                 <a href="index.php?p=admin.games.index">Games list</a>
            </li>
            <li class="active">
                 Game edit
            </li>
        </ol>
    </div>
    <div id="menu_save" style="z-index:9;background-color: #353535 ">
        <div class="btn btn-group" style="float: right;" aria-label="enregistre" role="group">
            <div class="btn-group" role="group">
                <button class="btn btn-primary" value="one" onClick="document.forms.gameForm.submit()">Save the game</button>
            </div>
            <div class="btn-group" role="group">
                <button class="btn btn-success" name="BtAllLang" <?=$btAllDisabled?> value="all" onClick="document.forms.gameForm.submit()">Save the game in all selected languages</button>
            </div>
        </div>
    </div>

    <div class="col-lg-12">
        <?php  require ROOT . '/app/Views/templates/INC/inc_menuLangArt.php' ?>
    </div>

        <div class="col-lg-5">
            <div class='form-group col-lg-12'>
                <?= $form->input('actif', '', ['type' => 'radio']); ?>
            </div>
            <div class='form-group col-lg-12'>
                <?= $form->input('title_game', 'Tire du jeux'); ?>
            </div>

            <div class='form-group col-lg-12'>
                <?= $form->input('description_game', 'Description', ['type' => 'textarea']); ?>
            </div>

            <div class='form-group col-lg-6'>
                <?= $form->select('category_id', 'Catégorie', $categories); ?>
            </div>
            <div class='form-group col-lg-6'>
                <?= $form->select('id_developer', 'Développeur', $developers); ?>
            </div>
            <div class='form-group col-lg-6'>
                <?= $form->select('id_publisher', 'Éditeur', $publishers); ?>
            </div>
            <div class='form-group col-lg-6'>
                <?= $form->select('id_family', 'Famille', $families); ?>
            </div>
            <div class='form-group col-lg-6'>
                <?= $form->select('id_genre', 'Genre', $genres); ?>
            </div>
            <div class='form-group col-lg-6'>
                <?= $form->input('numbers_gamers_game', 'Nombre de joueurs', ['type' => 'number']); ?>
            </div>
            <div class='form-group col-lg-6'>
                <?= $form->input('link_website_game', 'Site web du jeu', ['type' => 'url']); ?>
            </div>
            <div class='form-group col-lg-6'>
                <?= $form->input('link_facebook_game', 'Facebook du jeu', ['type' => 'url']); ?>
            </div>
            <div class='form-group col-lg-12'>
                <?= $form->input('copyright_game', 'Copyright du jeu', ['type' => 'textarea']); ?>
            </div>
            <div class='form-group col-lg-6' style="text-align: center;">
                <?php if (isset($game->copyright_logo_game)){ ?>
                    <div style="width: 100%;height: 130px;background: url('images/games/Copyrights/<?=$game->copyright_logo_game?>?<?=time()?>') no-repeat center #e1e1e8;background-size: contain;"></div>
                <?php } ?>
                <?= $form->input('copyright_logo_game', 'copyright logo', ['type' => 'file']); ?>
            </div>

            <div class='form-group col-lg-6' style="text-align: center;">
                <?php if (isset($game->banner_game)){ ?>
                    <div style="width: 100%;height: 130px;background: url('images/games/banners/<?=$game->banner_game?>?<?=time()?>') no-repeat center #e1e1e8;background-size: contain;"></div>
                <?php } ?>
                <?= $form->input('banner_game', 'Game\'s banner', ['type' => 'file']); ?>
            </div>

        </div>
        <div class="col-lg-7">


            <div class='form-group' style="text-align: center">
                <label>Sélectionner les platforms pour ce jeu</label>
                <div class="btn-group btn-group" data-toggle="buttons" style="width: 100%;" >
                    <?php
                    echo $form->checkbox2('ChoixPlatform[]', $allPlatforms, $platformsCheck);
                    ?>
                </div>
                <br>
            </div>

            <?= $form->input('lang', '', ['type' => 'hidden']); ?>
            <?= $form->input('id_group_lang', '', ['type' => 'hidden']); ?>

            <!-- ----------------------GERER LES IMAGES UPLOADER-------------------------- -->
            <?php
            if($platformsCheck != ''){
               // include_once('../app/Views/admin/INC/inc_PlatformsGameLies.php');?>
                <div class='form-group'>
                    <span id='telecharger' style='text-align:center;padding:5px;clear: both;' class='col-sm-12'>
                       <span id='nbr_platform'></span>
                    </span>
                    <iframe onload="accesIframe2()" src="../app/Views/admin/IFRAMES/iframe_platforms.php?id_game=<?=$idExist?>" name="myFrame2" id="myFrame2" scrolling="auto" frameborder="0" style="width: 100%;min-height: 745px;border-top:1px solid #e1e1e8;border-bottom:1px solid #e1e1e8;"></iframe>
                    <div id="platform_chps"></div>
                </div>
            <?php }
            if ($btAllDisabled == ''){ ?>
                <div class='form-group' style="text-align: center">
                    <label>Sélectionner les langues du jeu :</label>
                    <div class="btn-group btn-group-justified" data-toggle="buttons" style="width: 100%;
                    " >
                        <?=$form->checkbox('ChoixLang[]', $allLangs, $langs)?>
                    </div>
                    <br>
                </div>
            <?php
            } ?>
        </div>
        <div class="col-lg-12">
            <?php
            if ($idExist != ''){ ?>
                <div class='tabs-x tabs-above' style="margin-top: 20px">
                    <ul id="Tab" class="nav nav-tabs" role="tablist">
                        <li class="active"><a href="#TabCaptures" role="tab" data-toggle="tab">Captures d'écran du jeu</a></li>
                        <li><a href="#TabVideos" role="tab-kv" data-toggle="tab">Vidéos du jeu</a></li>
                        <li><a href="#TabDownloads" role="tab-kv" data-toggle="tab">Téléchargements du jeu</a></li>
                        <li><a href="#TabClassification" role="tab-kv" data-toggle="tab">Classifications du jeu</a></li>
                    </ul>
                    <div id="myTabContent-1" class="tab-content">
                        <div class="tab-pane fade in active" id="TabCaptures" style="text-align: center">
                            <a class="btn btn-success fancyboxiframe fancybox.iframe" href="../app/Views/admin/ImagesUpload.php?id=<?=$idExist?>&tableEncours=<?=$tableEncours?>&folder=captures">Télécharger des captures</a>
                            <div class='form-group'>
                                <span id='telecharger' style='text-align:center;padding:5px;clear: both;' class='col-sm-12'>
                                    <span id='nbr_image'></span>
                                </span>
                                <iframe onload="accesIframe()" src="../app/Views/admin/IFRAMES/iframe_captures.php?id=<?=$idExist?>&tableEncours=<?=$tableEncours?>&folder=captures&action=''" name="myFrame" id="myFrame" scrolling="auto" frameborder="0" style="width: 100%;height: 630px"></iframe>
                                <div id="captures_chps"></div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="TabVideos" style="text-align: center">
                            <a class="btn btn-success fancyboxiframe fancybox.iframe" href="../app/Views/admin/ImagesUpload.php?id=<?=$idExist?>&tableEncours=<?=$tableEncours?>&folder=videoslinks">Télécharger des vidéos</a>
                            <div class='form-group'>
                                <span id='telecharger' style='text-align:center;padding:5px;clear: both;' class='col-sm-12'>
                                    <span id='nbr_videoslinks'></span>
                                </span>
                                <iframe onload="accesIframe1()" src="../app/Views/admin/IFRAMES/iframe_videoslinks.php?id=<?=$idExist?>&tableEncours=<?=$tableEncours?>&folder=videoslinks&action=''" name="myFrame1" id="myFrame1" scrolling="auto" frameborder="0" style="width: 100%;height: 630px"></iframe>
                                <div id="videoslinks_chps"></div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="TabDownloads" style="text-align: center">
                            <a class="btn btn-success fancyboxiframe fancybox.iframe" href="../app/Views/admin/ImagesUpload.php?id=<?=$idExist?>&tableEncours=<?=$tableEncours?>&folder=downloads">Téléchargements</a>
                            <div class='form-group'>
                                <span id='telecharger' style='text-align:center;padding:5px;clear: both;' class='col-sm-12'>
                                    <span id='nbr_downloads'></span>
                                </span>
                                <iframe onload="accesIframe4()" src="../app/Views/admin/IFRAMES/iframe_downloads.php?id=<?=$idExist?>&action=''" name="myFrame4" id="myFrame4" scrolling="auto" frameborder="0" style="width: 100%;height: 630px"></iframe>
                                <div id="downloads_chps"></div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="TabClassification">
                            <div class='form-group'>
                                <span id='test' style='text-align:center;padding:5px;clear: both;' class='col-sm-12'>
                                    <span id='nbr_classifications'></span>
                                </span>
                                <iframe onload="accesIframe3()" src="../app/Views/admin/IFRAMES/iframe_classifications.php?id=<?=$idExist?>&action=''" name="myFrame3" id="myFrame3" scrolling="auto" frameborder="0" style="width: 100%;height: 630px"></iframe>
                                <div id="classifications_chps"></div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>

        </div>
    </form>
