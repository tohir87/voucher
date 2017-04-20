<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * Description of market
 *
 * @author TOHIR
 * @property User_auth_lib $user_auth_lib Description
 * @property User_nav_lib $user_nav_lib Description
 * @property CI_Loader $load DescriptFion
 * @property User_model $u_model Description
 * @property Basic_model $basic_model Description
 * @property Setup_model $setup_model Description
 * @property Market_model $market_model Description
 */
class Market_controller extends CI_Controller {

    public function __construct() {
        parent::__construct();

        $this->load->model('user/User_model', 'u_model');
        $this->load->model('setup/Setup_model', 'setup_model');
        $this->load->model('setup/Market_model', 'market_model');
        $this->load->model('basic_model');
        $this->load->library(['User_nav_lib']);
    }

    public function prices() {
        $this->user_auth_lib->check_login();

        $data = [];

        $this->user_nav_lib->run_page('market/prices', $data, 'Prices | ' . BUSINESS_NAME);
    }

    public function addPrice($product_id, $product_name = '') {
        $this->user_auth_lib->check_login();
        $this->user_auth_lib->check_perm('market:addPrice');

        if (request_is_post()) {
            if ($this->market_model->addMarketPrices(request_post_data())) {
                notify('success', 'Prices added successfully');
            } else {
                notify('error', 'Unable to add market price at moment, pls try again');
            }
            redirect(site_url('/setup/view_product/' . $product_id . '/' . $product_name));
        }

        $data = array(
            'markets' => $this->basic_model->fetch_all_records(Setup_model::TBL_MARKETS),
            'product_details' => $this->setup_model->fetchProducts($product_id)[0],
            'sources' => $this->basic_model->fetch_all_records(Setup_model::TBL_SOURCES, ['status' => ACTIVE]),
            'product_sources' => $this->setup_model->fetchProductSources($product_id),
            'product_varieties' => $this->setup_model->fetchProductVarieties($product_id),
            'product_w_metrics' => $this->setup_model->fetchProductWsMetrics($product_id),
            'product_r_metrics' => $this->setup_model->fetchProductRtMetrics($product_id),
            'remarks' => $this->basic_model->fetch_all_records(Setup_model::TBL_REMARKS, ['status' => ACTIVE])
        );

        $this->user_nav_lib->run_page('market/addPrice', $data, 'Prices | ' . BUSINESS_NAME);
    }

    public function delete_market($id) {
        $this->user_auth_lib->check_login();
        if ($this->basic_model->fetch_all_records(Market_model::TBL_MARKET_PRICES, ['market_id' => $id])) {
            notify('error', 'Sorry, Product prices has been recorded for this market.');
            redirect($this->input->server('HTTP_REFERER') ? : site_url('/setup/markets'));
            return;
        }
        if ($this->basic_model->delete(Setup_model::TBL_MARKETS, ['market_id' => $id])) {
            notify('success', 'Market deleted successfully');
        } else {
            notify('error', 'Unable to delete market at moment, pls try again');
        }
        redirect($this->input->server('HTTP_REFERER') ? : site_url('/setup/markets'));
    }

    public function changeMarketStatus($id, $status) {
        $this->user_auth_lib->check_login();
        $this->user_auth_lib->check_perm('setup:edit_market');

        if ($this->basic_model->update(Setup_model::TBL_MARKETS, ['status' => $status > 0 ? 0 : 1], ['market_id' => $id])) {
            notify('success', 'Market status changed successfully');
        } else {
            notify('error', 'Unable to change market status, pls try again');
        }
        redirect($this->input->server('HTTP_REFERER') ? : site_url('/setup/markets'));
    }

    public function edit_market($id) {
        $this->user_auth_lib->check_login();
        $this->user_auth_lib->check_perm('setup:edit_market');

        if (request_is_post()) {
            if ($this->basic_model->update(Setup_model::TBL_MARKETS, array_merge(request_post_data(), ['date_updated' => date('Y-m-d h:i:s')]), ['market_id' => $id])) {
                notify('success', 'Market updated successfully');
            } else {
                notify('error', 'Unable to update market at moment, pls try again');
            }
            redirect(site_url('/setup/markets'));
        }
        $data = array(
            'states' => $this->basic_model->fetch_all_records('states'),
            'market_info' => $this->basic_model->fetch_all_records(Setup_model::TBL_MARKETS, ['market_id' => $id])[0],
        );

        $this->load->view('setup/market/_edit', $data);
    }

