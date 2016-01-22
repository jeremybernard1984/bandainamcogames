<?php
namespace App\Entity;

use Core\Entity\Entity;

class GenreEntity extends Entity{

    public function getUrl(){
        return 'index.php?p=posts.genres&id=' . $this->id;
    }

}