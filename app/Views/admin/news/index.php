<div class="col-lg-12">
    <h1>
        List of news :
    </h1>
    <ol class="breadcrumb">
        <li>
            <a href="index.php?p=admin.dashboards.index">Dashboard</a>
        </li>
        <li>
            <a href="index.php?p=admin.news.index">news list</a>
        </li>
    </ol>
</div>


<div class="col-lg-12">
    <div class="table-responsive">
            <p><a href="?p=admin.news.add" class="btn btn-success">Add</a></p>
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
            <?php foreach($news as $new):
                $online=$new->actif; ?>
                <tr>
                    <td><?php if($online == '1'){ echo "<i class='fa fa-eye fa-lg'></i>";} else{echo '-';} ?></td>
                    <td><?= $new->id; ?></td>
                    <td>
                        <?php if($_SESSION['lang'] == $new->lang){ ?>
                            <span style="font-weight:bold;font-size:1.6em;"><?=$new->title_news?></span>
                        <?php }else{ ?>
                            <?=$new->title_news;?>
                        <?php }?>
                    </td>
                    <td><?= date('d-m-Y', strtotime($new->date_news)); ?></td>
                    <!-- ICI JE METs LES LANGUES -->
                    <td><img src="images/flags/32/<?= $new->lang?>.png"/></td>
                    <td>
                        <a class="btn btn-primary" href="?p=admin.news.edit&id=<?= $new->id; ?>">Edit</a>
                        <form action="?p=admin.news.delete&master=<?= $new->lang; ?>&group=<?= $new->id_group_lang; ?>" method="post" style="display: inline;">
                            <input type="hidden" name="id" value="<?= $new->id ?>">
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Êtes-vous sûr de votre choix ?')">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php //}
            endforeach; ?>
            </tbody>
        </table>
    </div>
</div>