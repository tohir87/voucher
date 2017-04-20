<?php

/**
 * Description of Mixpanel_lib
 *
 * @author tohir
 */
class Mixpanel_lib {

    private $mp;

    public function __construct() {
        $this->CI = & get_instance();

        $this->_init();
    }

    private function _init() {
        if (!$this->mp) {
            $this->mp = Mixpanel::getInstance(MIXPANEL_PROJECT_TOKEN);
        }
    }

    /**
     * 
     * $params['message'] Message
     * $params['action'] Action name
     * @param type $params
     */
    public function track($params) {
        if (ENVIRONMENT !== 'development') {
            return $this->mp->track($params['message'], array("label" => $params['action'], "ip" => $this->CI->input->ip_address()));
        }
    }

    public function setPeople($user_id, $data) {
        if (ENVIRONMENT !== 'development') {
            return $this->mp->people->set($user_id, $data);
        }
    }

}
