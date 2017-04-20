<?php

/**
 * Description of page_nav
 *
 * @author TOHIR
 */
abstract class page_nav {

    protected $CI;

    public function __construct() {
        $this->CI = & get_instance();
    }


    abstract public function get_user_link();

    abstract public function get_top_menu();

    abstract public function company_name();

    public function run_page($view_script, $data = [], $title = BUSINESS_NAME) {
//        $nav_menu = $this->get_assoc();
        
        $header_data = array(
            'page_title' => $title
        );
       
        $top_menu_data = array(
            'user_link' => $this->get_user_link()
        );
        
        $left_sidebar_data =  array(
            'company_name' => $this->company_name(),
            'side_nav_menu' => ''
            );

        $page_parts = array_merge(array(
            'page_content' => function() use ($view_script, $data) {
                $this->CI->load->view($view_script, $data, false);
            }
        ), $left_sidebar_data, $this->get_top_menu(), $header_data );
        
        
        $this->CI->load->view('templates/page', $page_parts);
    }

}
