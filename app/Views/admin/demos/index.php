<div class="col-lg-12">
    <h1>
        Free to play :
    </h1>
    <ol class="breadcrumb">
        <li>
            <a href="index.php?p=admin.dashboards.index">Dashboard</a>
        </li>
        <li>
            <a href="index.php?p=admin.pages.index">demos list</a>
        </li>
    </ol>
</div>
<div class="col-lg-12">
    <div class="table-responsive">
        <?php if ($_SESSION['level']=='1'){ ?>
            <p><a href="?p=admin.pages.add" class="btn btn-success">Add</a></p>
        <?php } ?>
        <table class="table table-bordered table-hover" style="text-align: center">
            <thead>
            <tr>
                <th>Online</th>
                <th>ID</th>
                <th>Title</th>
                <th>Date</th>
                <th>Langues</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach($demos as $demo):
                $online=$demo->actif; ?>
                <tr>
                    <td><?php if($online == '1'){ echo "<i class='fa fa-eye fa-lg'></i>";} else{echo '-';} ?></td>
                    <td><?= $demo->id; ?></td>
                    <td>
                        <?php if($_SESSION['lang'] == $demo->lang){ ?>
                            <span style="font-weight:bold;font-size:1.6em;"><?=$demo->title_demo?></span>
                        <?php }else{ ?>
                            <?=$demo->title_demo;?>
                        <?php }?>
                    </td>
                    <td><?= date('d-m-Y', strtotime($demo->date_demo)); ?></td>
                    <!-- ICI JE METs LES LANGUES -->
                    <td><img src="images/flags/32/<?= $demo->lang?>.png"/></td>
                    <td>
                        <a class="btn btn-primary" href="?p=admin.demos.edit&id=<?= $demo->id; ?>">Edit</a>
                        <form action="?p=admin.demos.delete&master=<?= $demo->lang; ?>&group=<?= $demo->id_group_lang; ?>" method="post" style="display: inline;">
                            <input type="hidden" name="id" value="<?= $demo->id ?>">
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
    </div>
</div>