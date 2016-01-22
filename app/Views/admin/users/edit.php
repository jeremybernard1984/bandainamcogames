<?php  require ROOT . '/app/Views/templates/INC/inc_params_edit.php' ?>
            <?php // Javascript generation du MDP ?>
            <script>
                var keylist="abcdefghijklmnopqrstuvwxyz123456789"
                var temp=''

                function generatepass(plength){
                    temp=''
                    for (i=0;i<plength;i++)
                        temp+=keylist.charAt(Math.floor(Math.random()*keylist.length))
                    return temp
                }

                function populateform(enterlength){
                    document.editForm.password.value=generatepass(enterlength)
                }
            </script>

            <form method="post" action="<?=$redirect?>" name="editForm" enctype="multipart/form-data">
                <div class="col-lg-12">
                    <h1>
                        Edit users : <span class="sousTitle"><?php if(isset($user->name_user)){echo $user->name_user;}?></span>
                    </h1>
                    <ol class="breadcrumb">
                        <li>
                            <a href="index.php?p=admin.dashboards.index">Dashboard</a>
                        </li>
                        <li>
                            <a href="index.php?p=admin.users.index"><?=$tableEncours?> list</a>
                        </li>
                        <li class="active">
                            <?=$tableEncours?> edit
                        </li>
                    </ol>
                </div>
                <div id="menu_save" style="z-index:9;background-color: #353535 ">
                    <div class="btn btn-group" style="float: right;" aria-label="enregistre" role="group">
                        <div class="btn-group" role="group">
                            <button class="btn btn-primary" value="one" onClick="document.forms.editForm.submit()">Save user</button>
                        </div>
                    </div>
                </div>

                <div class="col-lg-12">
                    <div class="col-lg-6">
                        <div class='form-group col-lg-12'>
                            <?= $form->input('actif', '', ['type' => 'radio']); ?>
                        </div>
                        <div class='form-group col-lg-12'>
                            <?= $form->input('name_user', 'Name'); ?>
                        </div>
                        <div class='form-group col-lg-12'>
                            <?= $form->input('surname_user', 'Surame'); ?>
                        </div>
                        <div class='form-group col-lg-12'>
                            <?= $form->select('lang', 'Country', $allLangs); ?>
                        </div>
                        <?php if ($_SESSION['level']=='1'){ ?>
                        <div class='form-group col-lg-12'>
                            <label>Level</label>
                            <select class="form-control" name="admin_user">
                                <option value="1" <?php if (isset($user->admin_user) == "1"){ echo "selected"; } ?>>Super sayen</option>
                                <option value="2" <?php if (isset($user->admin_user)  == "2"){ echo "selected"; } ?>>Sayen</option>
                                <option value="3" <?php if (isset($user->admin_user)  == "3"){ echo "selected"; } ?>>Human</option>
                            </select>
                        </div>
                        <?php } ?>
                    </div>

                    <div class="col-lg-6">
                        <div class='form-group col-lg-12'>
                            <?= $form->input('mail_user', 'Mail', ['type' => 'mail']); ?>
                        </div>
                        <div class='form-group col-lg-12'>
                            <?= $form->input('resum_user', 'Note', ['type' => 'textarea']); ?>
                        </div>
                        <div class='form-group col-lg-12'>
                            <label>New password</label>
                            <input class="form-control" type="text" name="password" />
                            <input type="hidden" name="thelength" value="20"> <!-- Value = nb carateres du MDP -->
                           <!-- old si non remplit utiser pour renvoyé le mdp en base -->
                            <input type="hidden" name="old_password" value="<?php if (!empty($user->password)){echo $user->password;};?>">
                            <input type="hidden" name="old_salt" value="<?php if (!empty($user->uniqueKey)){echo $user->uniqueKey;};?>">
                            <br>
                            <input class="btn btn-success" type="button" value="Generate Password" onClick="populateform(this.form.thelength.value)">
                        </div>

                    </div>
                </div>
            </form>


