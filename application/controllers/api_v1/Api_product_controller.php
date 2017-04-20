<?php

require_once 'Api_base_controller.php';

/**
 * Description of Api_product_controller
 *
 * @author tohir
 */
class Api_product_controller extends Api_Base_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function sources() {
        if (isset($_GET['product_id']) && is_numeric($_GET['product_id'])) {
            $this->response['sources'] = $this->setup_model->fetchProductSources($_GET['product_id'], api\Sources::class) ? : [];
        } else {
            $this->response['sources'] = $this->b_model->fetch_all_records(Setup_model::TBL_SOURCES, ['status' => ACTIVE], api\Sources::class) ? : [];
        }

        $this->apiOutput();
    }
    
    public function varieties() {
        if (isset($_GET['product_id']) && is_numeric($_GET['product_id'])) {
            $this->response['sources'] = $this->setup_model->fetchProductVarieties($_GET['product_id'], api\Variety::class) ? : [];
        } else {
            $this->response['varieties'] = $this->b_model->fetch_all_records(Setup_model::TBL_VARIETIES, ['status' => ACTIVE], api\Variety::class) ? : [];
        }

        $this->apiOutput();
    }

    public function price() {

        $product_id = $this->input->get('product_id');

        if (!isset($product_id) || !is_numeric($product_id)) {
            $this->response['errors'][] = array(
                'id' => 404,
                'message' => 'Product ID is missing'
            );
        }
        
        $this->response['prices'] = $this->price_model->fetchProductPrices($product_id) ? : [];
        $this->apiOutput();
    }
    
    public function market_price() {
        $product_id = $this->input->get('product_id');
        
        if (!isset($product_id) || !is_numeric($product_id)) {
            $this->response['errors'][] = array(
                'id' => 404,
                'message' => 'Product ID is missing'
            );
        }
       
        
        $this->response['prices'] = $this->price_model->fetchProductPriceByMarket($product_id) ? : [];
        $this->apiOutput();
        
    }
    
    public function market_price_web() {
        $product_id = $this->input->get('product_id');
        
        if (!isset($product_id) || !is_numeric($product_id)) {
            $this->response['errors'][] = array(
                'id' => 404,
                'message' => 'Product ID is missing'
            );
        }
        
        $this->response['prices'] = $this->price_model->fetchProductPriceByMarketWeb($product_id) ? : [];
        $this->apiOutput();
        
    }
    
    public function search() {
        $text = $this->input->get('p_name') ? : '';
        $this->response['product'] = $this->price_model->searchProducts($text, api\Products::class) ? : [];
        $this->apiOutput();
    }
    
    public function view() {
        $pid = $this->input->get('p_id') ? : '';
        $this->response['product'] = $this->m_model->fetchProductDetails($pid, api\Products::class) ? : [];
        $this->apiOutput();
    }
    
    public function categories() {
        $category_id = $this->input->get('id') ? : '';
        if ((int) $category_id > 0){
            $this->response['products'] = $this->price_model->getProductsByCategory($category_id, api\Products::class) ? : [];
        }else{
            $this->response['categories'] = $this->b_model->fetch_all_records('categories', ['status' => ACTIVE], api\Categories::class) ? : [];
        }
         
        $this->apiOutput();
    }
    
    public function allProductPrices() {
        $products = $this->m_model->fetchMarketProductsApi(NULL, api\Products::class);
        $result = [];
        if (!empty($products)){
            foreach ($products as $product) {
                $result[] = (object) array_merge( (array) $product, ['prices' => $this->price_model->fetchProductPrices($product->product_id)] );
            }
        }
        
        $this->response['products'] = $result;
        $this->apiOutput();
    }

}
