<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once BASEPATH . 'libraries/Email.php' ;
/**
 * Description of tbemail
 *
 * @author TOHIR
 */
class Tbemail extends CI_Email
{

    //put your code here
    public function addCustomHeader($name, $value)
    {
        $this->_set_header($name, $value);
    }

}
