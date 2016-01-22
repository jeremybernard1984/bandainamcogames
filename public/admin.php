<?php
use Core\Auth\DBAuth;

define('ROOT', dirname(__DIR__));
require ROOT . '/app/App.php';
App::load();

if(isset($_GET['p'])){
    $page = $_GET['p'];
}else{
    $page = 'home';
}

// Auth
$app = App::getInstance();
$auth = new DBAuth($app->getDb());
if(!$auth->logged()){
    $app->forbidden();
}

ob_start();
if($page === 'home'){
    //INDEX
    require ROOT . '/pages/admin/games/index.php';
}
//PAGES NEWS
elseif ($page === 'news.edit'){
    require ROOT . '/pages/admin/news/edit.php';
}elseif ($page === 'news.edit'){
    require ROOT . '/pages/admin/news/index.php';
}elseif ($page === 'news.delete'){
    require ROOT . '/pages/admin/news/delete.php';
}
//PAGES CONTESTS
elseif ($page === 'contests.edit'){
    require ROOT . '/pages/admin/contests/edit.php';
}elseif ($page === 'contests.edit'){
    require ROOT . '/pages/admin/contests/index.php';
}elseif ($page === 'contests.delete'){
    require ROOT . '/pages/admin/contests/delete.php';
}
//PAGES DEMOS -> FREE TO PLAY
elseif ($page === 'demos.edit'){
    require ROOT . '/pages/admin/demos/edit.php';
}elseif ($page === 'demos.edit'){
    require ROOT . '/pages/admin/demos/index.php';
}elseif ($page === 'demos.delete'){
    require ROOT . '/pages/admin/demos/delete.php';
}
//PAGES CMS
elseif ($page === 'pages.edit'){
    require ROOT . '/pages/admin/pages/edit.php';
}elseif ($page === 'pages.edit'){
    require ROOT . '/pages/admin/pages/index.php';
}elseif ($page === 'pages.delete'){
    require ROOT . '/pages/admin/pages/delete.php';
}
//PAGES USERS
elseif ($page === 'users.edit'){
    require ROOT . '/pages/admin/users/edit.php';
}elseif ($page === 'users.edit'){
    require ROOT . '/pages/admin/users/index.php';
}elseif ($page === 'users.delete'){
    require ROOT . '/pages/admin/users/delete.php';
}

elseif ($page === 'posts.edit'){
    require ROOT . '/pages/admin/posts/edit.php';
}
elseif ($page === 'posts.edit'){
    require ROOT . '/pages/admin/posts/edit.php';
} elseif ($page === 'posts.add'){
    require ROOT . '/pages/admin/posts/add.php';
}elseif ($page === 'posts.delete'){
    require ROOT . '/pages/admin/posts/delete.php';
}elseif($page === 'categories.index'){
    require ROOT . '/pages/admin/categories/index.php';
} elseif ($page === 'categories.edit'){
    require ROOT . '/pages/admin/categories/edit.php';
} elseif ($page === 'categories.add'){
    require ROOT . '/pages/admin/categories/add.php';
}elseif ($page === 'categories.delete'){
    require ROOT . '/pages/admin/categories/delete.php';
}elseif ($page === 'games.edit'){
    require ROOT . '/pages/admin/games/edit.php';
} elseif ($page === 'games.add'){
    require ROOT . '/pages/admin/games/add.php';
}elseif ($page === 'platforms.edit'){
    require ROOT . '/pages/admin/platforms/edit.php';
} elseif ($page === 'platforms.add'){
    require ROOT . '/pages/admin/platforms/add.php';
}elseif ($page === 'publishers.edit'){
    require ROOT . '/pages/admin/publishers/edit.php';
} elseif ($page === 'publishers.add'){
    require ROOT . '/pages/admin/publishers/add.php';
}elseif ($page === 'genres.edit'){
    require ROOT . '/pages/admin/genres/edit.php';
} elseif ($page === 'genres.add'){
    require ROOT . '/pages/admin/genres/add.php';
}elseif ($page === 'families.edit'){
    require ROOT . '/pages/admin/families/edit.php';
} elseif ($page === 'families.add'){
    require ROOT . '/pages/admin/families/add.php';
}elseif ($page === 'developers.edit'){
    require ROOT . '/pages/admin/developers/edit.php';
} elseif ($page === 'developers.add'){
    require ROOT . '/pages/admin/developers/add.php';
}
$content = ob_get_clean();
require ROOT . '/pages/templates/default.php';
