<?php

namespace Core\Entity;

class Entity {
    /**
     * Fonction magique !!!
     */
    public function __get($key){
        $method = 'get' . ucfirst($key);
        $this->$key = $this->$method();
        return $this->$key;
    }

}