<?php
namespace App\Table;

use Core\Table\Table;

class NewTable extends Table{

    protected $table = 'news';

    public function tableEncours(){
        return $tableEncours = 'news';
    }

    public function findLastIdNews(){
        return $this->query("SELECT id FROM news WHERE id = last_insert_id()");
    }



}