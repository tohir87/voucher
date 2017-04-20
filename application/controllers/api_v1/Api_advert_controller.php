<?php

require_once 'Api_base_controller.php';

/**
 * Description of Api_advert_controller
 *
 * @author tohir
 * @property Advert_model $advert_model Description
 * @property CI_Loader $load Description
 */
class Api_advert_controller extends Api_Base_Controller {

    public function __construct() {
        parent::__construct();
        
        $this->load->model('setup/advert_model');
    }
    
    public function index() {
        $this->response['adverts'] = $this->advert_model->fetch_all_adverts(\api\Adverts::class) ? : [];

        $this->apiOutput();
    }

}
