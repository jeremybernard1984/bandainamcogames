<div class="col-lg-12">
    <h1>
        List of pages :
    </h1>
    <ol class="breadcrumb">
        <li>
            <a href="index.php?p=admin.dashboards.index">Dashboard</a>
        </li>
        <li>
            <a href="index.php?p=admin.pages.index">pages list</a>
        </li>
    </ol>
</div>
<div class="col-lg-12">
    <div class="table-responsive">
        <?php if ($_SESSION['level']=='1'){ ?>
            <p><a href="index.php?p=admin.pages.add" class="btn btn-success">Add</a></p>
        <?php } ?>
        <table class="table table-bordered table-hover" style="text-align: center">
            <thead>
            <tr>
                <th>Online</th>
                <th>ID</th>
                <th>Title</th>
                <th>Langues</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach($pages as $page):
                $online=$page->actif; ?>
                <tr>
                    <td><?php if($online == '1'){ echo "<i class='fa fa-eye fa-lg'></i>";} else{echo '-';} ?></td>
                    <td><?= $page->id; ?></td>
                    <td>
                        <?php if($_SESSION['lang'] == $page->lang){ ?>
                            <span style="font-weight:bold;font-size:1.6em;"><?=$page->title_page?></span>
                        <?php }else{ ?>
                            <?=$page->title_page;?>
                        <?php }?>
                    </td>
                    <!-- ICI JE MET LES LANGUES -->
                    <td><img src="images/flags/32/<?= $page->lang?>.png"/></td>
                    <td>
                        <a class="btn btn-primary" href="?p=admin.pages.edit&id=<?= $page->id; ?>">Edit</a>
                        <form action="?p=admin.pages.delete&master=<?= $page->lang; ?>&group=<?= $page->id_group_lang; ?>" method="post" style="display: inline;">
                            <input type="hidden" name="id" value="<?= $page->id ?>">
                            <?php if ($_SESSION['level']=='1'){ ?>
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Êtes-vous sûr de votre choix ?')">Delete</button>
                            <?php } ?>
                        </form>
                    </td>
                </tr>
            <?php
            endforeach; ?>
            </tbody>
        </table>
		<?php
		var_dump($pagination);
		echo $pagination;
		?>
    </div>
</div>