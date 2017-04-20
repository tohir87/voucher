<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * Description of basic_model
 *
 * @author TOHIR
 */
class Basic_model extends CI_Model {

    private $supply_chain = [];

    public function __construct() {
        parent::__construct();
        $this->load->database();

        $this->supply_chain = [1 => 'Retailer', 2 => 'Wholesaler', 3 => 'Wholesaler/Retailer', '' => ''];
    }

    public function batches() {
        return $this->db->select('b.*, p.provider_name')
                        ->from('batches b')
                        ->join('providers p', 'p.provider_id=b.provider_id')
                        ->get()->result();
    }

    public function fetch_all_records($table, $where = NULL, $rowClass = stdClass::class) {

        if (!$this->db->table_exists($table)) {
            trigger_error("Table `" . $table . "` not exists.", E_USER_ERROR);
        }

        if (is_null($where)) {
            $result = $this->db->get($table)->result($rowClass);
        } else {
            $result = $this->db->get_where($table, $where)->result($rowClass);
        }

        if (empty($result)) {
            return false;
        }

        return $result;
    }

    public function saveReg($data) {
        if ($this->_recordExist($data['email'])) {
            return FALSE;
        }

        $data['dateof_birth'] = date('Y-m-d', strtotime($data['dateof_birth']));
        $data['date_added'] = date('Y-m-d h:i:s');

        $this->db->trans_start();
        $user_id = $this->_createStudentUser($data);

        $this->db->insert('student_event_reg', $data);
        $this->_sendConfirmationEmail($user_id, array('first_name' => $data['first_name'], 'username' => $data['email']));
        $this->db->trans_complete();

        return TRUE;
    }

    private function _createStudentUser($data) {
        $user_data = array(
            'username' => $data['email'],
            'password' => $this->user_auth_lib->encrypt(DEFAULT_PASSWORD),
            'status' => USER_STATUS_INACTIVE,
            'created_at' => date('Y-m-d h:i:s'),
            'user_type' => USER_TYPE_STUDENT,
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'phone' => $data['phone'],
        );

        $this->db->insert(TBL_USERS, $user_data);
        return $this->db->insert_id();
    }

    private function _sendEnquiryEmail($params) {
        $mail_data = array(
            'header' => 'Enquiry',
            'first_name' => $params['first_name'],
            'last_name' => $params['last_name'],
            'email' => $params['email'],
            'phone' => $params['phone'],
            'message' => $params['message'],
        );

        $msg = $this->load->view('email_templates/enquiry', $mail_data, true);

        return $this->mailer
                        ->sendMessage("Enquiry from " . $params['first_name'], $msg, INFO_EMAIL);
    }

    private function _recordExist($email) {
        return $this->db->get_where('student_event_reg', ['email' => $email])->result();
    }

    public function delete($table, $array) {
        $this->db->where($array);
        $q = $this->db->delete($table);
        return $q;
    }

    public function deleteBulkMarket($table, $ids) {
        if (empty($ids)) {
            return FALSE;
        }

        $sql = "DELETE FROM {$table} WHERE market_price_id IN ( ";

        $join = '';
        foreach ($ids as $id) {
            $join .= $id . ',';
        }

        $sql .= rtrim($join, ',') . " )";


        return $this->db->query($sql);
    }

    public function update($table, $data, $where) {
        foreach ($where as $k => $v) {
            $this->db->where($k, $v);
        }
        $query = $this->db->update($table, $data);

        if ($query) {
            return true;
        } else {
            return false;
        }
    }

    public function insert($table, $data) {
        return $this->db->insert($table, $data);
        //return $this->db->insert_id();
    }

    public function getMarketById($id) {
        return $this->db->get_where('markets', ['market_id' => $id])->row()->market_name;
    }

    public function getProductById($id) {
        return $this->db->get_where('products', ['product_id' => $id])->row()->product_name;
    }

    public function getSupplyChains() {
        return $this->supply_chain;
    }

    public function saveContact($data) {
        if (empty($data)) {
            return FALSE;
        }

        $this->_sendEnquiryEmail($data);

        $this->db->insert('enquiries', $data);
        return $this->db->insert_id();
    }

}
