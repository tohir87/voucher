<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of db_expression
 *
 * @author JosephT
 */
class Db_expression {
    //put your code here
    protected $expression;
    
    public function __construct($expr='') {
        $this->expression = $expr;
    }
    
    /**
     * 
     * @param mixed $str
     * @return \self
     */
    public static function make($str){
        return new self($str);
    }

    public function __toString() {
        return strval($this->expression);
    }
    
}