    public function addRecentPrice($product_id, $product_name = '') {
        $this->user_auth_lib->check_login();
        $this->user_auth_lib->check_perm('market:addPrice');

        if (request_post_data()['market_date'] === '' || request_post_data()['market_id'] === '') {
            notify('error', 'Market date not found, make sure you select a date on the popup modal');
            redirect(site_url('/setup/view_product/' . $product_id . '/' . $product_name));
        }

        if ($this->market_model->addRecentPrice($product_id, request_post_data())) {
            notify('success', 'Price added successfully');
        } else {
            notify('error', 'Unable to add price at moment, pls try again later');
        }
        redirect(site_url('/setup/view_product/' . $product_id . '/' . $product_name));
    }

    public function pending_approval() {
        $this->user_auth_lib->check_login();
        $this->user_auth_lib->check_perm('market:pending_approval');

        $data = array(
            'markets' => $this->basic_model->fetch_all_records(Setup_model::TBL_MARKETS, ['status' => ACTIVE])
        );

        $this->user_nav_lib->run_page('market/pending_approvals', $data, 'Pending Approvals | ' . BUSINESS_NAME);
    }

    public function view_market_products($market_id) {
        $this->user_auth_lib->check_login();
        $this->user_auth_lib->check_perm('market:pending_approval');

        $start_date = null;
        $end_date = null;
        $pending_approvals = $this->market_model->fetchPendingProducts($market_id);
        if (request_is_post()) {
            $start_date = request_post_data()['start_date'];
            $end_date = request_post_data()['end_date'];
            $pending_approvals = $this->market_model->fetchPendingProducts($market_id, $start_date, $end_date);
        }

        $data = array(
            'pending_approvals' => $pending_approvals,
            'start_date' => $start_date,
            'end_date' => $end_date
        );

        $this->user_nav_lib->run_page('market/review_products', $data, 'Products Pending Approvals | ' . BUSINESS_NAME);
    }

    public function view_price_detail($market_price_id) {
        $this->user_auth_lib->check_login();
        $this->user_auth_lib->check_perm('market:pending_approval');

        $data = array(
            'wholesale_prices' => $this->market_model->fetchMarketWholesalePrices($market_price_id),
            'retail_prices' => $this->market_model->fetchMarketRetailPrices($market_price_id)
        );

        $this->load->view('market/view_prices', $data);
    }

    public function approve_prices($market_id, $product_id) {
        $this->user_auth_lib->check_login();
        $this->user_auth_lib->check_perm('market:pending_approval');

        if ($this->basic_model->update(Market_model::TBL_MARKET_PRICES, ['status' => APPROVED], ['product_id' => $product_id, 'market_id' => $market_id])) {
            notify('success', 'Approved successfully');
        } else {
            notify('error', 'Ops! Approval failed, pls try again');
        }
        redirect($this->input->server('HTTP_REFERER') ? : site_url('/market/pending_approval'));
    }

    public function deleteMarketPrice($market_price_id) {
        $this->user_auth_lib->check_login();
        $this->user_auth_lib->check_perm('market:delete_price');

        if ($this->basic_model->delete(Market_model::TBL_MARKET_PRICES, ['market_price_id' => $market_price_id])) {
            notify('success', 'Price deleted successfully');
        } else {
            notify('error', 'Ops! Unable to delete the selected price, pls try again');
        }
        redirect($this->input->server('HTTP_REFERER') ? : site_url('/setup/products'));
    }

