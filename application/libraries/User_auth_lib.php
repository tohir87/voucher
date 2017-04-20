<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * CTM
 * User auth lib
 * 
 * @category   Library
 * @package    Users
 * @subpackage Authentication
 * @author     Tohir O. <otcleantech@gmail.com>
 * @copyright  Copyright Â© 2015 EduPortal Nigeria Ltd.
 * @version    1.0.0
 * @since      File available since Release 1.0.0
 * 
 * @property user_model $user_model Description
 */
class User_auth_lib {

    private $email_user;
    private $user_id;

    /**
     * Codeigniter instance
     * 
     * @access private
     * @var object
     */
    private $CI;
    private $statuses;

    /**
     * Class constructor
     * 
     * @access public
     * @return void
     */
    private $default_perms = array(
        'User' => array(
            1 => array(
                'change_password' => 3,
            ),
            2 => array(
                'products' => 10,
                'markets' => 9,
                'categories' => 4,
                'sources' => 5,
                'varieties' => 6,
                'wholesale_metric' => 7,
                'retail_metric' => 8,
                'view_product' => 25,
            ),
            3 => array(
                'addprice' => 11
            )
        ),
        'Subscriber' => array(
            1 => array(
                'change_password' => 3,
            ),
            5 => array(
                'report' => 35,
                'analytics' => 36,
                'retail-analytics' => 37,
                'source-products' => 38,
            ),
        )
    );

    public function __construct() {

        // Load CI object
        $this->CI = get_instance();

        // Load libraries
        $this->CI->load->library(['session', 'user_agent']);

        // Load models
        $this->CI->load->model('user/user_model');
        $this->CI->load->model('setup/market_model');

        $this->CI->load->helper(['url', 'notification_helper', 'string']);

        // Set user email value form sessions
        $this->email_user = $this->CI->session->userdata('email');
        $this->user_id = $this->CI->session->userdata('user_id');

        $this->statuses = array(
            USER_STATUS_INACTIVE => 'Inactive',
            USER_STATUS_ACTIVE => 'Active'
        );
    }

    /**
     * Login method
     *
     * @access public
     * @param string $email
     * @param string $password
     * @return mixed (bool | array)
     * */
    public function login($params) {

        if (trim($params['email']) === '' || trim($params['password']) === '') {
            return false;
        }

        $loginWhere = array('email' => trim($params['email']), 'password' => $this->encrypt(trim($params['password'])));

        // Fetch user data from database by email and password
        $result = $this->CI->user_model->fetchaccount($loginWhere);

        if (!$result) {
            // User does not exists
            $message = 'Invalid E-mail/password.';
            return null;
        } else {

            $basicdata = array(
                'status' => $result->status,
                'access_level' => $result->user_type_id,
                'user_id' => $result->user_id
            );
        }



        if ($result->status == USER_STATUS_ACTIVE) {

            $result->user_type_id == USER_TYPE_ADMIN ? $this->CI->user_model->assignAllPerm($result->user_id) : '';



            $key = sha1($result->email . '_' . $result->status . '_' . $result->user_type_id);

            // Build user session array
            $session_vars = array(
                // More session variables to be added later here.
                'user_id' => $result->user_id,
                'email' => $result->email,
                'status' => $result->status,
                'access_level' => $result->user_type_id,
                'display_name' => $result->first_name,
                'first_name' => $result->first_name,
                'last_name' => $result->last_name,
                'k' => $key
            );

            // Add user record details to session
            $this->CI->session->set_userdata($session_vars);
            $this->assignDefaultPermissions();  // Assign default permissions based on user type
            return $basicdata;
        } else {
            $this->lastError = 'Account inactive.';
            return null;
        }
    }

    public function assignDefaultPermissions() {
        if ($this->get('access_level') == USER_TYPE_ORDINARY) {
            $this->CI->user_model->assignDefaultPermissions($this->get('user_id'), $this->default_perms['User']);
        } elseif ($this->get('access_level') == USER_TYPE_SUBSCRIBER) {
            $this->CI->user_model->assignDefaultPermissions($this->get('user_id'), $this->default_perms['Subscriber']);
        }
    }

    /**
     * Encrypt string to sha1 
     * 
     * @access public
     * @param string $str
     * @return string
     */
    public static function encrypt($str) {
        return sha1($str);
    }

    /**
     * Check if user logged in
     *
     * @access public
     * @return bool
     * */
    public function logged_in() {

        $cdata = array(
            'email' => $this->CI->session->userdata('email'),
            'status' => $this->CI->session->userdata('status'),
            'access_level' => $this->CI->session->userdata('access_level')
        );

        foreach ($cdata as $data) {
            if (trim($data) == '') {
                return false;
            }
        }

        $s_k = $this->CI->session->userdata('k');
        $c_k = sha1($cdata['email'] . '_' . $cdata['status'] . '_' . $cdata['access_level']);

        if ($s_k != $c_k) {
            return false;
        }

        return true;
    }

