<?php  require ROOT . '/app/Views/templates/INC/inc_params_edit.php' ?>
            <form method="post" action="<?=$redirect?>" name="editForm" enctype="multipart/form-data">
                <div class="col-lg-12">
                    <h1>
                        Edit pages : <span class="sousTitle"><?php if(isset($page->title_page)){echo $page->title_page;}?></span>
                    </h1>
                    <ol class="breadcrumb">
                        <li>
                            <a href="index.php?p=admin.dashboards.index">Dashboard</a>
                        </li>
                        <li>
                            <a href="index.php?p=admin.pages.index"><?=$tableEncours?> list</a>
                        </li>
                        <li class="active">
                            <?=$tableEncours?> edit
                        </li>
                    </ol>
                </div>
                <div id="menu_save" style="z-index:9;background-color: #353535 ">
                    <div class="btn btn-group" style="float: right;" aria-label="enregistre" role="group">
                        <div class="btn-group" role="group">
                            <button class="btn btn-primary" value="one" onClick="document.forms.editForm.submit()">Save</button>
                        </div>
                        <div class="btn-group" role="group">
                            <button class="btn btn-success" name="BtAllLang" <?=$btAllDisabled?> value="all" onClick="document.forms.editForm.submit()">Save in all selected languages</button>
                        </div>
                    </div>
                </div>

                <div class="col-lg-12">
                    <?php  require ROOT . '/app/Views/templates/INC/inc_menuLangArt.php' ?>
                </div>
                <?= $form->input('lang', '', ['type' => 'hidden']); ?>
                <?= $form->input('id_group_lang', '', ['type' => 'hidden']); ?>
                <div class="col-lg-7">
                    <div class='form-group col-lg-12'>
                        <?= $form->input('actif', '', ['type' => 'radio']); ?>
                    </div>
                    <div class='form-group col-lg-12'>
                        <?= $form->input('title_page', 'title'); ?>
                    </div>
                    <div class='form-group col-lg-12'>
                        <?= $form->input('resum_page', 'resum', ['type' => 'textarea']); ?>
                    </div>
                    <div class='form-group col-lg-12'>
                        <?= $form->input('description_page', 'Description', ['type' => 'textarea']); ?>
                    </div>

                </div>
                <div class="col-lg-5">
                    <?= $form->input('lang', '', ['type' => 'hidden']); ?>
                    <?= $form->input('id_group_lang', '', ['type' => 'hidden']); ?>
                    <?php
                    if ($btAllDisabled == ''){ ?>
                    <div class='form-group' style="text-align: center">
                        <label>Sélectionner les langues du jeu :</label>
                        <div class="btn-group btn-group-justified" data-toggle="buttons" style="width: 100%;" >
                            <?=$form->checkbox('ChoixLang[]', $allLangs, $langs)?>
                        </div>
                        <br>
                    </div>
                    <?php
                    } ?>
                    <!-- ----------------------GERER LES IMAGES UPLOADER-------------------------- -->
                    <?php
                    if ($idExist != ''){ ?>
                        <div class='tabs-x tabs-above' style="margin-top: 20px">
                            <ul id="Tab" class="nav nav-tabs" role="tablist">
                                <li class="active"><a href="#TabCaptures" role="tab" data-toggle="tab">Pictures</a></li>
                            </ul>
                            <div id="myTabContent-1" class="tab-content">
                                <div class="tab-pane fade in active" id="TabCaptures" style="text-align: center">
                                    <a class="btn btn-success fancyboxiframe fancybox.iframe" href="../app/Views/admin/ImagesUpload.php?id=<?=$idExist?>&tableEncours=<?=$tableEncours?>&folder=images">Télécharger des images</a>
                                    <div class='form-group'>
                                <span id='telecharger' style='text-align:center;padding:5px;clear: both;' class='col-sm-12'>
                                    <span id='nbr_image'></span>
                                </span>
                                        <iframe onload="accesIframe()" src="../app/Views/admin/IFRAMES/iframe_captures.php?id=<?=$idExist?>&tableEncours=<?=$tableEncours?>&folder=images&action=''" name="myFrame" id="myFrame" scrolling="auto" frameborder="0" style="width: 100%;height: 630px"></iframe>
                                        <div id="captures_chps"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </form>
