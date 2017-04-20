<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * Description of Analytics_controller
 *
 * @author tohir
 * @property User_auth_lib $user_auth_lib Description
 * @property User_nav_lib $user_nav_lib Description
 * @property Setup_model $setup_model Description
 * @property Market_model $market_model Description
 * @property Subscription_model $sub_model Description
 */
class Analytics_controller extends CI_Controller {

    public function __construct() {
        parent::__construct();

        $this->load->library('user_nav_lib');
        $this->load->helper('auth_helper');

        $this->load->model('user/user_model', 'u_model');
        $this->load->model('setup/Setup_model', 'setup_model');
        $this->load->model('setup/Market_model', 'market_model');
        $this->load->model('setup/Subscription_model', 'sub_model');
        $this->load->model('basic_model');
    }
    
    public function index() {
        $this->user_auth_lib->check_login();
        $data = array(
            'products' => !$this->user_auth_lib->is_subscriber() ? $this->basic_model->fetch_all_records(Setup_model::TBL_PRODUCTS) : $this->sub_model->fetchSubscriberProducts($this->user_auth_lib->get('user_id')),
            'markets' => !$this->user_auth_lib->is_subscriber() ? $this->basic_model->fetch_all_records(Setup_model::TBL_MARKETS, ['status' => ACTIVE]) : $this->sub_model->fetchSubscriberMarkets($this->user_auth_lib->get('user_id')),
            'type' => 'analytics'
        );
        $this->user_nav_lib->run_page('reports/analytics', $data, 'Analytics' . BUSINESS_NAME);
    }
    
    public function retail_analytics() {
        $this->user_auth_lib->check_login();
        $data = array(
            'products' => !$this->user_auth_lib->is_subscriber() ? $this->basic_model->fetch_all_records(Setup_model::TBL_PRODUCTS) : $this->sub_model->fetchSubscriberProducts($this->user_auth_lib->get('user_id')),
            'markets' => !$this->user_auth_lib->is_subscriber() ? $this->basic_model->fetch_all_records(Setup_model::TBL_MARKETS, ['status' => ACTIVE]) : $this->sub_model->fetchSubscriberMarkets($this->user_auth_lib->get('user_id')),
            'type' => 'retail-analytics'
        );
        $this->user_nav_lib->run_page('reports/analytics', $data, 'Analytics' . BUSINESS_NAME);
    }
    
    public function source_products() {
        $this->user_auth_lib->check_login();
        $data = array(
            'sources' => $this->basic_model->fetch_all_records(Setup_model::TBL_SOURCES, ['status' => ACTIVE]),
        );
        $this->user_nav_lib->run_page('reports/source_products', $data, 'Analytics' . BUSINESS_NAME);
    }
    
    public function process_filter_report() {
        $market_id = $_GET['market_id'];
        $product_id = $_GET['product_id'];
        
        $prices = $this->market_model->fetchProductPrices($product_id, $market_id);
       echo json_encode($prices);
        exit;
        
        echo 'im here';
    }
    
    public function json_analyse_report($market_id = 0, $product_id = 0, $variety_id =0, $ws_metric_id=0, $start_date = '', $end_date = '') {
        $this->output->set_content_type('application/json');
        $this->output->_display(json_encode($this->market_model->fetchCommPrices($product_id, $market_id, $variety_id, $ws_metric_id, $start_date, $end_date)));
    }
    
    public function json_analyse_retail_report($market_id = 0, $product_id = 0, $variety_id =0, $ws_metric_id=0, $start_date = '', $end_date = '') {
        $this->output->set_content_type('application/json');
        $this->output->_display(json_encode($this->market_model->fetchCommRetailPrices($product_id, $market_id, $variety_id, $ws_metric_id, $start_date, $end_date)));
    }
    
    public function json_analyse_source_products($source_id) {
        $this->output->set_content_type('application/json');
        $this->output->_display(json_encode(
                        array_merge($this->market_model->buildSourceProducts($source_id), $this->market_model->buildSourceProductsPerMarkets($source_id))
                ));
    }

}
