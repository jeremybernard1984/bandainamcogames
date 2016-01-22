<?php
namespace App\Entity;

use Core\Entity\Entity;

class NewEntity extends Entity{

    public function getUrl(){
        return 'index.php?p=news.show&id=' . $this->id_news;
    }

    public function getExtrait(){
        $html = '<p>' . substr($this->description_news, 0, 100) . '...</p>';
        $html .= '<p><a href="' . $this->getURL() . '">Voir la suite</a></p>';
        return $html;
    }

    public function getImg(){
        return ;
    }


}