<?php
namespace App\Entity;

use Core\Entity\Entity;

class DeveloperEntity extends Entity{

    public function getUrl(){
        return 'index.php?p=posts.developers&id=' . $this->id;
    }

}