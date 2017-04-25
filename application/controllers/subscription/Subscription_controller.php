<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * Description of Subscription_controller
 *
 * @author tohir 
 * @property User_auth_lib $user_auth_lib Description
 * @property User_nav_lib $user_nav_lib Description
 * @property CI_Loader $load Description
 * @property Subscription_model $sub_model Description
 * @property Mixpanel_lib $mixpanel_lib Description
 * @property Basic_model $basic_model Description
 */
class Subscription_controller extends CI_Controller {

    public function __construct() {
        parent::__construct();

        $this->load->model('user/User_model', 'u_model');
        $this->load->model('setup/Setup_model', 'setup_model');
        $this->load->model('setup/Market_model', 'market_model');
        $this->load->model('setup/Subscription_model', 'sub_model');
        $this->load->model('setup/Advert_model', 'ads_model');
        $this->load->model('basic_model');
        $this->load->library(['User_nav_lib', 'Product_lib', 'Mailer']);
    }

    public function index() {
        $hdata = ['page_title' => 'Login or create account'];
        $register_message = NULL;
        $login_message = NULL;

        if (request_is_post()) {
            if (isset(request_post_data()['register_button'])) {
                if ($this->sub_model->addSubscriber(request_post_data())) {
                    $post_data = request_post_data();
                    notify('success', "Your account has been created successfully, Pls check your email to activate your account");
                }
                redirect(site_url('/register'));
            }
        }

        $success_message = '';
        $error_message = isset($_GET['email_message']) ? $_GET['email_message'] : '';
        $bdata = array(
            'forgot_password_url' => site_url('subscriber/forgot_password'),
            'login_title' => 'Login or create account',
            'error_message' => $error_message,
            'success_message' => $success_message,
            'plans' => $this->sub_model->getSubscriptions(),
            'bgColor' => 'http://comparethemarket.com.ng/demo/images/body-bg.png'
        );
        $this->load->view('company_templates/header', $hdata);
        $this->load->view('subscriptions/login', $bdata);
        $this->load->view('company_templates/footer');
    }

    public function activate($s_id, $fname = '') {
        if ((int) $s_id < 0) {
            trigger_error("Invalid subscriber id", E_USER_ERROR);
            exit;
        }

        if (request_is_post()) {
            // validation check
            if (request_post_data()['password'] !== request_post_data()['password2']) {
                notify('error', "Passwords do not match, Pls try again");
                redirect(site_url('/activate/' . $s_id . '/' . $fname));
            } elseif (strlen(request_post_data()['password']) < MIN_PWD_LEN) {
                notify('error', "password must be atleast minimum of " . MIN_PWD_LEN . " characters");
                redirect(site_url('/activate/' . $s_id . '/' . $fname));
            }

            if ($this->sub_model->activateAccount(request_post_data())) {
                notify('success', "Account successfully activated, you should receive an email shortly");
            } else {
                notify('error', "Ops! Something went wrong while activating your account. pls try again");
            }
            redirect(site_url('/register'));
        }

        $subscriber = $this->sub_model->getSubscriberById($s_id);
        if (empty($subscriber)) {
            show_error("Subscriber not found");
            exit;
        }

        $hdata = ['page_title' => 'Reset you account Password'];

        $bdata = array(
            'subscriber' => $this->sub_model->getSubscriberById($s_id),
            'bgColor' => 'http://comparethemarket.com.ng/demo/images/body-bg.png'
        );

        $this->load->view('company_templates/header', $hdata);
        $this->load->view('subscriptions/reset_password', $bdata);
        $this->load->view('company_templates/footer');
    }

    public function login() {
        if (request_is_post()) {

            $response = $this->user_auth_lib->login(request_post_data());

            if (!$response) {
                $email_message = "Invalid email/password";
                redirect(site_url('/register?$email_message=Invalid email/password'));
            } else {

                redirect('subscriber/dashboard');
            }
        }
    }

    public function dashboard() {
        $this->user_auth_lib->check_sub_login();

        $data = array(
            'markets' => $this->basic_model->fetch_all_records(Setup_model::TBL_MARKETS),
            'ad' => $this->ads_model->fetch_ad()
        );

        $this->user_nav_lib->run_page('dashboard/landing', $data, BUSINESS_NAME);
    }

    public function logout() {
        $this->user_auth_lib->logout();
        redirect(site_url('/register'));
    }

