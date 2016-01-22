<?php  require ROOT . '/app/Views/templates/INC/inc_params_edit.php' ?>
            <form method="post" action="<?=$redirect?>" name="editForm" enctype="multipart/form-data">
                <div class="col-lg-12">
                    <h1>
                        Edit demos : <span class="sousTitle"><?php if(isset($demo->title_page)){echo $demo->title_page;}?></span>
                    </h1>
                    <ol class="breadcrumb">
                        <li>
                            <a href="index.php?p=admin.dashboards.index">Dashboard</a>
                        </li>
                        <li>
                            <a href="index.php?p=admin.demos.index"><?=$tableEncours?> list</a>
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
                <div class="col-lg-6">
                    <div class='form-group'>
                        <?= $form->input('actif', '', ['type' => 'radio']); ?>
                    </div>
                    <div class='form-group'>
                        <?= $form->input('title_demo', 'Title'); ?>
                    </div>
                    <div class='form-group'>
                        <?= $form->input('subtitle_demo', 'Subtitle'); ?>
                    </div>
                    <div class='form-group'>
                        <?= $form->input('date_demo', 'Date', ['type' => 'datepicker']); ?>
                    </div>

                    <div class='form-group'>
                        <?= $form->select('game_id_join', 'link game', $games); ?>
                    </div>
                    <div class='form-group' style="text-align: center;">
                        <?php if (isset($demo->background_demo)){ ?>
                            <div style="width: 100%;height: 130px;background: url('images/demos/backgrounds/<?=$demo->background_demo?>?<?=time()?>') no-repeat center #e1e1e8;background-size: contain;"></div>
                        <?php } ?>
                        <?= $form->input('background_demo', 'Background picture', ['type' => 'file']); ?>
                    </div>

                </div>
                <div class="col-lg-6">
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
                    <div class='form-group'>
                        <?= $form->input('video_demo', 'Video demo link', ['type' => 'url']); ?>
                    </div>
                    <div class='form-group'>
                        <?= $form->input('website_link_demo', 'Official web site', ['type' => 'url']); ?>
                    </div>
                    <div class='form-group'>
                        <?= $form->input('apple_store_link_demo', 'Apple store link', ['type' => 'url']); ?>
                    </div>
                    <div class='form-group'>
                        <?= $form->input('google_play_store_link_demo', 'Google play store link', ['type' => 'url']); ?>
                    </div>
                    <div class='form-group'>
                        <?= $form->input('amazon_link_demo', 'Amazon link', ['type' => 'url']); ?>
                    </div>
                    <div class='form-group'>
                        <?= $form->input('web_link_demo', 'web link', ['type' => 'url']); ?>
                    </div>
                </div>
            </form>
