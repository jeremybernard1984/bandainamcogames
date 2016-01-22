<?php
namespace App\Entity;

use Core\Entity\Entity;

class FamilyEntity extends Entity{

    public function getUrl(){
        return 'index.php?p=posts.families&id=' . $this->id;
    }

}