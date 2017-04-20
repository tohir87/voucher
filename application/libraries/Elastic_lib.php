<?php

/**
 * Description of Elastic_lib
 *
 * @author tohir
 */
class Elastic_lib  {
     public function __construct() {
        $this->_init;
    }
    
    public function __get($name) {
        return get_instance()->$name;
    }
    
    private function _init(){
        $es = new Elasticsearch\Client([
            'host' => ['locahost:9200']
        ]);
    }
}
