<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of api_app_model
 *
 * @author JosephT
 * @property CI_DB_active_record $db 
 */
class Api_App_Model extends CI_Model {

    //put your code here
    const TABLE_APP = 'api_app';

    public function __construct() {
        parent::__construct();
    }

    /**
     * 
     * @param string $appKey
     * @param bool $checkStatus
     * @return api\App
     */
    public function getApp($appKey, $checkStatus = true) {
        $this->db
                ->from(self::TABLE_APP)
                ->select('*')
                ->where('app_key', $appKey)
        ;

        if ($checkStatus) {
            $this->db->where('enabled', 1);
        }

        return $this->db->get()
                        ->result(api\App::class)[0];
    }

}