    public function logout() {
//        $this->log_user_action('Admin logged out successfully.', 2301);
        // Destroy current user session
        $this->CI->session->sess_destroy();
    }

    /**
     * Get session variable value assigned to user. 
     * 
     * @access public
     * @param string $item
     * @return mixed (bool | string)
     */
    public function get($item = null) {

        if (!$this->logged_in()) {
            return false;
        }

        return $item === null ? $this->CI->session->all_userdata() : $this->CI->session->userdata($item);
    }

    /**
     * Redirect to login page if user not logged in.
     * 
     * @access public
     * @return void
     */
    public function check_login($url = '') {

        if (!$url) {
            $url = $this->CI->input->server('REQUEST_URI');
        }

        if (!$this->logged_in()) {
            redirect(site_url('login') . '?next_url=' . urlencode($url));
        }
    }

    public function check_sub_login($url = '') {

        if (!$url) {
            $url = $this->CI->input->server('REQUEST_URI');
        }

        if (!$this->logged_in()) {
            redirect(site_url('/register') . '?next_url=' . urlencode($url));
        }
    }

    public function getStatuses() {
        return $this->statuses;
    }

    /**
     * Redirect to user's access denied page, if user have not permission.
     * 
     * @access public 
     * @param int|array $id_perm ID of the permission 
     * or an array of module (id_string of module) and permission (id_string of permission)
     * @return void
     */
    public function check_perm($id_perm) {
        if (!$this->have_perm($id_perm)) {
            show_error("You do not have the neccessary permissions to access this page. Please contact your system administrator to grant your permission to this page. If you have just been granted permission to this page, you may need to <a href='/logout'>logout</a> and then login again.", 403, 'Access Denied');
        }
    }

    /**
     * Check if user has permission 
     * 
     * @access public
     * @param int|array|string $id_perm ID of the permission 
     * or an array of module (id_string of module) and permission (id_string of permission)
     * or a string in the form module:permission
     * @param int user_id
     * @return bool
     */
    public function have_perm($id_perm) {

        $ret = false;

        if (is_string($id_perm) && strpos($id_perm, ':')) {
            $parts = explode(':', $id_perm, 2);
            $id_perm = ['module' => $parts[0], 'permission' => $parts[1]];
        }


        if (is_array($id_perm)) {
            assert(isset($id_perm['module'], $id_perm['permission']), 'Module and Permission string must be set');
            if ($id_perm['module'] && $id_perm['permission']) {
                $db = $this->CI->load->database('', true);
                /* @var $db CI_DB_active_record */
                $result = $db->select('up.perm_id')
                        ->from('user_perms AS up')
                        ->join('module_perms AS mp', 'mp.perm_id = up.perm_id')
                        ->join('modules AS m', 'm.module_id = mp.module_id')
                        ->where(array(
                            'm.id_string' => $id_perm['module'],
                            'mp.id_string' => $id_perm['permission'],
                            'up.user_id' => $this->user_id
                        ))
                        ->get()
                        ->result_array()
                ;
                $ret = !empty($result);
            }
        } else {
            if (is_numeric($id_perm) && is_numeric($this->user_id)) {
                $ret = $this->CI->user_model->get_user_perm(
                        array(
                            'user_id' => $this->user_id,
                            'perm_id' => $id_perm
                ));
            }
        }

        return $ret;
    }

    public function get_genders() {
        return $this->gender;
    }

    public function is_super_admin() {
        return $this->get('access_level') == USER_TYPE_ADMIN;
    }

    public function is_subscriber() {
        return $this->get('access_level') == USER_TYPE_SUBSCRIBER;
    }

    public function get_statuses() {
        return ['Inactive', 'Active'];
    }

    public function getUserMarkets($user_id) {
        return $this->CI->market_model->fetchUserMarkets($user_id);
    }

    public function log_user_action($message, $id_log, $url = null, $level = 0) {

        $iplocator = \utils\IpaddressLocator::fetchIpaddressCityCountry($this->CI->input->ip_address());
        $ip = json_decode($iplocator);

        if ($ip->status == 'success') {
            $city = $ip->city;
            $country = $ip->country;
        } else {
            $city = '';
            $country = '';
        }

        $this->CI->user_model->log_db(array(
            'user_id' => $this->get('user_id'),
            'message' => $message,
            'type' => $id_log,
            'log_date' => date('Y-m-d H:i:s'),
            'ip_address' => ip2long($this->CI->input->ip_address()),
            'user_agent' => $this->CI->agent->agent_string(),
            'session_id' => $this->CI->session->userdata('session_id'),
            'city' => $city,
            'country' => $country,
            'url' => $url,
            'level' => $level
        ));
    }

    public function isActiveSubscriber() {
        $this->CI->load->model('setup/subscription_model', 'sub_model');
        if ($this->is_subscriber()) {
            $status = $this->CI->sub_model->isActive($this->user_id);
            if ($status) {
                return TRUE;
            } else {
                show_error('Your account has not been activated');
            }
        }
    }

}
