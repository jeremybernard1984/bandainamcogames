<?php
namespace App\Table;

use Core\Table\Table;

class LangTable extends Table{



// Je passe le parametre du bas pour faire un fetche all > Voir mysqldatabase
    public function findAllLangToArt($id_group_lang){
        return $this->query("
            SELECT *
            FROM articles
            WHERE id_group_lang= ?
            ORDER BY id", [$id_group_lang], false);
    }
    // Même chose pour les games
    public function findAllLangToGames($id_group_lang){
        return $this->query("
            SELECT *
            FROM games
            WHERE id_group_lang= ?
            ORDER BY id", [$id_group_lang], false);
    }
    // Même chose pour les news
    public function findAllLangToNews($id_group_lang){
        return $this->query("
            SELECT *
            FROM news
            WHERE id_group_lang= ?
            ORDER BY id", [$id_group_lang], false);
    }
    // Même chose pour les pages
    public function findAllLangToPages($id_group_lang){
        return $this->query("
            SELECT *
            FROM pages
            WHERE id_group_lang= ?
            ORDER BY id", [$id_group_lang], false);
    }
    // Même chose pour les demos
    public function findAllLangToDemos($id_group_lang){
        return $this->query("
            SELECT *
            FROM demos
            WHERE id_group_lang= ?
            ORDER BY id", [$id_group_lang], false);
    }



    public function extractAllLang($key, $value){
        $records = $this->query('SELECT * FROM pays WHERE actif = 1 ORDER BY alpha2');
        $return = [];
        foreach($records as $v){
            $return[$v->$key] = $v->$value;
        }
        return $return;
    }

	
}