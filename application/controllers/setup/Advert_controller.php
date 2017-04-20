<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * Description of Advert_controller
 *
 * @author tohir
 * @property User_auth_lib $user_auth_lib Description
 * @property User_nav_lib $user_nav_lib Description
 * @property Advert_model $ads_model Description
 * @property CI_Loader $load Description
 * @property Basic_model $basic_model Description
 */
class Advert_controller extends CI_Controller {

    public function __construct() {
        parent::__construct();

        $this->load->model('setup/Advert_model', 'ads_model');
        $this->load->model('basic_model');
        $this->load->library(['User_nav_lib', 'Product_lib']);
    }

    public function index() {
        $this->user_auth_lib->check_login();
        $this->user_auth_lib->check_perm('setup:adverts');

        if (request_is_post()) {
            if ($this->ads_model->save_ads(request_post_data(), $_FILES['userfile'])) {
                notify('success', "Advert added successfully");
            }
            redirect(site_url('/advert'));
        }

        $pageData = [
            'adverts' => $this->ads_model->fetch_all_adverts(),
            'locations' => utils\Enums::getAdsLocation()
        ];
        $this->user_nav_lib->run_page('setup/adverts/list', $pageData, 'Manage Adverts | ' . BUSINESS_NAME);
    }

    public function delete_ads($id) {
        $this->user_auth_lib->check_login();
        $this->user_auth_lib->check_perm('setup:adverts');

        if ($this->basic_model->delete(Advert_model::TBL_ADVERTS, ['advert_id' => $id])) {
            notify('success', 'Advert deleted successfully');
        } else {
            notify('error', 'Unable to delete selected advert. Please try again.');
        }
        redirect(site_url('/advert'));
    }

    public function edit_ads($id) {
        if (empty($id) || !is_numeric($id)) {
            notify('error', 'Invalid parameter supplied.', '/advert');
            return FALSE;
        }

        if (request_is_post()) {
            if ($this->ads_model->update_ads($id, request_post_data(), $_FILES['userfile'])) {
                notify('success', 'Ad updated successfully');
            } else {
                notify('error', 'Ops! Unable to update ads at moment, Please try again later');
            }
            redirect(site_url('/adverts'));
        }

        $pageData = [
            'ad_info' => $this->basic_model->fetch_all_records(Advert_model::TBL_ADVERTS, ['advert_id' => $id])[0],
            'locations' => utils\Enums::getAdsLocation()
        ];
        $this->user_nav_lib->run_page('setup/adverts/edit', $pageData, 'Edit Advert | ' . BUSINESS_NAME);
    }

}
