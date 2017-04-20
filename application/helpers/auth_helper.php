<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


if (!function_exists('auth_next_url')) {

    function auth_next_url() {
        $ci = get_instance();
        /* @var $ci Auth */
        $ci->load->library(['session']);
        if ($ci->input->get('next_url')) {
            return $ci->input->get('next_url');
        } else if ($ci->input->post('next_url')) {
            return $ci->input->post('next_url');
        } else if (($next = $ci->session->userdata('next_url'))) {
            $ci->session->unset_userdata('next_url');
            return $next;
        } else {
            return '';
        }
    }

}

if (!function_exists('auth_save_next_url')) {

    function auth_save_next_url($next = '') {

        $ci = get_instance();
        /* @var $ci Auth */
        $ci->load->library(['session']);
        if (!$next) {
            $next = $ci->input->get('next_url') ? : $ci->input->post('next_url');
        }

        if ($next) {
            $ci->session->set_userdata(['next_url' => $next]);
        }
    }

}

if (!function_exists('auth_log_user_action')) {

    function auth_log_user_action($id_user, $message, $type) {
        $ci = get_instance();
		$ci->user_auth->log_user_action($message, $type, null, 1);
    }
}




if (!function_exists('load_user_logs')){
    function load_user_logs(){
        $CI = & get_instance();
        $CI->load->model('user/user_model');
        
        if ($CI->session->userdata('account_type') == ACCOUNT_TYPE_ADMINISTRATOR){
            $user_logs = $CI->user_model->fetchUserLogs($CI->session->userdata('id_company'), [0,1]);
        }else{
            $user_logs = $CI->user_model->fetchUserLogs($CI->session->userdata('id_company'), [0]);
        }
        
        return $user_logs;
    }
}

