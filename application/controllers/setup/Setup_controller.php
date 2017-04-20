<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * Description of Setup_controller
 *
 * @author TOHIR
 * @property User_auth_lib $user_auth_lib Description
 * @property User_nav_lib $user_nav_lib Description
 * @property CI_Loader $load Description
 * @property User_model $u_model Description
 * @property Basic_model $basic_model Description
 * @property Setup_model $setup_model Description
 * @property Market_model $market_model Description
 * @property Product_lib $product_lib Description
 */
class Setup_controller extends CI_Controller {

    public function __construct() {
        parent::__construct();

        $this->load->model('user/User_model', 'u_model');
        $this->load->model('setup/Setup_model', 'setup_model');
        $this->load->model('setup/Market_model', 'market_model');
        $this->load->model('basic_model');
        $this->load->library(['User_nav_lib', 'Product_lib']);
    }

    public function categories() {

        $this->user_auth_lib->check_login();
        $this->user_auth_lib->check_perm('setup:categories');

        if (request_is_post()) {
            if ($this->setup_model->saveCategories(request_post_data())) {
                notify('success', 'Operation was successful');
            } else {
                notify('error', 'Unable to add category at moment, pls try again');
            }
            redirect(site_url('setup/categories'));
        }

        $data = array(
            'groups' => $this->basic_model->fetch_all_records('groups'),
            'categories' => $this->setup_model->fetch_categories()
        );

        $this->user_nav_lib->run_page('setup/category/categories', $data, 'Categories | ' . BUSINESS_NAME);
    }

    public function sub_categories() {

        $this->user_auth_lib->check_login();

        $data = array(
        );

        $this->user_nav_lib->run_page('setup/sub_categories', $data, 'Sub Categories | ' . BUSINESS_NAME);
    }

    public function sources() {

        $this->user_auth_lib->check_login();
        $this->user_auth_lib->check_perm('setup:sources');

        if (request_is_post()) {
            if ($this->setup_model->saveSources(request_post_data())) {
                notify('success', 'Operation was successful');
            } else {
                notify('error', 'Unable to add source(s) at moment, pls try again');
            }
            redirect(site_url('setup/sources'));
        }

        $data = array(
            'sources' => $this->basic_model->fetch_all_records(Setup_model::TBL_SOURCES)
        );

        $this->user_nav_lib->run_page('setup/source/sources', $data, 'Sources | ' . BUSINESS_NAME);
    }

    public function varieties() {

        $this->user_auth_lib->check_login();
        $this->user_auth_lib->check_perm('setup:varieties');

        if (request_is_post()) {
            if ($this->setup_model->saveVarieties(request_post_data())) {
                notify('success', 'Operation was successful');
            } else {
                notify('error', 'Unable to add variety at moment, pls try again');
            }
            redirect(site_url('setup/varieties'));
        }

        $data = array(
            'varieties' => $this->basic_model->fetch_all_records(Setup_model::TBL_VARIETIES)
        );

        $this->user_nav_lib->run_page('setup/variety/varieties', $data, 'Varieties | ' . BUSINESS_NAME);
    }

    public function changeCategoryStatus($category_id, $status) {
        $this->user_auth_lib->check_login();
        $this->user_auth_lib->check_perm('setup:edit_category');

        if ($this->basic_model->update(Setup_model::TBL_CATEGORIES, ['status' => $status > 0 ? 0 : 1], ['category_id' => $category_id])) {
            notify('success', "Category status changed successfully");
        } else {
            notify('error', "Status change could not be completed");
        }

        redirect($this->input->server('HTTP_REFERER') ? : site_url('/setup/categories'));
    }

    public function json_get_sub_categories($category_id) {
        $this->output->set_content_type('application/json');
        $this->output->_display(json_encode($this->setup_model->fetch_sub_categories($category_id)));
    }

    public function json_metric_ws_categories($metric_wholesale_id, $table) {
        $this->output->set_content_type('application/json');
        $this->output->_display(json_encode($this->setup_model->fetch_metric_ws_categories($table, $metric_wholesale_id)));
    }

