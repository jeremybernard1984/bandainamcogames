<?php
$langEncours = $_SESSION['lang'];
?>
<div class="col-lg-12">
    <h1>
        List of highlights :
    </h1>
    <ol class="breadcrumb">
        <li>
            <a href="index.php?p=admin.dashboards.index">Dashboard</a>
        </li>
        <li>
            <a href="index.php?p=admin.highlights.index">highlights list</a>
        </li>
    </ol>
</div>


<div class="col-lg-12">
    <div class="table-responsive">
        <table class="table table-bordered table-hover" style="text-align: center">
            <thead>
            <tr>
                <th>Langues</th>
                <th>highlight 1</th>
                <th>highlight 2</th>
                <th>highlight 3</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach($highlights as $highlight):
            if($_SESSION['lang'] != 'EU'){
                if($highlight->lang == $_SESSION['lang']){ ?>
                    <tr>
                            <td valign="middle">
                                <br><img src="images/flags/32/<?= $highlight->lang?>.png"/><br>
                                <br>
                                <p>Highlight update :<br>
                                <strong><?= date('d-m-Y', strtotime($highlight->date_update)); ?></strong></p>
                    </td>
                    <td style="height:150px;background: url('images/highlights/backgrounds/<?= $highlight->background_highlight_1; ?>') no-repeat center #fff;background-size: contain;"></td>
                    <td style="height:150px;background: url('images/highlights/backgrounds/<?= $highlight->background_highlight_2; ?>') no-repeat center #fff;background-size: contain;"></td>
                    <td style="height:150px;background: url('images/highlights/backgrounds/<?= $highlight->background_highlight_3; ?>') no-repeat center #fff;background-size: contain;"></td>
                    <td>
                        <br><br><a class="btn btn-primary" href="?p=admin.highlights.edit&id=<?= $highlight->id; ?>">Edit</a>
                    </td>
                    </tr>
            <?php }
            }else{ ?>
                <tr>
                    <td valign="middle">
                        <br><img src="images/flags/32/<?= $highlight->lang?>.png"/><br>
                        <br>
                        <p>Highlight update :<br>
                            <strong><?= date('d-m-Y', strtotime($highlight->date_update)); ?></strong></p>
                    </td>
                    <td style="height:150px;background: url('images/highlights/backgrounds/<?= $highlight->background_highlight_1; ?>') no-repeat center #fff;background-size: contain;"></td>
                    <td style="height:150px;background: url('images/highlights/backgrounds/<?= $highlight->background_highlight_2; ?>') no-repeat center #fff;background-size: contain;"></td>
                    <td style="height:150px;background: url('images/highlights/backgrounds/<?= $highlight->background_highlight_3; ?>') no-repeat center #fff;background-size: contain;"></td>
                    <td>
                        <br><br><a class="btn btn-primary" href="?p=admin.highlights.edit&id=<?= $highlight->id; ?>">Edit</a>
                    </td>
                </tr>
            <?php }
            endforeach; ?>
            </tbody>
        </table>
    </div>
</div>