    public function delete_wholesale_price($id) {
        $this->user_auth_lib->check_login();
        $this->user_auth_lib->check_perm('market:delete_price');

        if ($this->basic_model->delete(Market_model::TBL_MARKET_W_PRICES, ['id' => $id])) {
            notify('success', 'Price deleted successfully');
        } else {
            notify('error', 'Ops! Unable to delete the selected price, pls try again');
        }
        redirect($this->input->server('HTTP_REFERER') ? : site_url('/market/pending_approval'));
    }

    public function delete_retail_price($id) {
        $this->user_auth_lib->check_login();
        $this->user_auth_lib->check_perm('market:delete_price');

        if ($this->basic_model->delete(Market_model::TBL_MARKET_R_PRICES, ['id' => $id])) {
            notify('success', 'Price deleted successfully');
        } else {
            notify('error', 'Ops! Unable to delete the selected price, pls try again');
        }
        redirect($this->input->server('HTTP_REFERER') ? : site_url('/market/pending_approval'));
    }

    public function edit_retail_price($id, $product_id, $product_name, $market_price_id) {
        $this->user_auth_lib->check_login();

        if (!$market_price_id){
            redirect($this->input->server('HTTP_REFERER') ? : site_url('/setup/products'));
        }
        
        $url = site_url("/market/edit_retail_price/{$id}/{$product_id}/{$product_name}/{$market_price_id}");
        
        if (request_is_post()) {
            if ($this->basic_model->update(Market_model::TBL_MARKET_R_PRICES, array_merge(request_post_data(), ['price_ave' => (request_post_data()['price_high'] + request_post_data()['price_low']) / 2]), ['id' => $id])) {
                notify('success', 'Price updated successfully');
            } else {
                notify('error', 'Unable to update price at moment, pls try again');
            }
            redirect($this->input->server('HTTP_REFERER') ? : site_url("/setup/view_product/{$product_id}/{$product_name}"));
        }

        $data = array(
            'price' => $this->basic_model->fetch_all_records(Market_model::TBL_MARKET_R_PRICES, ['id' => $id]),
            'product_info' => $this->market_model->fetchMarketPriceInfo($market_price_id),
            'title' => 'Edit Retail Price',
            'form_action' => $url
        );

        $this->load->view('market/edit/edit_price', $data);

    }

    public function edit_wholesale_price($id, $product_id, $product_name, $market_price_id) {
        $this->user_auth_lib->check_login();
        
        if (!$market_price_id){
            redirect($this->input->server('HTTP_REFERER') ? : site_url('/setup/products'));
        }
        
        $url = site_url("/market/edit_wholesale_price/{$id}/{$product_id}/{$product_name}/{$market_price_id}");

        if (request_is_post()) {
            if ($this->basic_model->update(Market_model::TBL_MARKET_W_PRICES, array_merge(request_post_data(), ['price_ave' => (request_post_data()['price_high'] + request_post_data()['price_low']) / 2]), ['id' => $id])) {
                notify('success', 'Price updated successfully');
            } else {
                notify('error', 'Unable to update price at moment, pls try again');
            }
            
            redirect($this->input->server('HTTP_REFERER') ? : site_url("/setup/view_product/{$product_id}/{$product_name}"));
        }

        $data = array(
            'price' => $this->basic_model->fetch_all_records(Market_model::TBL_MARKET_W_PRICES, ['id' => $id]),
            'product_info' => $this->market_model->fetchMarketPriceInfo($market_price_id),
            'title' => 'Edit Wholesale Price',
            'form_action' => $url
        );

        $this->load->view('market/edit/edit_price', $data);
    }

    public function add_wholesale_price($market_price_id, $product_id, $product_name = '') {
        $this->user_auth_lib->check_login();

        // get product id
        $result = $this->basic_model->fetch_all_records(Market_model::TBL_MARKET_PRICES, ['market_price_id' => $market_price_id])[0];

        if (request_is_post()) {
            if ($this->market_model->addWholesalePrices($market_price_id, $result->market_id, request_post_data())) {
                notify('success', 'Wholesale price(s) added successfully');
            } else {
                notify('error', 'Unable to add product wholesale price at moment, pls try again');
            }
            redirect(site_url('/market/editMarketPrice/' . $market_price_id . '/' . $product_id . '/' . $product_name));
        }


        $data = array(
            'product_details' => $this->setup_model->fetchProducts($product_id)[0],
            'product_w_metrics' => $this->setup_model->fetchProductWsMetrics($product_id),
            'product_r_metrics' => $this->setup_model->fetchProductRtMetrics($product_id),
            'product_info' => $this->market_model->fetchMarketPriceInfo($market_price_id),
            'toEnable' => 'wholesale',
            'title' => 'Wholesale Price'
        );

        $this->user_nav_lib->run_page('market/add_wholesale_price', $data, 'Add Prices | ' . BUSINESS_NAME);
    }

