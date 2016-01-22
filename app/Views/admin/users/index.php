<div class="col-lg-12">
    <h1>
        List of users :
    </h1>
    <ol class="breadcrumb">
        <li>
            <a href="?p=admin.dashboards.index">Dashboard</a>
        </li>
        <li>
            <a href="?p=admin.users.index">users list</a>
        </li>
    </ol>
</div>
<div class="col-lg-12">
        <div class="table-responsive">
            <?php if ($_SESSION['level']=='1'){ ?>
                <p><a href="?p=admin.users.add" class="btn btn-success">Add</a></p>
            <?php } ?>
            <table class="table table-bordered table-hover" style="text-align: center">
            <thead>
            <tr>
                <td>Visible</td>
                <td>ID</td>
                <td>Country</td>
                <td>Name</td>
                <td>Mail</td>
                <td>Actions</td>

            </tr>
            </thead>
            <tbody>
            <?php foreach($users as $user): ?>
                <tr>
                    <?php $online=$user->actif; ?>
                    <td><?php if($online == '1'){ echo "<i class='fa fa-eye fa-lg'></i>";} else{echo '-';} ?></td>
                    <td><?= $user->id; ?></td>
                    <td><img src="images/flags/32/<?= $user->lang; ?>.png"></td>
                    <td><?= $user->surname_user; ?> <?= $user->name_user; ?></td>
                    <td><?= $user->mail_user; ?></td>
                    <td>
                        <?php if ($_SESSION['level']=='1'){ ?>
                        <a class="btn btn-primary" href="?p=admin.users.edit&id=<?= $user->id; ?>">Edit</a>
                        <form action="?p=admin.users.delete" method="post" style="display: inline;">
                            <input type="hidden" name="id" value="<?= $user->id ?>">
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Êtes-vous sûr de votre choix ?')">Delete</button>
                        </form>
                        <?php } ?>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>

</div>