<?php
namespace App\Entity;

use Core\Entity\Entity;

class PlatformEntity extends Entity{

    public function getUrl(){
        return 'index.php?p=posts.platforms&id=' . $this->id;
    }

}