    public function add_sub_categories() {
        $this->user_auth_lib->check_login();
        $this->user_auth_lib->check_perm('setup:edit_category');

        if (request_is_post()) {
            if ($this->setup_model->addSubCategory(request_post_data())) {
                notify('success', "Sub category saved successfully");
            } else {
                notify('error', "Ops! Unable to save sub category at moment, pls try again.");
            }
            redirect(site_url('setup/categories'));
        }
    }

    public function deleteSubCategory($id) {
        if ($this->basic_model->delete(Setup_model::TBL_SUB_CATEGORIES, ['sub_category_id' => $id])) {
            notify('success', 'Sub category deleted successfully');
        } else {
            notify('error', 'Unable to delete sub category at momnent, pls try again');
        }

        redirect(site_url('setup/categories'));
    }

    public function deleteProduct($id) {
        $this->user_auth_lib->check_login();
        if ($this->basic_model->delete(Setup_model::TBL_PRODUCTS, ['product_id' => $id])) {
            notify('success', 'Product deleted successfully');
        } else {
            notify('error', 'Unable to delete product at momnent, pls try again');
        }

        redirect(site_url('setup/products'));
    }

    public function wholesale_metric() {
        $this->user_auth_lib->check_login();
        $this->user_auth_lib->check_perm('setup:wholesale_metric');

        if (request_is_post()) {

            if ($this->setup_model->saveMetricWholeSales(request_post_data())) {
                notify('success', 'Operation was successful');
            } else {
                notify('error', 'Unable to add wholesale metric at moment, pls try again');
            }
            redirect(site_url('setup/wholesale_metric'));
        }

        $data = array(
            'w_metrics' => $this->setup_model->fetch_wholesale_metrics(),
            'categories' => $this->basic_model->fetch_all_records(Setup_model::TBL_CATEGORIES, ['status' => 1])
        );

        $this->user_nav_lib->run_page('setup/metrics/metric_wholesale', $data, 'WholeSale Metrics | ' . BUSINESS_NAME);
    }

    public function retail_metric() {
        $this->user_auth_lib->check_login();
        $this->user_auth_lib->check_perm('setup:retail_metric');

        if (request_is_post()) {
            if ($this->setup_model->saveMetricRetail(request_post_data())) {
                notify('success', 'Operation was successful');
            } else {
                notify('error', 'Unable to add retail metric at moment, pls try again');
            }
            redirect(site_url('setup/retail_metric'));
        }

        $data = array(
            'r_metrics' => $this->setup_model->fetch_retail_metrics(),
            'categories' => $this->basic_model->fetch_all_records(Setup_model::TBL_CATEGORIES, ['status' => 1])
        );

        $this->user_nav_lib->run_page('setup/metrics/metric_retail', $data, 'Retail Metrics | ' . BUSINESS_NAME);
    }

    public function deleteMetric($id) {
        $this->user_auth_lib->check_login();
        if ($this->basic_model->delete(Setup_model::TBL_M_WHOLESALES, ['metric_wholesale_id' => $id])) {
            notify('success', 'Metric deleted successfully');
        } else {
            notify('error', 'Unable to delete metric at moment, pls try again');
        }
        redirect($this->input->server('HTTP_REFERER') ? : site_url('/setup/metric_wholesale'));
    }

    public function deleteRetailMetric($id) {
        $this->user_auth_lib->check_login();
        if ($this->basic_model->delete(Setup_model::TBL_M_RETAIL, ['metric_retail_id' => $id])) {
            notify('success', 'Metric deleted successfully');
        } else {
            notify('error', 'Unable to delete metric at moment, pls try again');
        }
        redirect($this->input->server('HTTP_REFERER') ? : site_url('/setup/metric_wholesale'));
    }

