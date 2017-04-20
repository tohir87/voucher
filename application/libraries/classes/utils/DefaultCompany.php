<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace utils;

/**
 * Description of DefaultCompany
 *
 * @author JosephT
 */
class DefaultCompany extends JSONSerializableObject {

    protected static $instance;
    
    public $id_company = -1;
    public $id_own_company = 0;
    public $company_name = BUSINESS_NAME;
    public $about_us ;
    public $banner_text;
    public $description;
    public $id_state;
    public $id_industry;
    public $website = '';
    public $id_string = 'careers';
    public $cdn_container = '';
    public $bg_color = '#45AAD7';
    public $id_prefix = 'TAL';

    /**
     * @return DefaultCompany
     */
    public static function instance() {
        
        
        if (!static::$instance) {
            static::$instance = new self();
        }

        return static::$instance;
    }

}
