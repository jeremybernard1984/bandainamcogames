<?php
namespace App\Table;

use Core\Table\Table;

class DemoTable extends Table{

    protected $table = 'demos';

    public function tableEncours(){
        return $tableEncours = 'demos';
    }


    public function findLastIdDemos(){
        return $this->query("SELECT id FROM demos WHERE id = last_insert_id()");
    }

    public function last(){
        return $this->query("
            SELECT *, demos.title_game as demos
            FROM demos
            ORDER BY demos.date_insert DESC");
    }

    // POUR DELETE LES IMAGES LIEES
    public function deleteDemo($id,$dossier1){
        if($liste = opendir($dossier1)){
            while(false !== ($fichier = readdir($liste))){
                if(strstr($fichier, "demo_".$id."")){
                    $filename = $dossier1."/".$fichier."";
                    @mkdir($filename, 0777, true);
                    unlink($filename);
                }
            }
        }
        return $this->query("DELETE FROM demos WHERE id = ?", [$id], true);
    }

}