    public function add_retail_price($market_price_id, $product_id, $product_name = '') {
        $this->user_auth_lib->check_login();

        // get product id
        $result = $this->basic_model->fetch_all_records(Market_model::TBL_MARKET_PRICES, ['market_price_id' => $market_price_id])[0];


        if (request_is_post()) {
            if ($this->market_model->addRetailPrices($market_price_id, $result->market_id, request_post_data())) {
                notify('success', 'Retail price(s) added successfully');
            } else {
                notify('error', 'Unable to add product retail price at moment, pls try again');
            }
            redirect(site_url('/market/editMarketPrice/' . $market_price_id . '/' . $product_id . '/' . $product_name));
        }


        $data = array(
            'product_details' => $this->setup_model->fetchProducts($product_id)[0],
            'product_r_metrics' => $this->setup_model->fetchProductRtMetrics($product_id),
            'product_info' => $this->market_model->fetchMarketPriceInfo($market_price_id),
            'toEnable' => 'retail',
            'title' => 'Retail Price'
        );

        $this->user_nav_lib->run_page('market/add_wholesale_price', $data, 'Add Prices | ' . BUSINESS_NAME);
    }

    public function delete_bulk_price() {
        $this->user_auth_lib->check_login();
        if (request_is_post()) {

            $market_ids = request_post_data();

            if (empty($market_ids)) {
                notify('error', 'Invalid parameter supplied');
                redirect($this->input->server('HTTP_REFERER') ? : site_url('/setup/products'));
                return;
            }

            if ($this->basic_model->deleteBulkMarket(Market_model::TBL_MARKET_PRICES, $market_ids)) {
                notify('success', 'Price(s) deleted successfully');
            } else {
                notify('error', 'Invalid parameter supplied');
            }

            redirect($this->input->server('HTTP_REFERER') ? : site_url('/setup/products'));
        }
    }

    public function editMarketPrice($market_price_id, $product_id, $product_name) {
        $this->user_auth_lib->check_login();
        $this->user_auth_lib->check_perm('market:edit_price');

        $data = array(
            'wholesale_prices' => $this->market_model->fetchMarketWholesalePrices($market_price_id),
            'retail_prices' => $this->market_model->fetchMarketRetailPrices($market_price_id),
            'product_info' => $this->market_model->fetchMarketPriceInfo($market_price_id),
            'product_id' => $product_id,
            'product_name' => $product_name
        );

        //$this->load->view('market/view_prices', $data);
        $this->user_nav_lib->run_page('market/view_prices', $data, 'Edit Price | ' . BUSINESS_NAME);
    }
    
    public function market_products($market_id = null) {
        $this->user_auth_lib->check_login();
        
        if (request_is_post()){
            if ($this->setup_model->addMarketProducts($market_id, request_post_data())){
                notify('success', 'Products added to market successfully');
            }else{
                notify('error', 'Ops! Something went wrong while adding product to market. Pls try again');
            }
        }
        $data = [
            'products' => $this->market_model->fetchMarketProducts($market_id),
            'allProducts' => $this->basic_model->fetch_all_records(Setup_model::TBL_PRODUCTS, ['status' => ACTIVE]),
            'market_info' => $this->basic_model->fetch_all_records(Setup_model::TBL_MARKETS, ['market_id' => $market_id])[0],
            'markets' => $this->basic_model->fetch_all_records(Setup_model::TBL_MARKETS)
        ];
        $this->user_nav_lib->run_page('setup/market/products_list', $data, 'Market products');
    }

}
