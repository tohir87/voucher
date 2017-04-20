<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace db;

require_once __DIR__ . '/../../db_expression.php';

/**
 * Description of Expr
 *
 * @author JosephT
 */
class Expr {

    //put your code here
    public static function make($str) {
        return \Db_expression::make($str);
    }

}
