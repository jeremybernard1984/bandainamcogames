<h1>Administrer les catégories</h1>
<div class="row">

            <div class="col-sm-12">
                <?php if ($_SESSION['lang']=='EU'){ ?>
                    <p><a href="?p=admin.categories.add" class="btn btn-success">Ajouter</a></p>
                <?php } ?>

                <table class="table">
            <thead>
            <tr>
                <td>ID</td>
                <td>Titre</td>
                <td>Actions</td>
            </tr>
            </thead>
            <tbody>
                <?php foreach($items as $category): ?>
                <tr>
                    <td><?= $category->id; ?></td>
                    <td><?= $category->titre; ?></td>
                    <td>
                        <a class="btn btn-primary" href="?p=admin.categories.edit&id=<?= $category->id; ?>">Editer</a>
                        <form action="?p=admin.categories.delete" method="post" style="display: inline;">
                            <input type="hidden" name="id" value="<?= $category->id ?>">
                            <button type="submit" class="btn btn-danger">Supprimer</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
