<?php

/**
 * Description of Lib
 *
 * @author tohir
 * @property CI_DB_query_builder $db Description
 */
abstract class Lib {
    
     public function __construct() {
        $this->load->database();
    }
    
    public function __get($name) {
        return get_instance()->$name;
    }
}
