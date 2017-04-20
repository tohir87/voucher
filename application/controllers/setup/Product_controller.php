<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * Description of Product_controller
 *
 * @author tohir
 * @property User_auth_lib $user_auth_lib Description
 * @property User_nav_lib $user_nav_lib Description
 * @property CI_Loader $load Description
 * @property Product_model $prod_model Description
 * @property Basic_model $basic_model Description
 * @property CI_Input $input Description
 */
class Product_controller extends CI_Controller {

    public function __construct() {
        parent::__construct();

        $this->load->model('setup/Product_model', 'prod_model');
        $this->load->model('basic_model');
        $this->load->library(['User_nav_lib', 'Product_lib']);
    }

    public function addMetricInfo() {
        $this->user_auth_lib->check_login();
        if (request_is_post()) {
            if ($this->prod_model->saveMetricInfo(request_post_data())) {
                notify('success', "Operation was successful");
            } else {
                notify('error', "Unable to complete your request, pls try again");
            }
            redirect($this->input->server('HTTP_REFERER'));
        }
    }
    
    public function delete_metric_info($id) {
        $this->user_auth_lib->check_login();
        if ($this->basic_model->delete(Setup_model::TBL_PRODUCT_METRIC_INFO, ['product_metric_info_id' => $id])){
            notify('success', "Operation was successful");          
        }else{
            notify('error', "Ops! Unable to delete selected metric information, pls try again later");
        }
        redirect($this->input->server('HTTP_REFERER'));
        
    }

}
