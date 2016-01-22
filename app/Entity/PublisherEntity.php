<?php
namespace App\Entity;

use Core\Entity\Entity;

class PublisherEntity extends Entity{

    public function getUrl(){
        return 'index.php?p=posts.publishers&id=' . $this->id;
    }

}