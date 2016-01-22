<?php
namespace App\Entity;

use Core\Entity\Entity;

class DemoEntity extends Entity{

    public function getUrl(){
        return 'index.php?p=demos.show&id=' . $this->id_demo;
    }

    public function getExtrait(){
        $html = '<p>' . substr($this->description_demo, 0, 100) . '...</p>';
        $html .= '<p><a href="' . $this->getURL() . '">Voir la suite</a></p>';
        return $html;
    }

    public function getImg(){
        return ;
    }


}