    public function deleteMarketProduct($id) {
        $this->user_auth_lib->check_login();
        if ($this->basic_model->delete('market_products', ['market_product_id' => $id])) {
            notify('success', 'Product deleted from market successfully');
        } else {
            notify('error', 'Unable to delete product at moment, pls try again');
        }
        redirect($this->input->server('HTTP_REFERER') ? : site_url('/setup/markets'));
    }

    public function deleteMetricWsSubCategory($id) {
        $this->user_auth_lib->check_login();
        if ($this->basic_model->delete('metric_wholesale_category', ['metric_wholesale_category_id' => $id])) {
            notify('success', 'Operation was successful');
        } else {
            notify('error', 'Unable to delete item at moment, pls try again');
        }
        redirect($this->input->server('HTTP_REFERER') ? : site_url('/setup/wholesale_metric'));
    }

    public function deleteMetricRtSubCategory($id) {
        $this->user_auth_lib->check_login();
        if ($this->basic_model->delete('metric_retail_category', ['metric_retail_category_id' => $id])) {
            notify('success', 'Operation was successful');
        } else {
            notify('error', 'Unable to delete item at moment, pls try again');
        }
        redirect($this->input->server('HTTP_REFERER') ? : site_url('/setup/retail_metric'));
    }

    public function metric_wholesale_category() {
        $this->user_auth_lib->check_login();
        if (request_is_post()) {
            if ($this->setup_model->metric_wholesale_category('metric_wholesale_category', request_post_data())) {
                notify('success', "Operation was successful");
            } else {
                notify('error', "Ops! Unable to complete your request at moment, pls try again.");
            }
            redirect(site_url('setup/wholesale_metric'));
        }
    }

    public function metric_retail_category() {
        $this->user_auth_lib->check_login();
        if (request_is_post()) {
            if ($this->setup_model->metric_wholesale_category('metric_retail_category', request_post_data())) {
                notify('success', "Operation was successful");
            } else {
                notify('error', "Ops! Unable to complete your request at moment, pls try again.");
            }
            redirect(site_url('setup/retail_metric'));
        }
    }

    public function markets() {
        $this->user_auth_lib->check_login();
        $this->user_auth_lib->check_perm('setup:markets');

        if (request_is_post()) {
            if ($this->setup_model->saveMarket(request_post_data())) {
                notify('success', 'Market(s) saved successfully');
            } else {
                notify('error', 'Unable to save market at moment, pls try again');
            }
            redirect(site_url('setup/markets'));
        }

        $data = array(
            'states' => $this->basic_model->fetch_all_records('states'),
            'markets' => $this->setup_model->fetchMarkets()
        );

        $this->user_nav_lib->run_page('setup/market/markets', $data, 'Markets | ' . BUSINESS_NAME);
    }

    public function products() {
        $this->user_auth_lib->check_login();
        $this->user_auth_lib->check_perm('setup:products');

        $data = array(
            'varieties' => $this->basic_model->fetch_all_records(Setup_model::TBL_VARIETIES, ['status' => ACTIVE]),
            'sources' => $this->basic_model->fetch_all_records(Setup_model::TBL_SOURCES, ['status' => ACTIVE]),
            'sub_categories' => $this->basic_model->fetch_all_records(Setup_model::TBL_SUB_CATEGORIES),
            'products' => $this->setup_model->fetchProducts(),
            'wholesale_metrics' => $this->basic_model->fetch_all_records(Setup_model::TBL_M_WHOLESALES),
            'retail_metrics' => $this->basic_model->fetch_all_records(Setup_model::TBL_M_RETAIL),
        );

        $this->user_nav_lib->run_page('setup/product/products', $data, 'Products | ' . BUSINESS_NAME);
    }

