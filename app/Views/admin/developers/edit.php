
<form method="post" name="editForm" >
    <div class="col-lg-12">
        <h1>
            Edit developer
        </h1>
        <ol class="breadcrumb">
            <li>
                <a href="index.php?p=admin.dashboards.index">Dashboard</a>
            </li>
            <li>
                <a href="index.php?p=admin.pages.index">Developers list</a>
            </li>
            <li class="active">
                Developers edit
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
        <div class="col-lg-6">
            <div class="input-group input-group-lg">
                <span class="input-group-addon"><img src='images/flags/24/EU.png'/></span>
                <?= $form->input('name_developer_EU', ''); ?>
            </div><br>
            <div class="input-group input-group-lg">
                <span class="input-group-addon"><img src='images/flags/24/FR.png'/></span>
                <?= $form->input('name_developer_FR', ''); ?>
            </div><br>
            <div class="input-group input-group-lg">
                <span class="input-group-addon"><img src='images/flags/24/GB.png'/></span>
                <?= $form->input('name_developer_GB', ''); ?>
            </div><br>
            <div class="input-group input-group-lg">
                <span class="input-group-addon"><img src='images/flags/24/DE.png'/></span>
                <?= $form->input('name_developer_DE', ''); ?>
            </div><br>
            <div class="input-group input-group-lg">
                <span class="input-group-addon"><img src='images/flags/24/IT.png'/></span>
                <?= $form->input('name_developer_IT', ''); ?>
            </div><br>
        </div>
        <div class="col-lg-6">
            <div class="input-group input-group-lg">
                <span class="input-group-addon"><img src='images/flags/24/ES.png'/></span>
                <?= $form->input('name_developer_ES', ''); ?>
            </div><br>
            <div class="input-group input-group-lg">
                <span class="input-group-addon"><img src='images/flags/24/SG.png'/></span>
                <?= $form->input('name_developer_SG', ''); ?>
            </div><br>
            <div class="input-group input-group-lg">
                <span class="input-group-addon"><img src='images/flags/24/AE.png'/></span>
                <?= $form->input('name_developer_AE', ''); ?>
            </div><br>
            <div class="input-group input-group-lg">
                <span class="input-group-addon"><img src='images/flags/24/AU.png'/></span>
                <?= $form->input('name_developer_AU', ''); ?>
            </div><br>
        </div>
    </div>
</form>