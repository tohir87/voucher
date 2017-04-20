<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once 'api_base_controller.php';

/**
 * Description of api_staff_controller
 *
 * @author JosephT
 * 
 * @property User_model $user_model user model
 */
class Api_Staff_Controller extends Api_Base_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('user/user_model', 'user_model');
        $this->checkLogIn();
    }

    public function index() {
        $params = array_filter((array) $this->input->get(), function($r) {
            return (is_string($r) && strlen(trim($r))) || (is_array($r) && count($r));
        });

        $where = [];

        if ($params['max_id']) {
            $where['u.id_user >'] = $params['max_id'];
        }

        if ($params['id_dept']) {
            $where['e.id_dept'] = $params['id_dept'];
        }

        $this->response['staff'] = $this->user_model->fetch_account_info($this->authToken->id_company, $params, PAGINATION_PER_PAGE, 0, \api\UserInfoShort::class, true);
    }
    
    public function get_by_id($id_user){
        $this->_getUser(['u.id_user' => $id_user]);
    }
    
    public function get_by_id_string($id_user){
        $this->_getUser(['u.id_string' => $id_user]);
    }
    
    private function _getUser($params){
        
        $rs = $this->user_model->fetch_account_info($this->authToken->id_company, $params, 1, 0, \api\UserInfo::class, true);
        if(empty($rs)){
            $this->_errorAdd('staff_not_found', 'The staff with the specified ID was not found.');
        }
        
        $this->response = $rs[0];
    }

}
