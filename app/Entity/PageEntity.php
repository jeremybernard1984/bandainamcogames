<?php
namespace App\Entity;

use Core\Entity\Entity;

class PageEntity extends Entity{

    public function getUrl(){
        return 'index.php?p=pages.show&id=' . $this->id_page;
    }

    public function getExtrait(){
        $html = '<p>' . substr($this->description_page, 0, 100) . '...</p>';
        $html .= '<p><a href="' . $this->getURL() . '">Voir la suite</a></p>';
        return $html;
    }

    public function getImg(){
        return ;
    }


}