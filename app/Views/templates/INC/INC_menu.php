<?php
$page = $_GET['p'];
$activ = 'class="active"';

?>
<!-- Navigation -->
<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="index.php?p=admin.dashboards.index">Dreams, Fun and Inspiration</a>
    </div>
    <!-- Top Menu Items -->
    <ul class="nav navbar-right top-nav">
        <!--<li class="dropdown">
           <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-envelope"></i> <b class="caret"></b></a>
           <ul class="dropdown-menu message-dropdown">
               <li class="message-preview">
                   <a href="#">
                       <div class="media">
                                   <span class="pull-left">
                                       <img class="media-object" src="http://placehold.it/50x50" alt="">
                                   </span>
                           <div class="media-body">
                               <h5 class="media-heading"><strong>John Smith</strong>
                               </h5>
                               <p class="small text-muted"><i class="fa fa-clock-o"></i> Yesterday at 4:32 PM</p>
                               <p>Lorem ipsum dolor sit amet, consectetur...</p>
                           </div>
                       </div>
                   </a>
               </li>
               <li class="message-preview">
                   <a href="#">
                       <div class="media">
                                   <span class="pull-left">
                                       <img class="media-object" src="http://placehold.it/50x50" alt="">
                                   </span>
                           <div class="media-body">
                               <h5 class="media-heading"><strong>John Smith</strong>
                               </h5>
                               <p class="small text-muted"><i class="fa fa-clock-o"></i> Yesterday at 4:32 PM</p>
                               <p>Lorem ipsum dolor sit amet, consectetur...</p>
                           </div>
                       </div>
                   </a>
               </li>
               <li class="message-preview">
                   <a href="#">
                       <div class="media">
                                   <span class="pull-left">
                                       <img class="media-object" src="http://placehold.it/50x50" alt="">
                                   </span>
                           <div class="media-body">
                               <h5 class="media-heading"><strong>John Smith</strong>
                               </h5>
                               <p class="small text-muted"><i class="fa fa-clock-o"></i> Yesterday at 4:32 PM</p>
                               <p>Lorem ipsum dolor sit amet, consectetur...</p>
                           </div>
                       </div>
                   </a>
               </li>
               <li class="message-footer">
                   <a href="#">Read All New Messages</a>
               </li>
           </ul>
       </li>
      <li class="dropdown">
           <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-bell"></i> <b class="caret"></b></a>
           <ul class="dropdown-menu alert-dropdown">
               <li>
                   <a href="#">Alert Name <span class="label label-default">Alert Badge</span></a>
               </li>
               <li>
                   <a href="#">Alert Name <span class="label label-primary">Alert Badge</span></a>
               </li>
               <li>
                   <a href="#">Alert Name <span class="label label-success">Alert Badge</span></a>
               </li>
               <li>
                   <a href="#">Alert Name <span class="label label-info">Alert Badge</span></a>
               </li>
               <li>
                   <a href="#">Alert Name <span class="label label-warning">Alert Badge</span></a>
               </li>
               <li>
                   <a href="#">Alert Name <span class="label label-danger">Alert Badge</span></a>
               </li>
               <li class="divider"></li>
               <li>
                   <a href="#">View All</a>
               </li>
           </ul>
       </li>-->
        <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown"> <i class="fa fa-external-link"></i> Direct access links <b class="caret"></b></a>
            <ul class="dropdown-menu">
                <li>
                    <a href="index.php?p=users.logout"/> <i class="fa fa-bookmark-o"></i> Local Website</a>
                </li>
                <li class="divider"></li>
                <li>
                    <a target="_blank" href="https://www.bandainamcoent.fr"/> <i class="fa fa-external-link"></i> Online Website</a>
                </li>
                <li>
                    <a target="_blank" href="https://twitter.com/intent/follow?region=follow_link&screen_name=BandaiNamcoFR&tw_p=followbutton"/> <i class="fa  fa-twitter on fa-square-o"></i> Twitter</a>
                </li>
                <li>
                    <a target="_blank" href="https://www.facebook.com/BandaiNamcoEU"/> <i class="fa fa-facebook on fa-square-o"></i> Facebook</a>
                </li>
                <li>
                    <a target="_blank" href="https://www.youtube.com/user/NamcoBandaiGamesEU"/> <i class="fa fa-youtube on fa-square-o"></i> Youtube</a>
                </li>
            </ul>
        </li>
        <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> <?= $_SESSION['name']; ?> <b class="caret"></b></a>
            <ul class="dropdown-menu">
                <li>
                    <a href="?p=admin.users.edit&id=<?= $_SESSION['auth']; ?>"><i class="fa fa-fw fa-user"></i> Profile</a>
                </li>
                <!--<li>
                    <a href="#"><i class="fa fa-fw fa-envelope"></i> Inbox</a>
                </li>
                <li>
                    <a href="#"><i class="fa fa-fw fa-gear"></i> Settings</a>
                </li>-->
                <li class="divider"></li>
                <li>
                    <form method="post" name="logout" action="?p=users.logout" ></form>
                        <a href="#" onClick="document.forms.logout.submit()"> <i class="fa fa-fw fa-power-off"></i> Log Out</a>
                </li>
            </ul>
        </li>
    </ul>
    <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
    <div class="collapse navbar-collapse navbar-ex1-collapse">
        <ul class="nav navbar-nav side-nav">
            <li style="width:100%;height: 110px;background: url('images/corporate/logo_bandai_namco.png') no-repeat center #080808;background-size: contain;"></li>
            <li <?php if($page=='admin.dashboards.index'){echo $activ;}?>>
                <a href="index.php?p=admin.dashboards.index">Dashboard</a>
            </li>
            <li <?php if($page=='admin.highlights.add' || $page=='admin.highlights.index' || $page=='admin.highlights.edit'){echo $activ;}?>>
                <a href="index.php?p=admin.highlights.index">Highlights</a>
            </li>
            <!-- GAMES -->
            <li <?php if($page=='admin.games.add' || $page=='admin.games.index' || $page=='admin.games.edit'){echo $activ;}?>>
                <a href="javascript:;" data-toggle="collapse" data-target="#Games">Games <i class="fa fa-fw fa-caret-down"></i></a>
                <ul id="Games" class="collapse">
                    <li>
                        <a href="index.php?p=admin.games.add"><i class="glyphicon glyphicon-plus"></i> Add new game</a>
                    </li>
                    <li>
                       <a href="index.php?p=admin.games.index"><i class="glyphicon glyphicon-th-list"></i> List games</a>
                    </li>
                </ul>
            </li>

            <!--NEWS-->
            <li <?php if($page=='admin.news.add' || $page=='admin.news.index' || $page=='admin.news.edit'){echo $activ;}?>>
                <a href="javascript:;" data-toggle="collapse" data-target="#News">News <i class="fa fa-fw fa-caret-down"></i></a>
                <ul id="News" class="collapse">
                    <li>
                        <a href="index.php?p=admin.news.add"><i class="glyphicon glyphicon-plus"></i> Add news</a>
                    </li>
                    <li>
                        <a href="index.php?p=admin.news.index"><i class="glyphicon glyphicon-th-list"></i> List news</a>
                    </li>
                </ul>
            </li>
            <!--Contests
            <li <?php if($page==''){echo $activ;}?>>
                <a href="javascript:;" data-toggle="collapse" data-target="#Contests">Contests <i class="fa fa-fw fa-caret-down"></i></a>
                <ul id="Contests" class="collapse">
                    <li>
                        <a href="index.php?p=admin.contests.add"><i class="glyphicon glyphicon-plus"></i> Add Contest</a>
                    </li>
                    <li>
                        <a href="index.php?p=admin.contests.index"><i class="glyphicon glyphicon-th-list"></i> List Contests</a>
                    </li>
                </ul>
            </li>
            -->
            <!--demos-->
            <li <?php if($page=='admin.demos.add' || $page=='admin.demos.index' || $page=='admin.demos.edit'){echo $activ;}?>>
                <a href="javascript:;" data-toggle="collapse" data-target="#demos">Free to Play<i class="fa fa-fw fa-caret-down"></i></a>
                <ul id="demos" class="collapse">
                    <li>
                        <a href="index.php?p=admin.demos.add"><i class="glyphicon glyphicon-plus"></i> Add demo</a>
                    </li>
                    <li>
                        <a href="index.php?p=admin.demos.index"><i class="glyphicon glyphicon-th-list"></i> List demos</a>
                    </li>
                </ul>
            </li>
            <!--demos-->
            <li <?php if($page=='admin.pages.add' || $page=='admin.pages.index' || $page=='admin.pages.edit'){echo $activ;}?>>

            <a href="javascript:;" data-toggle="collapse" data-target="#pages">Pages CMS<i class="fa fa-fw fa-caret-down"></i></a>
                <ul id="pages" class="collapse">
                    <li>
                        <a href="index.php?p=admin.pages.add"><i class="glyphicon glyphicon-plus"></i> Add page</a>
                    </li>
                    <li>
                        <a href="index.php?p=admin.pages.index"><i class="glyphicon glyphicon-th-list"></i> List pages</a>
                    </li>
                </ul>
            </li>
            <!--USERS-->
            <li <?php if($page=='admin.users.add' || $page=='admin.users.index' || $page=='admin.users.edit'){echo $activ;}?>>
                <a href="javascript:;" data-toggle="collapse" data-target="#Users">Users <i class="fa fa-fw fa-caret-down"></i></a>
                <ul id="Users" class="collapse">
                    <li>
                        <a href="index.php?p=admin.users.add"><i class="glyphicon glyphicon-plus"></i> Add user</a>
                    </li>
                    <li>
                        <a href="index.php?p=admin.users.index"><i class="glyphicon glyphicon-th-list"></i> List users</a>
                    </li>
                </ul>
            </li>
            <!--
            <li>
                <a href="index.php?p=admin.categories.index"><i class="glyphicon glyphicon-chevron-right"></i> Categories</a>
            </li>

            <li class="active">
                <a href="index.php?p=users.login"><i class="glyphicon glyphicon-chevron-right"></i> Login</a>
            </li>
            <li>
                <a href="index.php?p=admin.games.index"><i class="glyphicon glyphicon-chevron-right"></i> Games</a>
            </li>
            <li>
                <a href="index.php?p=admin.posts.index"><i class="glyphicon glyphicon-chevron-right"></i> Articles</a>
            </li>
            -->
            <li
                <?php
                if($page=='admin.platforms.add' || $page=='admin.platforms.index' || $page=='admin.platforms.edit' ||
                   $page=='admin.developers.add' || $page=='admin.developers.index' || $page=='admin.developers.edit' ||
                   $page=='admin.publishers.add' || $page=='admin.publishers.index' || $page=='admin.publishers.edit' ||
                   $page=='admin.genres.add' || $page=='admin.genres.index' || $page=='admin.genres.edit' ||
                   $page=='admin.families.add' || $page=='admin.families.index' || $page=='admin.families.edit'){ echo $activ; }
            ?>>
                <a href="javascript:;" data-toggle="collapse" data-target="#demo"><i class="fa fa-fw fa-arrows-v"></i> Gestion des listes <i class="fa fa-fw fa-caret-down"></i></a>
                <ul id="demo" class="collapse">
                    <li>
                        <a href="index.php?p=admin.platforms.index">Platforms</a>
                    </li>
                    <li>
                        <a href="index.php?p=admin.developers.index">Developers</a>
                    </li>
                    <li>
                        <a href="index.php?p=admin.publishers.index">Publishers</a>
                    </li>
                    <li>
                        <a href="index.php?p=admin.genres.index">Genres</a>
                    </li>
                    <li>
                        <a href="index.php?p=admin.families.index">Familles</a>
                    </li>
                </ul>
            </li>
        <li style="color: #fff;text-align: center;font-size: 11px;padding: 20px"><br>© 2010 - 2015<br>Namco Bandai Entertainment S.A.S.</li>
        </ul>
    </div>
    <!-- /.navbar-collapse -->
</nav>