<?php
namespace App\Table;

use Core\Table\Table;

class PageTable extends Table{

    protected $table = 'pages';

    public function tableEncours(){
        return $tableEncours = 'pages';
    }


    public function findLastIdPages(){
        return $this->query("SELECT id FROM pages WHERE id = last_insert_id()");
    }

    public function last(){
        return $this->query("
            SELECT *, pages.title_game as pages
            FROM pages
            ORDER BY pages.date_insert DESC");
    }

}