<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace db;

/**
 * Description of Entity
 *
 * @author JosephT
 * 
 * @property \CI_Loader $load
 * @property \CI_DB_active_record $db 
 */
class Entity extends \utils\JSONSerializableObject {

    //put your code here
    public static $CACHED = [];
    protected $fkMappings = array(
            //table => field
    );

    /**
     * 
     * @return \CI_DB_active_record
     */
    protected function _getDb() {
        if (!$this->db) {
            $this->load->database();
        }
        return $this->db;
    }

    protected function ref($refTable, $pkField = null) {
        $fkCol = 'id_' . \utils\StrUtils::depluralize($refTable);
        if (!$pkField) {
            //@todo auto guess primary key field.
            $pkField = array_key_exists($refTable, $this->fkMappings) ? $this->fkMappings[$refTable] : $fkCol;
        }

        $value = $this->$fkCol;

        if (!$value) {
            return null;
        }

        $key = "{$pkField}:{$pkField}:{$value}";
        
        //not cached
        if (!array_key_exists($key, self::$CACHED)) {
            $rs = $this->_getDb()->get_where($refTable, array(
                        $pkField => strval($value)
                    ))->result(self::class);
            //
            self::$CACHED[$key] = current($rs);
        }

        return self::$CACHED[$key];
    }

    public function __call($name, $arguments) {
        if (preg_match('/^ref/', $name)) {
            $refTable = \utils\StrUtils::camelCaseToDelimited(substr($name, 3));
            $args = array_merge([$refTable], (array) $arguments);
            return call_user_func_array(array($this, 'ref'), $args);
        }
        
        throw new \RuntimeException('Method ' . get_class($this) . '::' . $name. ' was not found.');
    }
    
    public function __get($name) {
        return get_instance()->$name;
    }

}
