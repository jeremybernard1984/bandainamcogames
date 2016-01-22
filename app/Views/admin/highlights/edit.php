<?php  require ROOT . '/app/Views/templates/INC/inc_params_edit.php' ?>
<form method="post" action="<?=$redirect?>" name="editForm" enctype="multipart/form-data">
    <div class="col-lg-12">
        <h1>
            Edit highlight
        </h1>
        <ol class="breadcrumb">
            <li>
                <a href="index.php?p=admin.dashboards.index">Dashboard</a>
            </li>
            <li>
                <a href="index.php?p=admin.highlights.index"><?=$tableEncours?> list</a>
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
        </div>
    </div>
    <div class="col-lg-12">
        <div class="col-lg-4">
            <div class='form-group'>
                <?= $form->select('game_id_join_1', 'link game', $games); ?>
            </div>
            <div class='form-group' style="text-align: center;">
                <?php if (isset($highlight->background_highlight_1)){ ?>
                    <div style="width: 100%;height: 130px;background: url('images/highlights/backgrounds/<?=$highlight->background_highlight_1?>?<?=time()?>') no-repeat center #e1e1e8;background-size: contain;"></div>
                <?php } ?>
                <?= $form->input('background_highlight_1', 'Background picture 1', ['type' => 'file']); ?>
            </div>
        </div>
        <div class="col-lg-4">
            <div class='form-group'>
                <?= $form->select('game_id_join_2', 'link game 2', $games); ?>
            </div>
            <div class='form-group' style="text-align: center;">
                <?php if (isset($highlight->background_highlight_2)){ ?>
                    <div style="width: 100%;height: 130px;background: url('images/highlights/backgrounds/<?=$highlight->background_highlight_2?>?<?=time()?>') no-repeat center #e1e1e8;background-size: contain;"></div>
                <?php } ?>
                <?= $form->input('background_highlight_2', 'Background picture 2', ['type' => 'file']); ?>
            </div>
        </div>
        <div class="col-lg-4">
            <div class='form-group'>
                <?= $form->select('game_id_join_3', 'link game 3', $games); ?>
            </div>
            <div class='form-group' style="text-align: center;">
                <?php if (isset($highlight->background_highlight_3)){ ?>
                    <div style="width: 100%;height: 130px;background: url('images/highlights/backgrounds/<?=$highlight->background_highlight_3?>?<?=time()?>') no-repeat center #e1e1e8;background-size: contain;"></div>
                <?php } ?>
                <?= $form->input('background_highlight_3', 'Background picture 3', ['type' => 'file']); ?>
            </div>
        </div>
    </div>
</form>
