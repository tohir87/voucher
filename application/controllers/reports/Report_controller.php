<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * Description of Report_controller
 *
 * @author tohir
 * 
 * 
 * @property User_auth_lib $user_auth_lib Description
 * @property User_nav_lib $user_nav_lib Description
 * @property CI_Loader $load Description
 * @property User_model $u_model Description
 * @property Basic_model $basic_model Description
 * @property Market_model $market_model Description
 * @property Report_model $r_model Description
 * @property Subscription_model $sub_model Description
 */
class Report_controller extends CI_Controller {

    public function __construct() {
        parent::__construct();

        $this->load->library('user_nav_lib');
        $this->load->helper('auth_helper');

        $this->load->model('user/user_model', 'u_model');
        $this->load->model('setup/Setup_model', 'setup_model');
        $this->load->model('setup/Market_model', 'market_model');
        $this->load->model('reports/Report_model', 'r_model');
        $this->load->model('setup/Subscription_model', 'sub_model');
        $this->load->model('basic_model');
    }

    public function index() {
        $this->user_auth_lib->check_login();
        $this->user_auth_lib->isActiveSubscriber();

        $data = array(
            'products' => !$this->user_auth_lib->is_subscriber() ? $this->basic_model->fetch_all_records(Setup_model::TBL_PRODUCTS) : $this->sub_model->fetchSubscriberProducts($this->user_auth_lib->get('user_id')),
            'markets' => !$this->user_auth_lib->is_subscriber() ? $this->basic_model->fetch_all_records(Setup_model::TBL_MARKETS, ['status' => ACTIVE]) : $this->sub_model->fetchSubscriberMarkets($this->user_auth_lib->get('user_id')),
            'type' => 'reports'
        );

        $this->user_nav_lib->run_page('reports/report', $data, 'Reports & Analytics');
    }

    public function product_report_json($market_id = 0, $product_id = 0, $variety_id =0, $start_date = '', $end_date = '') {
        $this->output->set_content_type('application/json');
        $this->output->_display(json_encode($this->market_model->fetchProductPrices($product_id, $market_id, $variety_id, $start_date, $end_date)));
    }
    
    public function product_variety_json($product_id = 0) {
        $this->output->set_content_type('application/json');
        $this->output->_display(json_encode($this->market_model->fetchProductVarieties($product_id)));
    }
    
    public function product_wholesale_metric_json($product_id = 0) {
        $this->output->set_content_type('application/json');
        $this->output->_display(json_encode($this->market_model->fetchProductWSMetrics($product_id)));
    }
    
    public function product_retail_metric_json($product_id = 0) {
        $this->output->set_content_type('application/json');
        $this->output->_display(json_encode($this->market_model->fetchProductRetailMetrics($product_id)));
    }

    public function report_download($market_id = 0, $product_id = 0, $variety_id =0, $start_date = '', $end_date = '') {
        $this->r_model->buildProductExcelReport(array(
            'market_id' => $market_id,
            'product_id' => $product_id,
            'variety_id' => $variety_id,
            'start_date' => $start_date,
            'end_date' => $end_date
        ), $this->market_model->fetchProductPrices($product_id, $market_id, $variety_id, $start_date, $end_date));
    }
    
    public function editRemark($id) {
        $this->user_auth_lib->check_login();
        $p_info = $this->market_model->fetchMarketPriceInfo($id);
        
        if (empty($p_info)){
            notify('error', 'Unable to locate market information');
            redirect(site_url('/report'));
        }
        if (request_is_post()){
            if ($this->market_model->updateRemark($id, request_post_data())){
                notify('success', 'Remark updated successfully');
            }else{
                notify('error', 'Unable to update remark, pls try again');
            }
            redirect(site_url('/report'));
        }
        
        $data = [
            'price_info' => $this->market_model->fetchMarketPriceInfo($id),
            'remarks' => $this->basic_model->fetch_all_records(Setup_model::TBL_REMARKS, ['status' => ACTIVE])
        ];
        
        $this->user_nav_lib->run_page('market/edit_market_price', $data, 'Edit Remark');
    }
    
    public function exemption() {
        $this->user_auth_lib->check_login();
        $this->user_auth_lib->check_perm('market:exemptions');
        
        if (request_is_post()){
            if ($this->market_model->processException(request_post_data())){
                notify('success', 'Operation was successful');
            }else{
                notify('error', 'Something went wrong');
            }
            redirect(site_url('/report/exemption'));
        }
        
        $data = [
            'markets' => $this->basic_model->fetch_all_records('markets'),
            'exemptions' => $this->market_model->fetchAllExemptions()
        ];
        $this->user_nav_lib->run_page('market/exemption', $data, 'Market Exemption');
    }
    
    public function get_market_products($market_id) {

        $products = $this->market_model->fetchMarketProducts($market_id);

        $this->output->set_content_type('application/json');
        $data = array();
        if (!$products) {
            $data[] = ['id' => '-1', 'name' => "[products not found]"];
        } else {
            foreach ($products as $p) {
                $data[] = ['id' => $p->product_id, 'name' => ucfirst($p->product_name)];
            }
        }
        $this->output->_display(json_encode($data));
        return;
    }
    
    

}
