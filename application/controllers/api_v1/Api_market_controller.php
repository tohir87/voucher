<?php

require_once 'Api_base_controller.php';

/**
 * Description of Api_market_controller
 *
 * @author tohir
 */
class Api_market_controller extends Api_Base_Controller {
    public function __construct() {
        parent::__construct();

        
    }

    public function index() {
        $this->response['markets'] = $this->m_model->fetchAllMarkets(api\Market::class) ? : [];
        
        $this->apiOutput();
    }
    
    /**
     * Return All products if no market is set
     */
    public function products() {
        $market_id = NULL;
        
        if ($this->input->get('market_id')){
            $market_id = $this->input->get('market_id');
        }
        
        $this->response['products'] = $this->m_model->fetchMarketProductsApi($market_id, api\Products::class) ? : [];
        
        $this->apiOutput();
    }
   
}