    public function add_product() {
        $this->user_auth_lib->check_login();

        if (request_is_post()) {

            if ($this->setup_model->saveProduct(request_post_data(), $_FILES['userfile'])) {
                notify('success', 'Product added successfully');
            } else {
                notify('error', 'Unable to add products at moment, pls try again');
            }
            redirect(site_url('setup/products'));
        }

        $data = array(
            'sub_categories' => $this->basic_model->fetch_all_records(Setup_model::TBL_SUB_CATEGORIES),
            'categories' => $this->basic_model->fetch_all_records(Setup_model::TBL_CATEGORIES, ['status' => 1]),
            'seasons' => $this->product_lib->getSeasons()
        );

        $this->user_nav_lib->run_page('setup/product/add_product', $data, 'New Product | ' . BUSINESS_NAME);
    }

    public function add_product_variety() {
        if (request_is_post()) {
            if ($this->setup_model->add_product_variety(request_post_data())) {
                notify('sucess', 'Operation was successful');
            } else {
                notify('error', 'Ops! unable to add product varieties, pls try again');
            }
            redirect(site_url('/setup/products'));
        }
    }

    public function add_product_source() {
        if (request_is_post()) {
            if ($this->setup_model->add_product_source(request_post_data())) {
                notify('sucess', 'Operation was successful');
            } else {
                notify('error', 'Ops! unable to add product sources, pls try again');
            }
            redirect($this->input->server('HTTP_REFERER') ? : site_url('/setup/products'));
        }
    }

    public function add_product_metrics() {
        if (request_is_post()) {
            if ($this->setup_model->add_product_metrics(request_post_data())) {
                notify('sucess', 'Metric(s) was successfully assigned to product');
            } else {
                notify('error', 'Ops! unable to add product metrics, pls try again');
            }
            redirect($this->input->server('HTTP_REFERER') ? : site_url('/setup/products'));
        }
    }

    public function view_product($product_id, $product_name = null, $market_id = null) {
        $this->user_auth_lib->check_login();
        $this->user_auth_lib->check_perm('setup:view_product');

        $data = array(
            'product' => $this->setup_model->fetchProducts($product_id)[0],
            'prices' => $this->market_model->fetchProductPrices($product_id, $market_id, null, '', '', TRUE),
            'products' => $this->basic_model->fetch_all_records(Setup_model::TBL_PRODUCTS),
            'markets' => $this->basic_model->fetch_all_records(Setup_model::TBL_MARKETS, ['status' => ACTIVE]),
            'metric_types' => $this->setup_model->getMetric_types(),
            'have_price' => $this->market_model->haveRecentPrice($product_id)
        );

        $this->user_nav_lib->run_page('setup/product/view_product', $data, 'View Product | ' . BUSINESS_NAME);
    }

    public function changeProductStatus($product_id, $status) {
        $this->user_auth_lib->check_login();
        $this->user_auth_lib->check_perm('setup:edit_product');

        if ($this->basic_model->update(Setup_model::TBL_PRODUCTS, ['status' => $status > 0 ? 0 : 1], ['product_id' => $product_id])) {
            notify('success', 'Product status changed successfully');
        } else {
            notify('error', 'Unable to change status, pls try again');
        }
        redirect(site_url('/setup/products'));
    }

    public function changeSourceStatus($id, $status) {
        $this->user_auth_lib->check_login();
        $this->user_auth_lib->check_perm('setup:edit_source');

        if ($this->basic_model->update(Setup_model::TBL_SOURCES, ['status' => $status > 0 ? 0 : 1], ['source_id' => $id])) {
            notify('success', 'Source status changed successfully');
        } else {
            notify('error', 'Unable to change status, pls try again');
        }
        redirect($this->input->server('HTTP_REFERER') ? : site_url('/setup/sources'));
    }

    public function changeVarietyStatus($variety_id, $status) {
        $this->user_auth_lib->check_login();
        $this->user_auth_lib->check_perm('setup:edit_variety');

        if ($this->basic_model->update(Setup_model::TBL_VARIETIES, ['status' => $status > 0 ? 0 : 1], ['variety_id' => $variety_id])) {
            notify('success', 'Variety status changed successfully');
        } else {
            notify('error', 'Unable to change status, pls try again');
        }
        redirect($this->input->server('HTTP_REFERER') ? : site_url('/setup/varieties'));
    }

