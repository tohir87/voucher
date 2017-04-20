<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Subscription_model
 *
 * @author tohir
 * @property User_auth_lib $user_auth_lib Description
 * @property CI_DB_query_builder $db Description
 */
class Subscription_model extends CI_Model {

    const TBL_SUBSCRIPTION = 'subscriptions';
    const TBL_SUBSCRIBERS = 'subscribers';
    const TBL_SUBSCRIBER_PRODUCTS = 'subscriber_products';
    const TBL_SUBSCRIBER_MARKETS = 'subscriber_markets';
    const TBL_PRODUCT_PRICE = 'product_price';

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function getSubscriptions($id = null) {
        if (is_null($id)) {
            return $this->db->get(self::TBL_SUBSCRIPTION)->result();
        } else {
            return $this->db->get_where(self::TBL_SUBSCRIPTION, ['subscription_id' => $id])->row();
        }
    }

    /**
     * Get user subscription by email
     * @param type $email
     * @return boolean
     */
    public function getUserSubscriptionByEmail($email) {
        $sub_info = $this->db->get_where(self::TBL_SUBSCRIBERS, ['email' => $email])->row();

        if (empty($sub_info)) {
            return FALSE;
        }
        return $this->getSubscriptions($sub_info->subscription_id);
    }

    public function addSubscriber($data) {
        if (empty($data)) {
            notify('error', 'Invalid parameter passed');
            return FALSE;
        }

        if ($this->db->get_where(self::TBL_SUBSCRIBERS, ['email' => $data['register_email']])->row()) {
            notify('error', 'The email you supplied already exists in our records');
            return FALSE;
        }

        $data_db = array(
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'phone' => $data['phone'],
            'email' => $data['register_email'],
//            'subscription_id' => $data['subscription_id'],
            'created_at' => date('Y-m-d h:i:s')
        );

//        $subscriptionInfo = $this->getSubscriptions($data['subscription_id']);

        $this->db->insert(self::TBL_SUBSCRIBERS, $data_db);

        $this->_sendConfirmationEmail(array('first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
//            'plan' => $subscriptionInfo->plan, 
//            'amount' => $subscriptionInfo->amount, 
            'email' => $data['register_email'],
            's_id' => $this->db->insert_id()));

        return TRUE;
    }

    private function _sendConfirmationEmail($params) {
        $mail_data = array(
            'header' => 'Welcome to CTM Dashboard',
            'first_name' => ucfirst($params['first_name']),
            'last_name' => ucfirst($params['last_name']),
//            'plan' => $params['plan'],
//            'amount' => number_format($params['amount'], 2),
            'activation_link' => site_url('/activate/' . $params['s_id'] . '/' . $params['first_name']),
        );

        $msg = $this->load->view('email_templates/register', $mail_data, true);

        return $this->mailer
                        ->sendMessage('Access Granted | CTM Dashboard', $msg, $params['email']);
    }

    public function getSubscriberById($id) {
        return $this->db->get_where(self::TBL_SUBSCRIBERS, ['subscriber_id' => $id])->row();
    }

    public function activateAccount($data) {
        if (empty($data)) {
            return FALSE;
        }

        // Update subscriber will be done after payment confirmation
        $subscriber = $this->getSubscriberById($data['subscriber_id']);
        return $this->db->insert(TBL_USERS, [
                    'email' => $subscriber->email,
                    'first_name' => $subscriber->first_name,
                    'last_name' => $subscriber->last_name,
                    'password' => $this->user_auth_lib->encrypt($data['password']),
                    'date_created' => date('Y-m-d h:i:s'),
                    'status' => USER_STATUS_ACTIVE,
                    'user_type_id' => USER_TYPE_SUBSCRIBER
        ]);
    }

    public function fetchSubscribers() {
        return $this->db->select('s.*, p.*')
                        ->from(self::TBL_SUBSCRIBERS . ' as s')
                        ->join(self::TBL_SUBSCRIPTION . ' as p', 'p.subscription_id = s.subscription_id')
                        ->get()->result();
    }

    public function changeStatus($id, $status) {
        if (!is_numeric($id) || (int) $id < 0) {
            return FALSE;
        }
        $this->db->where('subscriber_id', $id)
                ->update(self::TBL_SUBSCRIBERS, ['status' => (int) !$status]);
        return $this->db->affected_rows() > 0;
    }

    public function isActive($id) {
        return $this->db->select('*')
                        ->from(TBL_USERS . ' as u')
                        ->join(self::TBL_SUBSCRIBERS . ' as s', 'u.email=s.email')
                        ->where('u.user_id', $id)
                        ->where('s.status', ACTIVE)
                        ->get()->row();
    }

    public function fetchSubscriberProducts($user_id) {
        return $this->db
                        ->select('s.*, p.product_name, pi.image_name, pi.image_url')
                        ->from(self::TBL_SUBSCRIBER_PRODUCTS . ' as s')
                        ->join(Setup_model::TBL_PRODUCTS . ' as p', 'p.product_id=s.product_id')
                        ->join('product_images pi', 'p.product_id=pi.product_id', 'left')
                        ->where('s.user_id', $user_id)
                        ->get()->result();
    }

    public function fetchSubscriberMarkets($user_id) {
        return $this->db
                        ->select('sm.*, m.market_name')
                        ->from(self::TBL_SUBSCRIBER_MARKETS . ' as sm')
                        ->join(Setup_model::TBL_MARKETS . ' as m', 'm.market_id=sm.market_id')
                        ->where('sm.user_id', $user_id)
                        ->get()->result();
    }

    public function add_subscriber_products($data) {
        if (empty($data['product_id'])) {
            return FALSE;
        }

        $data_db = [];
        foreach ($data['product_id'] as $product_id) {
            $data_db[] = [
                'product_id' => $product_id,
                'user_id' => $this->user_auth_lib->get('user_id'),
                'date_added' => date('Y-m-d h:i:s'),
                'status' => 1,
                'added_by' => $this->user_auth_lib->get('user_id'),
            ];
        }

        return $this->db->insert_batch(self::TBL_SUBSCRIBER_PRODUCTS, $data_db);
    }

    public function add_subscriber_market($data) {
        if (empty($data['market_id'])) {
            return FALSE;
        }

        return $this->db->insert(self::TBL_SUBSCRIBER_MARKETS, [
                    'market_id' => $data['market_id'],
                    'user_id' => $this->user_auth_lib->get('user_id'),
                    'date_added' => date('Y-m-d h:i:s'),
                    'status' => 1,
                    'added_by' => $this->user_auth_lib->get('user_id'),
        ]);
    }
    
    public function getProductPrice() {
        return $this->db->get(self::TBL_PRODUCT_PRICE)->row();
    }

}
