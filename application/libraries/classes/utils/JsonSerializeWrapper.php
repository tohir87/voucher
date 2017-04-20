<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace utils;

/**
 * Description of JsonSerializeWrapper
 *
 * @author JosephT
 */
class JsonSerializeWrapper implements \JsonSerializable {
    
    protected $object;
    
    public function __construct($object) {
        $this->object = $object;
    }
    
    public function getObject() {
        return $this->object;
    }

    public function setObject($object) {
        $this->object = $object;
        return $this;
    }

        public function jsonSerialize() {
        return get_object_vars($this->object);
    }
}