    public function removeProductSouce($id) {
        $this->user_auth_lib->check_login();
        if ($this->basic_model->delete(Setup_model::TBL_PRO_SOURCES, ['product_source_id' => $id])) {
            notify('success', 'Product source removed successfully');
        } else {
            notify('error', 'Unable to remove product source');
        }

        redirect($this->input->server('HTTP_REFERER') ? : site_url('/setup/products'));
    }

    public function removeProductImage($id) {
        $this->user_auth_lib->check_login();
        if ($this->basic_model->delete('product_images', ['product_id' => $id])) {
            notify('success', 'Product image removed successfully');
        } else {
            notify('error', 'Unable to remove product image at moment, pls try again');
        }

        redirect($this->input->server('HTTP_REFERER') ? : site_url('/setup/products'));
    }

    public function removeProductVariety($id) {
        $this->user_auth_lib->check_login();
        if ($this->basic_model->delete(Setup_model::TBL_PRO_VARIETIES, ['product_variety_id' => $id])) {
            notify('success', 'Product variety removed successfully');
        } else {
            notify('error', 'Unable to remove product variety');
        }

        redirect($this->input->server('HTTP_REFERER') ? : site_url('/setup/products'));
    }

    public function edit_category($id) {
        $this->user_auth_lib->check_login();
        $this->user_auth_lib->check_perm('setup:edit_category');

        if (request_is_post()) {
            if ($this->basic_model->update(Setup_model::TBL_CATEGORIES, array_merge(request_post_data(), ['date_updated' => date('Y-m-d h:i:s')]), ['category_id' => $id])) {
                notify('success', 'Category updated successfully');
            } else {
                notify('error', 'Unable to update category at moment, pls try again');
            }
            redirect(site_url('/setup/categories'));
        }
        $data = array(
            'category_info' => $this->basic_model->fetch_all_records(Setup_model::TBL_CATEGORIES, ['category_id' => $id])[0],
            'groups' => $this->basic_model->fetch_all_records('groups'),
        );

        $this->load->view('setup/category/_edit', $data);
    }

    public function edit_source($id) {
        $this->user_auth_lib->check_login();
        $this->user_auth_lib->check_perm('setup:edit_source');

        if (request_is_post()) {
            if ($this->basic_model->update(Setup_model::TBL_SOURCES, array_merge(request_post_data(), ['date_updated' => date('Y-m-d h:i:s')]), ['source_id' => $id])) {
                notify('success', 'Source updated successfully');
            } else {
                notify('error', 'Unable to update source at moment, pls try again');
            }
            redirect(site_url('/setup/sources'));
        }
        $data = array(
            'source_info' => $this->basic_model->fetch_all_records(Setup_model::TBL_SOURCES, ['source_id' => $id])[0],
        );

        $this->load->view('setup/source/_edit', $data);
    }

    public function edit_variety($id) {
        $this->user_auth_lib->check_login();
        $this->user_auth_lib->check_perm('setup:edit_variety');

        if (request_is_post()) {
            if ($this->basic_model->update(Setup_model::TBL_VARIETIES, array_merge(request_post_data(), ['date_updated' => date('Y-m-d h:i:s')]), ['variety_id' => $id])) {
                notify('success', 'Variety updated successfully');
            } else {
                notify('error', 'Unable to update variety at moment, pls try again');
            }
            redirect(site_url('/setup/varieties'));
        }
        $data = array(
            'variety_info' => $this->basic_model->fetch_all_records(Setup_model::TBL_VARIETIES, ['variety_id' => $id])[0],
        );

        $this->load->view('setup/variety/_edit', $data);
    }

