<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Description of User_controller
 *
 * @author TOHIR
 * 
 * @property User_auth_lib $user_auth_lib Description
 * @property User_nav_lib $user_nav_lib Description
 * @property CI_Loader $load Description
 * @property User_model $u_model Description
 * @property Basic_model $basic_model Description
 * @property Market_model $market_model Description
 * @property Pin_lib $pin_lib Description
 */
class User_controller extends CI_Controller {

    public function __construct() {
        parent::__construct();

        $this->load->library(['user_nav_lib', 'pin_lib']);
        $this->load->helper('auth_helper');

        $this->load->model('user/user_model', 'u_model');
        $this->load->model('setup/market_model', 'market_model');
        $this->load->model('setup/setup_model', 'setup_model');
        $this->load->model('basic_model');
    }

    public function login() {

        $redirect_url = '';
        if ($this->uri->segment(2)) {
            $redirect_url .= $this->uri->segment(2) . '/';
        }

        if ($this->uri->segment(3)) {
            $redirect_url .= $this->uri->segment(3) . '/';
        }

        auth_save_next_url($redirect_url);

        log_message('error', "Testing CI log");

        if ($this->user_auth_lib->logged_in()) {
            $this->redirect_user_by_type($this->user_auth_lib->get('access_level'));
        }

        $email_message = '';
        $password_message = '';

        if (request_is_post()) {
            $response = $this->user_auth_lib->login(request_post_data());

            if (!$response) {
                $email_message = 'Invalid E-mail/password.';
            } else {
                if (auth_next_url()) {
                    redirect(auth_next_url());
                }
                $this->redirect_user_by_type($response['access_level']);
            }
        }

        $data = array(
            'email_message' => $email_message,
            'password_message' => $password_message,
        );
        $this->load->view('templates/login', $data);
    }

    public function redirect_user_by_type($access_type) {
        switch ((int) $access_type) {
            case USER_TYPE_ADMIN:
                redirect('admin/dashboard');
                break;
            case USER_TYPE_ORDINARY:
                redirect('admin/dashboard');
                break;
            default:
                break;
        }
    }

    public function forgot_password() {
        echo 'Coming soon...';
    }

    public function logout() {
        $this->user_auth_lib->logout();
        redirect(site_url('/login'));
    }

    public function change_password() {
        $this->user_auth_lib->check_login();

        if (request_is_post()) {
            if (!$this->u_model->verify_password(request_post_data()['current_password'], $this->user_auth_lib->get('user_id'))) {
                notify('error', 'Ops! You \'ve entered an incorrect password ');
                redirect(site_url('/user/change_password'));
            }

            if (request_post_data()['new_password'] !== request_post_data()['new_password2']) {
                notify('error', 'Ops! The passwords you \'ve entered do not match ');
                redirect(site_url('/user/change_password'));
            }
            if (strlen(request_post_data()['new_password']) < 6) {
                notify('error', 'Ops! Your passwords can\'t be less than 6 characters ');
                redirect(site_url('/user/change_password'));
            }
            if ($this->u_model->update_password(request_post_data()['new_password'], $this->user_auth_lib->get('user_id'))) {
                notify('success', 'Password changed successfully ');
                redirect(site_url('/logout'));
            } else {
                notify('error', 'Unable to update your password at moment, pls try again ');
                redirect(site_url('/user/change_password'));
            }
        }
        $data = array();
        $this->user_nav_lib->run_page('user/change_password', $data, 'Change Password | ' . BUSINESS_NAME);
    }

    public function deleteUser($id) {
        $this->user_auth_lib->check_login();
        if ($this->basic_model->delete(TBL_USERS, ['user_id' => $id])) {
            notify('success', 'User deleted successfully');
        } else {
            notify('error', 'Unable to delete user at moment, pls try again later');
        }
        redirect(site_url('/admin/users'));
    }

    public function edit_user($id) {
        $this->user_auth_lib->check_login();
//        $this->user_auth_lib->check_perm('setup:edit_market');

        if (request_is_post()) {
            if ($this->basic_model->update(TBL_USERS, array_merge(request_post_data(), ['date_updated' => date('Y-m-d h:i:s')]), ['user_id' => $id])) {
                $this->u_model->clear_user_perms($id);
                notify('success', 'User info updated successfully');
            } else {
                notify('error', 'Unable to update user info at moment, pls try again');
            }
            redirect(site_url('/admin/users'));
        }

        $data = array(
            'user_info' => $this->basic_model->fetch_all_records(TBL_USERS, ['user_id' => $id])[0],
        );

        $this->load->view('user/_edit', $data);
    }

    public function view_price_logs() {
        $this->user_auth_lib->check_login();
//        $this->user_auth_lib->check_perm('market:view_price_logs');

        $data = array(
            'logs' => $this->market_model->fetchPriceLogs()
        );

        $this->user_nav_lib->run_page('user/logs/price_logs', $data, "Price Logs |" . BUSINESS_NAME);
    }

    public function view_plog_details($market_id, $added_by) {
        $this->user_auth_lib->check_login();
//        $this->user_auth_lib->check_perm('market:view_price_logs');

        $data = array(
            'logs' => $this->market_model->fetchPriceLogDetails($market_id, $added_by)
        );

        $this->user_nav_lib->run_page('user/logs/price_log_details', $data, "Price Logs |" . BUSINESS_NAME);
    }

    public function assign_market($user_id) {
        $this->user_auth_lib->check_login();

        if (request_is_post()) {
            if ($this->market_model->assignUserToMarket($user_id, request_post_data())) {
                notify('sucess', 'Operation was successful');
            } else {
                notify('error', 'Unable to complete your request at moment, pls try again');
            }
            redirect(site_url('/admin/users'));
        }

        $data = array(
            'assigned_markets' => $this->basic_model->fetch_all_records('market_access', ['user_id' => $user_id]),
            'markets' => $this->basic_model->fetch_all_records(Setup_model::TBL_MARKETS, ['status' => ACTIVE]),
            'user_id' => $user_id
        );

        $this->load->view('user/_add_market', $data);
    }

    public function upload() {
        $this->user_auth_lib->check_login();
        
        if (request_is_post()) {
            if ($this->pin_lib->processPin(request_post_data(), $_FILES['userfile'])) {
                notify('success', "Upload was successful");
            }else{
                notify('error', "Upload could not be completed, please try again");
            }
            
            redirect(site_url('/upload'));
        }

        $data = [
            'providers' => $this->basic_model->fetch_all_records('providers')
        ];


        $this->user_nav_lib->run_page('user/upload', $data, 'Upload' . BUSINESS_NAME);
    }
    
    public function batches() {
        $this->user_auth_lib->check_login();
        $pageData = [
            'batches' => $this->basic_model->batches()
        ];
        
        $this->user_nav_lib->run_page('user/batches', $pageData, 'Batches' . BUSINESS_NAME);
    }

}
