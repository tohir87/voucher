<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of api_base_controller
 *
 * @author JosephT
 * @property subdomain $subdomain 
 * @property user_auth $user_auth
 * @property CI_Input $input
 * @property CI_Output $output
 * @property CI_Loader $load
 * @property Api_Auth_Model $auth_model auth model
 * @property Api_App_Model $app_model app model
 * @property Market_model $m_model Description
 * @property Setup_model $setup_model Description
 * @property Api_price_model $price_model Description
 * @property Basic_model $b_model Description
 * 
 */
abstract class Api_Base_Controller extends CI_Controller {

    //put your code here
    protected $response = [];

    /**
     *
     * @var api\AuthToken
     */
    protected $authToken;

    /**
     *
     * @var api\App
     */
    protected $app;

    public function __construct() {
        parent::__construct();
        $this->load->model('api/api_app_model', 'app_model');
        $this->load->model('basic_model', 'b_model');
        $this->load->model('setup/market_model', 'm_model');
        $this->load->model('setup/setup_model', 'setup_model');
        $this->load->model('api/api_price_model', 'price_model');
        //$this->initAuth();
    }

    private function initAuth() {
        if (($appKey = $this->input->get_request_header('App-key'))) {
            $this->app = $this->app_model->getApp($appKey);

            if (!$this->app) {
                $this->_errorAdd('invalid_app', 'Application was not found or it\'s been suspended');
            }

            if (($token = $this->input->get_request_header('Token'))) {
                $this->authToken = $this->auth_model->checkAuth($appKey, null, $token);
                if (!$this->authToken) {
                    $this->_tokenValidationFailed();
                }
            }
        }
    }

    private function _tokenValidationFailed() {
        $this->output->set_status_header(401);
        $this->_errorAdd('token_validation_failure', 'The token specified for user could not be verified.');
    }

    protected function _errorAdd($code, $message, $status = 400, $exit = true) {
        $this->output->set_status_header($status);
        $this->response['errors'][] = array(
            'id' => $code,
            'message' => $message
        );
        if ($exit) {
            $this->apiOutput();
            exit;
        }
    }

    protected final function checkLogIn() {
        if (!$this->authToken) {
            $this->_errorAdd('not_logged_in', 'User is not logged in.', 401);
        }
    }

    public function apiOutput() {
        $this->output->set_content_type('application/json');
        $flag = 0;
        if ($this->input->get('pretty')) {
            $flag |= JSON_PRETTY_PRINT;
        }
        $response = json_encode($this->response, $flag);
        if ($response === false) {
            $this->_errorAdd('serialize_error', 'Response could not be serialized', 500);
        }
        $this->output->_display($response);
    }

    public function _invalidMethod() {
        $this->_errorAdd('invalid_method', 'The method ' . $this->input->server('REQUEST_METHOD') . ' is not valid');
    }

}
