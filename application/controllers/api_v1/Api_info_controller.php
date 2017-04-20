<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once 'Api_base_controller.php';

/**
 * Description of api_info_controller
 *
 * @author JosephT
 */
class Api_Info_Controller extends Api_Base_Controller {

    public function index() {
        $this->response = array(
            'company' => BUSINESS_NAME_FULL,
            'id_string' => BUSINESS_NAME,
            'website' => WEBSITE,
            'logo_url' => site_url('/img/ctm_logo_sm.png'),
            'logo_text' => BUSINESS_NAME_FULL,
        );
        
        $this->apiOutput();
    }

}
