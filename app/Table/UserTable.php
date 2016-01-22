<?php
namespace App\Table;

use Core\Table\Table;

class UserTable extends Table{

    protected $table = 'users';

    public function tableEncours(){
        return $tableEncours = 'users';
    }


    public function findLastIdPages(){
        return $this->query("SELECT id FROM users WHERE id = last_insert_id()");
    }

    public function last(){
        return $this->query("
            SELECT *, users.title_user as users
            FROM users
            ORDER BY users.date_insert DESC");
    }

    public function updateUser($id, $fields){
        $sql_parts = [];
        $attributes = [];
        foreach($fields as $k => $v){
            $sql_parts[] = "$k = ?";
            $attributes[] = $v;
        }
        $attributes[] = $id;
        $sql_part = implode(', ', $sql_parts);
        //var_dump($fields);die;
        return $this->query("UPDATE {$this->table} SET $sql_part, date_update = NOW() WHERE id = ?", $attributes, true);
    }

}