    public function edit_metric($id, $type) {
        $this->user_auth_lib->check_login();
        $this->user_auth_lib->check_perm('setup:edit_metric');


        $table_name = $type == 1 ? Setup_model::TBL_M_WHOLESALES : Setup_model::TBL_M_RETAIL;
        $col_name = $type == 1 ? 'metric_wholesale_id' : 'metric_retail_id';

        if (request_is_post()) {
            if ($this->basic_model->update($table_name, array_merge(request_post_data(), ['date_updated' => date('Y-m-d h:i:s')]), [$col_name => $id])) {
                notify('success', 'Metric updated successfully');
            } else {
                notify('error', 'Unable to update metric at moment, pls try again');
            }
            $col_name = $type == 1 ? redirect(site_url('/setup/wholesale_metric')) : redirect(site_url('/setup/retail_metric'));
        }


        $data = array(
            'metric_info' => $this->basic_model->fetch_all_records($table_name, [$col_name => $id])[0],
            'type' => $type
        );

        $this->load->view('setup/metrics/_edit', $data);
    }

    public function edit_product_image($id, $product_name) {
        $this->user_auth_lib->check_login();
        $this->user_auth_lib->check_perm('setup:edit_product');

        if (request_is_post()) {
            if ($this->setup_model->update_product_image($id, $_FILES['userfile'])) {
                notify('success', 'Product image updated successfully');
            } else {
                notify('error', 'Unable to update product image at moment, pls try again');
            }
            redirect(site_url('/setup/view_product/' . $id . '/' . $product_name));
        }

        $data = [
            'product_image' => $this->basic_model->fetch_all_records('product_images', ['product_id' => $id])[0],
            'product_name' => $product_name
        ];
        $this->user_nav_lib->run_page('setup/product/edit_product_image', $data);
    }

    public function editSubCategory($id) {
        $this->user_auth_lib->check_login();
        $this->user_auth_lib->check_perm('setup:edit_category');

        if (request_is_post()) {
            if ($this->basic_model->update(Setup_model::TBL_SUB_CATEGORIES, array_merge(request_post_data(), ['date_updated' => date('Y-m-d h:i:s')]), ['sub_category_id' => $id])) {
                notify('success', 'Sub category updated succssfully');
            } else {
                notify('error', 'Ops! Something went wrong while updating sub category, pls try again');
            }

            redirect(site_url('/setup/categories'));
        }

        $data = [
            'categories' => $this->basic_model->fetch_all_records(Setup_model::TBL_CATEGORIES, ['status' => 1]),
            'info' => $this->basic_model->fetch_all_records(Setup_model::TBL_SUB_CATEGORIES, ['sub_category_id' => $id])[0],
        ];

        $this->user_nav_lib->run_page('setup/category/edit_sub_category', $data);
    }

    public function edit_product($product_id, $product_name) {
        $this->user_auth_lib->check_login();

        if (request_is_post()) {
            if ($this->basic_model->update(Setup_model::TBL_PRODUCTS, array_merge(request_post_data(), ['date_updated' => date('Y-m-d h:i:s')]), ['product_id' => $product_id])) {
                notify('success', 'Product updated succssfully');
            } else {
                notify('error', 'Ops! Something went wrong while updating product, pls try again');
            }

            redirect(site_url('/setup/products'));
        }

        $data = [
            'categories' => $this->basic_model->fetch_all_records(Setup_model::TBL_CATEGORIES, ['status' => 1]),
            'sub_categories' => $this->basic_model->fetch_all_records(Setup_model::TBL_SUB_CATEGORIES),
            'product_detail' => $this->setup_model->getProductDetails($product_id)[0],
            'product_name' => $product_name,
            'seasons' => $this->product_lib->getSeasons()
        ];

        $this->user_nav_lib->run_page('setup/product/edit_product', $data);
    }

    public function json_get_products() {
        $products = $this->setup_model->fetchProducts();

        if (empty($products)) {
            $package = [];
            $b = array('aaData' => $package);

            echo json_encode($b);

            return;
        }

        $this->output->set_content_type('application/json');
        $this->output->_display(json_encode(array('aaData' => $products)));
    }

