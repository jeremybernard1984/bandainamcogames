<div class="col-lg-12">
    <h1>
        List of developers :
    </h1>
    <ol class="breadcrumb">
        <li>
            <a href="?p=admin.dashboards.index">Dashboard</a>
        </li>
        <li>
            <a href="?p=admin.families.index">developers list</a>
        </li>
    </ol>
</div>
<div class="col-lg-12">
    <div class="table-responsive">
        <?php if ($_SESSION['level']=='1'){ ?>
            <p><a href="?p=admin.developers.add" class="btn btn-success">Add</a></p>
        <?php } ?>
        <table class="table table-bordered table-hover" style="text-align: center">
            <thead>
            <tr>
                <td>ID</td>
                <td>Titre</td>
                <td>Actions</td>
            </tr>
            </thead>
            <tbody>
                <?php foreach($items as $developer): ?>
                <tr>
                    <td><?= $developer->id; ?></td>
                    <td><?= $developer->name_developer_EU; ?></td>
                    <td>
                        <?php if ($_SESSION['level']=='1'){ ?>
                        <a class="btn btn-primary" href="?p=admin.developers.edit&id=<?= $developer->id; ?>">Edit</a>
                        <form action="?p=admin.developers.delete" method="post" style="display: inline;">
                            <input type="hidden" name="id" value="<?= $developer->id ?>">
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                        <?php } ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

</div>
