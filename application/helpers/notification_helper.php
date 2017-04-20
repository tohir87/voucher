<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/**
 * Notification helper
 * display error, success or notification errors
 */
if (!function_exists('show_notification')) {

    function show_notification() {
        //Display error/success message 
        $CI = & get_instance();  //get instance, access the CI superobject

        if ($CI->session->flashdata('type') != NULL) {
            ?>

            <div class="alert alert-<?php echo $CI->session->flashdata('type') ?>">
                <button type="button" class="close" data-dismiss="alert">×</button>
            <?php echo $CI->session->flashdata('msg'); ?>
            </div>
            <?php
        }
    }

}


if (!function_exists('notify')) {

    function notify($type, $message, $redirect_url = null) {
        if (empty($type) || empty($message)) {
            return false;
        }

        $CI = & get_instance();

        $CI->session->set_flashdata('type', $type);
        $CI->session->set_flashdata('msg', $message);
        if (!empty($redirect_url)) {
            redirect($redirect_url, 'refresh');
        }
    }

}



if (!function_exists('show_no_data')) {

    function show_no_data($descriptive_text = null) {
        $message = '<div class="row-fluid">
                    <ul class="messages">
                      <li class="left">
                        <div class="image"><img src="/img/ctm_logo_sm.png"></div>
                        <div class="message">
                          <span class="caret"></span>
                          <span class="name">COMPARE THE MARKETS</span>
                          <p>' . $descriptive_text . '</p>
                                    
                        </div>
                      </li>
                    </ul>
                </div>';

        return $message;
    }

} 