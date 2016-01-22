<?php
namespace App\Table;

use Core\Table\Table;

class HighlightTable extends Table{

    protected $table = 'highlights';

    public function tableEncours(){
        return $tableEncours = 'highlights';
    }


    public function findLastIdHighlights(){
        return $this->query("SELECT id FROM highlights WHERE id = last_insert_id()");
    }

    public function last(){
        return $this->query("
            SELECT *, highlights.title_highlight as highlights
            FROM highlights
            ORDER BY highlights.date_insert DESC");
    }

}