    public function removeProductMetrics($type, $id) {
        $this->user_auth_lib->check_login();

        if ($type === 'retail') {
            $this->basic_model->delete('product_retail_metrics', ['product_retail_metric_id' => $id]);
        } else {
            $this->basic_model->delete('product_wholesale_metrics', ['product_wholesale_metric_id' => $id]);
        }
        redirect($this->input->server('HTTP_REFERER') ? : site_url('/setup/products'));
    }

    public function remarks() {
        $this->user_auth_lib->check_login();
        $this->user_auth_lib->check_perm('setup:remarks');

        if (request_is_post()) {
            if ($this->setup_model->addRemark(request_post_data())) {
                notify('success', 'Remark added successfully');
            } else {
                notify('error', 'Unable to add remark, pls try again');
            }
            redirect(site_url('/setup/remarks'));
        }

        $data = [
            'remarks' => $this->basic_model->fetch_all_records('remarks')
        ];

        $this->user_nav_lib->run_page('setup/remarks/list', $data, 'Remarks | ' . BUSINESS_NAME);
    }

    public function delete_remark($id) {
        $this->user_auth_lib->check_login();
        $this->user_auth_lib->check_perm('setup:delete_remark');

        if ($this->basic_model->delete('remarks', ['remark_id' => $id])) {
            notify('success', 'Remark deleted successfully');
        } else {
            notify('error', 'Unable to delete remark');
        }

        redirect($this->input->server('HTTP_REFERER') ? : site_url('/setup/products'));
    }

    public function traders() {
        $this->user_auth_lib->check_login();
        $this->user_auth_lib->check_perm('admin:traders');

        $data = array(
            'traders' => $this->u_model->fetchTraders(),
            'supply_chains' => $this->basic_model->getSupplyChains()
        );

        $this->user_nav_lib->run_page('traders/list', $data, 'Traders Directory | ' . BUSINESS_NAME);
    }

    public function edit_trader($id) {
        $this->user_auth_lib->check_login();
        $this->user_auth_lib->check_perm('admin:traders');

        if (request_is_post()) {
            if ($this->u_model->updateTrader($id, request_post_data())) {
                notify('success', 'Operation was successful');
            } else {
                notify('error', 'Ops! Something went wrong while updating traders information. Pls try again');
            }
            redirect(site_url('/setup/traders'));
        }

        $data = array(
            'trader' => $this->u_model->fetchTraders($id)[0],
            'supply_chains' => $this->basic_model->getSupplyChains(),
            'markets' => $this->basic_model->fetch_all_records('markets'),
            'form_action' => site_url('/setup/edit_trader/' . $id)
        );

        $this->user_nav_lib->run_page('traders/add_trader', $data, 'Traders Directiry | ' . BUSINESS_NAME);
    }

    public function deleteTrader($id) {
        $this->user_auth_lib->check_login();
        if (!isset($id) || $id < 0) {
            notify('error', "An Invalid parameter passed. Pls try again");
            redirect($this->input->server('HTTP_REFERER'));
        }

        if ($this->basic_model->delete('traders', ['trader_id' => $id])) {
            notify('success', "Operation was successful");
        } else {
            notify('error', "An error occured while deleting the selected trader. Pls try again");
        }
        redirect($this->input->server('HTTP_REFERER'));
    }

    public function add_trader() {
        $this->user_auth_lib->check_login();

        if (request_is_post()) {
            if ($this->u_model->traderPhoneExist(request_post_data()['phone'])) {
                notify('error', "Ops! Trader's phone number already exist");
                redirect(site_url('/admin/add_trader'));
            }
            if ($this->u_model->saveTrader(request_post_data())) {
                notify('success', "Operation completed successfully");
            } else {
                notify('error', "Unable to complete your request at moment, pls try again");
            }
            redirect(site_url('/setup/traders'));
        }

        $data = array(
            'markets' => $this->basic_model->fetch_all_records('markets'),
            'supply_chains' => $this->basic_model->getSupplyChains(),
            'form_action' => ''
        );

        $this->user_nav_lib->run_page('traders/add_trader', $data, 'Add New Trader | ' . BUSINESS_NAME);
    }

}
