<?php
$langEncours = $_SESSION['lang'];
?>
        <div class="col-lg-12">
            <h1>
                List of games :
            </h1>
            <ol class="breadcrumb">
                <li>
                    <a href="index.php?p=admin.dashboards.index">Dashboard</a>
                </li>
                <li>
                    <a href="index.php?p=admin.games.index">Games list</a>
                </li>
            </ol>
        </div>


    <div class="col-lg-12">
        <div class="table-responsive">
            <?php if ($_SESSION['level']=='1'){ ?>
                <p><a href="?p=admin.games.add" class="btn btn-success">Add</a></p>
            <?php } ?>
            <table class="table table-bordered table-hover" style="text-align: center">
                <thead>
                <tr>
                    <th>Online</th>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Langues</th>
                    <th>Banner</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach($games as $game):
                    $online=$game->actif;
                ?>
                <tr>
                    <td><?php if($online == '1'){ echo "<i class='fa fa-eye fa-lg'></i>";} else{echo '-';} ?></td>
                    <td><?= $game->id; ?></td>
                    <td>
                        <?php if($_SESSION['lang'] == $game->lang){ ?>
                            <span style="font-weight:bold;font-size:1.6em;"><?=$game->title_game?></span>
                        <?php }else{ ?>
                           <?=$game->title_game;?>
                        <?php }?>
                    </td>
                    <!-- ICI JE MET LES LANGUES -->
                    <td>
                    <img src="images/flags/32/<?= $game->lang?>.png"/>
                    </td>
                    <td style="height: 70px;background: url('images/games/banners/<?=$game->banner_game?>') no-repeat center #fff;background-size: contain;"></td>
                    <td>
                        <a class="btn btn-primary" href="?p=admin.games.edit&id=<?= $game->id; ?>">Edit</a>
                        <form action="?p=admin.games.delete&master=<?= $game->lang; ?>&group=<?= $game->id_group_lang; ?>" method="post" style="display: inline;">
                            <input type="hidden" name="id" value="<?= $game->id ?>">
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
