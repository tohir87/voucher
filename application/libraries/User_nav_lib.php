<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

require_once 'Page_nav.php';

/**
 * Eduportal
 * Company User nav lib
 * 
 * @category   Library
 * @package    Company
 * @subpackage User_nav
 * @author     Tohir O. <otcleantech@gmail.com>
 * @copyright  Copyright Â© 2015 EduPortal Nigeria Ltd.
 * @version    1.0.0
 * @since      File available since Release 1.0.0
 * @property User_auth_lib $user_auth_lib Description
 */
class User_nav_lib extends Page_nav {

    protected $CI;
    private $user_id;
    private $account_type;

    public function __construct() {
        $this->CI = & get_instance();
        $this->CI->load->library('user_auth_lib');
//        $this->CI->load->helper('user_nav_helper');

        // Load model
        $this->CI->load->model('user/user_model');

        $this->user_id = $this->CI->user_auth_lib->get("user_id");
        $this->account_type = $this->CI->user_auth_lib->get("access_level");
    }

    public function get_user_link() {
        $user_type = $this->CI->user_auth_lib->get('access_level');

        if ($user_type == USER_TYPE_ADMIN) {
            $user_link = 'admin';
        } elseif ($user_type == USER_TYPE_ORDINARY) {
            $user_link = 'user';
        } elseif ($user_type == USER_TYPE_SUBSCRIBER) {
            $user_link = 'subscriber';
        }

        return $user_link;
    }
  

    public function get_top_menu() {
        $user_type = $this->CI->user_auth_lib->get('access_level');
        return array(
//            'dashboard_url' => '/' . $this->get_user_link() . '/dashboard',
            'dashboard_url' => '/admin/dashboard',
            'logout_url' => $user_type == USER_TYPE_SUBSCRIBER ? site_url('/subscriber/logout') : site_url('/logout'),
            'display_name' => $this->CI->user_auth_lib->get('display_name'),
            'user_markets' => [],
        );
    }

    public function company_name() {
        return BUSINESS_NAME;
    }

}
