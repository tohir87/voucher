<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * Description of Access_controller
 *
 * @author TOHIR
 * 
 * @property User_auth_lib $user_auth_lib Description
 * @property User_nav_lib $user_nav_lib Description
 * @property CI_Loader $load Description
 * @property User_model $u_model Description
 * @property Basic_model $basic_model Description
 */
class Access_controller extends CI_Controller {

    public function __construct() {
        parent::__construct();

        $this->load->model('user/User_model', 'u_model');
        $this->load->model('basic_model');
        $this->load->library(['User_nav_lib']);
    }

    public function index() {
        $this->user_auth_lib->check_login();
        $this->user_auth_lib->check_perm('access_control:view_access_control');

        $data = array(
            'staffs' => $this->basic_model->fetch_all_records('users', ['status' => 1, 'user_type_id <>' => USER_TYPE_SUBSCRIBER ])
        );
        $this->user_nav_lib->run_page('access_control/list', $data, 'Access Control | ' . BUSINESS_NAME);
    }

    public function edit_permissions($user_id) {
        $this->user_auth_lib->check_login();
        $this->user_auth_lib->check_perm('access_control:edit_permission');
        $data = array(
            'staff' => $this->basic_model->fetch_all_records('users', ['user_id' => $user_id])[0],
            'all_perms' => $this->u_model->fetchAllPerms(),
            'modules' => $this->basic_model->fetch_all_records('modules'),
            'unassigned_perms' => $this->u_model->getUnassignedPerms($user_id),
        );
        $this->user_nav_lib->run_page('access_control/edit_permissions', $data, 'Access Control | ' . BUSINESS_NAME);
    }

    public function edit_user_permission() {

        $this->user_auth_lib->check_login();

        if (!$this->user_auth_lib->is_super_admin()) {
            redirect(site_url('user/access_denied'));
            exit();
        }

        $data = $this->input->post();

        $params = explode('/', $data['data']);

        if (strtolower($data['action']) === 'insert') {
            $ret = $this->basic_model->insert('user_perms', array(
                'user_id' => $params[0],
                'perm_id' => $params[1],
                'module_id' => $params[2],
                )
            );
        } elseif (strtolower($data['action']) == 'delete') {
            $ret = $this->basic_model->delete('user_perms', array(
                'user_id' => $params[0],
                'perm_id' => $params[1],
                'module_id' => $params[2],
                )
            );
        } else {
            echo 'Error! Invalid parameter passed.';
        }

        if ($ret > 0) {
            echo 'User permissions updated successfully';
        } else {
            echo 'Error! Unable to edit user permission. Please try again.';
        }
    }

}
