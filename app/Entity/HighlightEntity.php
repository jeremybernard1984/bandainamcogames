<?php
namespace App\Entity;

use Core\Entity\Entity;

class HighlightEntity extends Entity{

    public function getUrl(){
        return 'index.php?p=highlights.show&id=' . $this->id_highlight;
    }

    public function getExtrait(){
        $html = '<p>' . substr($this->description_highlight, 0, 100) . '...</p>';
        $html .= '<p><a href="' . $this->getURL() . '">Voir la suite</a></p>';
        return $html;
    }

}