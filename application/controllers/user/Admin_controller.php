<?php

/**
 * Description of Admin_controller
 *
 * @author TOHIR
 * 
 * @property User_auth_lib $user_auth_lib Description
 * @property User_nav_lib $user_nav_lib Description
 * @property CI_Loader $load Description
 * @property User_model $u_model Description
 * @property Basic_model $basic_model Description
 * @property Market_model $mkt_model Description
 * @property Advert_model $ads_model Description
 */
class Admin_controller extends CI_Controller {

    public function __construct() {
        parent::__construct();

        $this->load->model('user/User_model', 'u_model');
        $this->load->model('setup/Setup_model', 'setup_model');
        $this->load->model('setup/Advert_model', 'ads_model');
        $this->load->model('setup/market_model', 'mkt_model');
        $this->load->model('basic_model');
        $this->load->library(['User_nav_lib', 'mailer']);
    }

    public function dashboard() {
        $this->user_auth_lib->check_login();

        $data = array(
            'markets' => $this->basic_model->fetch_all_records(Setup_model::TBL_PROVIDERS),
        );

        $this->user_nav_lib->run_page('dashboard/landing', $data, BUSINESS_NAME);
    }

    public function users() {
        $this->user_auth_lib->check_login();
        $this->user_auth_lib->check_perm('admin:users');

        if (request_is_post()) {
            $data = request_post_data();
            $data['date_created'] = date('Y-m-d h:i:s');
            $data['password'] = $this->user_auth_lib->encrypt('password');
            $data['status'] = USER_STATUS_ACTIVE;
            if ($this->u_model->save($data)) {
                notify('success', 'User created successfully');
            } else {
                notify('error', 'Unable to create user at moment, pls try again.');
            }
        }

        $data = array(
            'users' => $this->u_model->fetchUsers()
        );

        $this->user_nav_lib->run_page('user/list', $data, 'Users Directiry | ' . BUSINESS_NAME);
    }

    public function user_types() {
        $this->user_auth_lib->check_login();
        $this->user_auth_lib->check_perm('admin:user_types');
        $data = array(
            'user_types' => $this->basic_model->fetch_all_records(User_model::TBL_USER_TYPE)
        );

        $this->user_nav_lib->run_page('user/types', $data, 'User Types | ' . BUSINESS_NAME);
    }

    public function changeUserStatus($user_id) {
        if ($this->u_model->toggleStatus($user_id)) {
            notify('success', "User status changed successfully");
        } else {
            notify('error', "Status change could not be completed");
        }

        redirect($this->input->server('HTTP_REFERER') ? : site_url('/admin/users'));
    }

    public function get_market_products($market_id) {

        $products = $this->mkt_model->fetchMarketProducts($market_id);

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
    
    public function processContact() {
        if (request_is_post()){
            echo $this->basic_model->saveContact(request_post_data());
            
        }
    }
    
    

}