    public function subscribers() {
        $this->user_auth_lib->check_login();
        $data = [
            'subscribers' => $this->sub_model->fetchSubscribers()
        ];
        $this->user_nav_lib->run_page('subscriptions/subscribers', $data, BUSINESS_NAME);
    }

    public function changeStatus() {
        $this->user_auth_lib->check_login();
        if ($this->sub_model->changeStatus($_GET['id'], $_GET['status'])) {
            notify('success', "Subscriber status changed successfully");
        } else {
            notify('error', "unable to update subscriber status, Pls try again");
        }

        redirect($this->input->server('HTTP_REFERER') ? : site_url('/subscription/subscribers'));
    }

    public function deleteSubscriber($id) {
        $this->user_auth_lib->check_login();
        if ($this->basic_model->delete(Subscription_model::TBL_SUBSCRIBERS, ['subscriber_id' => $id])) {
            notify('success', "Subscriber deleted successfully");
        } else {
            notify('error', "Unable to delete subscriber, pls try again");
        }
        redirect($this->input->server('HTTP_REFERER') ? : site_url('/subscription/subscribers'));
    }

    public function my_account() {
        $this->user_auth_lib->check_sub_login();
        $data = [
            'my_products' => $this->sub_model->fetchSubscriberProducts($this->user_auth_lib->get('user_id')),
            'my_markets' => $this->sub_model->fetchSubscriberMarkets($this->user_auth_lib->get('user_id')),
            'products' => $this->basic_model->fetch_all_records(Setup_model::TBL_PRODUCTS),
            'markets' => $this->basic_model->fetch_all_records(Setup_model::TBL_MARKETS),
            'subscription' => $this->sub_model->getUserSubscriptionByEmail($this->user_auth_lib->get('email'))
        ];

        $this->user_nav_lib->run_page('subscriptions/my_account', $data, 'My Account | ' . BUSINESS_NAME);
    }

    public function removeProduct($id) {
        $this->user_auth_lib->check_sub_login();
        if ($this->basic_model->delete(Subscription_model::TBL_SUBSCRIBER_PRODUCTS, ['subscriber_product_id' => $id])) {
            notify('success', "Product has been successfully removed");
        } else {
            notify('error', "Unable to remove selected product at moment, pls try again.");
        }
        redirect($this->input->server('HTTP_REFERER') ? : site_url('/subscriber/account'));
    }

    public function removeMarket($id) {
        $this->user_auth_lib->check_sub_login();
        if ($this->basic_model->delete(Subscription_model::TBL_SUBSCRIBER_MARKETS, ['subscriber_market_id' => $id])) {
            notify('success', "Market has been successfully removed");
        } else {
            notify('error', "Unable to remove selected market at moment, pls try again.");
        }
        redirect($this->input->server('HTTP_REFERER') ? : site_url('/subscriber/account'));
    }

    public function add_product() {
        $this->user_auth_lib->check_sub_login();

        if (request_is_post()) {
            if ($this->sub_model->add_subscriber_products(request_post_data())) {
                notify('success', 'Product(s) was added successfully');
            } else {
                notify('error', 'Unable to add products to your account, pls contact the adminstrator');
            }
            redirect($this->input->server('HTTP_REFERER') ? : site_url('/subscriber/account'));
        }
    }

    public function add_market() {
        $this->user_auth_lib->check_sub_login();

        if (request_is_post()) {
            if ($this->sub_model->add_subscriber_market(request_post_data())) {
                notify('success', 'Market was added successfully');
            } else {
                notify('error', 'Unable to add products to your account, pls contact the adminstrator');
            }
            redirect($this->input->server('HTTP_REFERER') ? : site_url('/subscriber/account'));
        }
    }

    public function config() {
        $pageData = [
            'product_price' => $this->sub_model->getProductPrice()
        ];
        $this->user_nav_lib->run_page('subscriptions/config', $pageData, 'Configurations | ' . BUSINESS_NAME);
    }

    public function edit_product_price($id) {
        if (request_is_post()) {
            if ($this->basic_model->update(Subscription_model::TBL_PRODUCT_PRICE, ['product_price' => request_post_data()['product_price'], 'updated_by' => $this->user_auth_lib->get('user_id'), 'date_updated' => date('Y-m-d H:i:s')], ['product_price_id' => $id])) {
                notify('success', 'Product price updated successfully');
            } else {
                notify('error', 'Error! Unable to update product price at moment, Please try again later');
            }
            redirect(site_url('/subscription/config'));
        }
    }

}
