<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * Description of user_model
 *
 * @author TOHIR
 * @property User_auth_lib $user_auth_lib Description
 * @property CI_DB_query_builder $db Description
 */
class User_model extends CI_Model {

    const TBL_USER = 'users';
    const TBL_USER_TYPE = 'user_types';
    const TBL_TRADERS = 'traders';
    const TBL_TRADER_PROD = 'trader_products';

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function last_staff_id($school_id) {
        $sql = "SELECT staff_id FROM employees WHERE school_id = '" . $school_id . "' order by staff_id desc limit 1 ";

        $result = $this->db->query($sql)->result_array();

        if (!$result) {
            return '';
        }

        return $result[0]['staff_id'];
    }

    /**
     * Fetch user account by array values from users table.
     * Return false if record not exists.
     * 
     * EXAMPLE 1:
     * 
     * $query_fields = array(
     *                  'email' => 'user@example.com', 
     *                  'password' => 'user_password'
     *                 );
     * 
     * This will create query with email and password fields.
     * 
     * EXAMPLE: 2
     * 
     * $query_fields = array(
     *                   'id_user' => 55
     *                 );
     * 
     * This will create query with id only.
     * 
     * This approach gives us possiblity to get user record with many different 
     * criterias instead of creating many functions like:
     * 
     * fetch_account_by_email_password()
     * fetch_account_by_id()
     * 
     * @access public
     * @param array $query_fields
     * @return mixed (bool | array)
     */
    public function fetch_account(array $query_fields) {

        if (empty($query_fields)) {
            trigger_error('query fields cannot be empty!', E_USER_WARNING);
        }

        $sql = "SELECT 
					u.*,
                    e.*,
					s.school_name, 
					s.string_id as school_id_string,
					s.status as school_status,
					s.cdn_container as cdn_container,
					s.logo_path
				FROM 
					users u, 
                    employees e,
					schools s 
				WHERE 
					s.school_id = u.school_id 
                    AND e.user_id = u.user_id ";

        foreach ($query_fields as $field => $value) {

            if (substr($field, 0, 2) == 'u.') {
                $sql .= "AND " . $field . " = '" . $value . "' ";
            } else {
                $sql .= "AND u." . $field . " = '" . $value . "' ";
            }
        }

        return $this->db->query($sql)->result();
    }

    public function fetch_user_groups_modules_perms($user_id) {

        $sql = "SELECT
	                m.module_id,
                    m.subject AS module_subject,
                    m.id_string AS module_id_string,
	                p.subject AS perm_subject,
                    p.perm_id,
	                p.id_string AS perm_id_string,
	                p.in_menu,
	                u.user_id
                    FROM user_perms u
                    LEFT JOIN module_perms p ON p.perm_id = u.perm_id
                    AND p.in_menu = 1
                    LEFT JOIN modules m ON m.module_id = p.module_id
                    WHERE u.user_id = " . $user_id . "
                    GROUP BY u.perm_id
                    order by m.menu_order, m.subject, p.menu_order, p.subject
                    ";

        $result = $this->db->query($sql)->result_array();
        if (empty($result)) {
            return false;
        }

        return $result;
    }

    public function fetch_admin_account($params) {
        if (!is_array($params)) {
            return FALSE;
        }

        return $this->db->get_where(TBL_SUPER_ADMIN)->row();
    }

    public function fetchaccount($params) {
        if (!is_array($params)) {
            return FALSE;
        }

        return $this->db->get_where(TBL_USERS, $params)->row();
    }

    public function fetchUnassignedPerms($user_id) {
        $sql = "SELECT * FROM module_perms WHERE perm_id not IN (select perm_id FROM user_perms WHERE user_id = {$user_id} )";
        return $this->db->query($sql)->result();
    }

    public function getUnassignedPerms($user_id) {
        $perms = $this->fetchUnassignedPerms($user_id);
        $res = [];
        if (!empty($perms)) {
            foreach ($perms as $perm) {
                array_push($res, $perm->perm_id);
            }
        }

        return $res;
    }

    public function fetchAllPerms() {
        return $this->db
                        ->select('mp.*, m.subject as module')
                        ->from('module_perms mp')
                        ->join('modules m', 'mp.module_id=m.module_id')
                        ->get()->result();
    }

    public function assignAllPerm($user_id) {
        $allPerms = $this->fetchUnassignedPerms($user_id);
        if (empty($allPerms)) {
            return;
        }

        $datadb = [];
        $excluded_perms = [];

        foreach ($allPerms as $perm) {
            if (!in_array($perm->perm_id, $excluded_perms)) {
                $datadb[] = array(
                    'user_id' => $user_id,
                    'perm_id' => $perm->perm_id,
                    'module_id' => $perm->module_id,
                );
            }
        }

        return !empty($datadb) ? $this->db->insert_batch(TBL_USER_PERMS, $datadb) : TRUE;
    }

    public function assignDefaultPermissions($user_id, $default_perms) {

//check if have basic default permission
        $batch = [];
        foreach ($default_perms as $id_module => $perm) {

            foreach ($perm as $key => $id_perm) {

                if (!$id_perm) {
                    $permObj = $this->db->get_where('module_perms', ['module_id' => $id_module, 'id_string' => $key], 1)
                                    ->result()[0];
                    if (!$permObj) {
                        throw new RuntimeException("Permision with module_id: $id_module AND id_string: $key");
                    }

                    $id_perm = $permObj->id_perm;
                }

                $check_perm = $this->db->get_where('user_perms', array('perm_id' => $id_perm, 'module_id' => $id_module, 'user_id' => $user_id))->result();

                if (empty($check_perm)) {

                    $perm_data = array(
                        'user_id' => $user_id,
                        'module_id' => $id_module,
                        'perm_id' => $id_perm
                    );

                    $batch[] = $perm_data;
                }
            }
        }

        if (!empty($batch)) {
            $this->db->insert_batch('user_perms', $batch);
        }
    }

    /**
     * Save user data.
     * If id_user exists in array, than it will call update function.
     * Else, will call insert function.
     * 
     * @access public
     * @param array $data 
     * @return bool
     */
    final public function save(array $data, $where = null) {

        if (!is_null($where)) {
            return $this->update($data, $where);
        } else {
            return $this->db->insert(TBL_USERS, $data);
        }
    }

    final protected function update(array $data, $where) {
        $this->db->update(TBL_USERS, $data, $where);
    }

    public function fetchUsers() {
        return $this->db->select('u.*, t.user_type')
                        ->from(self::TBL_USER . ' as u')
                        ->join(self::TBL_USER_TYPE . ' as t', 'u.user_type_id=t.user_type_id')
                        ->where('u.user_type_id <>', USER_TYPE_SUBSCRIBER)
                        ->get()->result();
    }

    public function toggleStatus($user_id) {

        $set = array(
            'status' => \db\Expr::make('!status'),
            'date_updated' => \db\Expr::make('now()'),
        );

        $this->db->update(self::TBL_USER, $set, array(
            'user_id' => $user_id,
        ));

        return $this->db->affected_rows() > 0;
    }

    public function verify_password($password, $user_id) {
        return $this->db->get_where('users', ['user_id' => $user_id, 'password' => $this->user_auth_lib->encrypt($password)])->row();
    }

    public function update_password($password, $user_id) {
        return $this->db
                        ->where('user_id', $user_id)
                        ->update('users', ['password' => $this->user_auth_lib->encrypt($password)]);
    }

    public function clear_user_perms($user_id) {
        return $this->db->where('user_id', $user_id)
                        ->delete(TBL_USER_PERMS);
    }

    public function fetchTraders($id = NULL) {
        if (!is_null($id)) {
            $this->db->where('t.trader_id', $id);
        }
        $traders = $this->db
                        ->select('t.*, m.market_name')
                        ->from(self::TBL_TRADERS . ' as t')
                        ->join(Setup_model::TBL_MARKETS . ' as m', 'm.market_id=t.market_id')
                        ->get()->result();
        $result = [];

        if (!empty($traders)) {
            foreach ($traders as $aTrader) {
                $result[] = (object) array_merge((array) $aTrader, ['products' => $this->_getTraderProducts($aTrader->trader_id)]);
            }
        }
        return $result;
    }

    private function _getTraderProducts($trader_id) {
        $t_product = [];
        $products = $this->db
                        ->select('p.product_name, p.product_id')
                        ->from(self::TBL_TRADER_PROD . ' as tp')
                        ->join(Setup_model::TBL_PRODUCTS . ' as p', 'tp.product_id=p.product_id')
                        ->where('tp.trader_id', $trader_id)
                        ->get()->result();
        if (!empty($products)) {
            foreach ($products as $pro) {
                $t_product[$pro->product_id] = $pro->product_name;
            }
        }

        return $t_product;
    }

    public function traderPhoneExist($phone) {
        return $this->db->get_where(self::TBL_TRADERS, ['phone' => str_replace(['-', '(', ')'], '', $phone)])->result();
    }

    /**
     * Get user permission
     * 
     * @access public
     * @param user_id
     * @param perm_id 
     * @return bool
     */
    public function get_user_perm(array $param_fields) {

        if (empty($param_fields)) {
            return false;
        }

        $result = $this->db->get_where("user_perms", $param_fields)->result();

        if (!empty($result)) {
            return true;
        }
        return false;
    }

    public function saveTrader($data) {
        if (empty($data)) {
            return FALSE;
        }

        $this->db->insert(self::TBL_TRADERS, [
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'gender_id' => $data['gender_id'],
            'market_id' => $data['market_id'],
            'email' => $data['email'],
            'phone' => str_replace(['-', '(', ')'], '', $data['phone']),
            'phone2' => $data['phone2'],
            'shop_no' => $data['shop_no'],
            'metric_type' => $data['metric_type']
        ]);

        $trader_id = $this->db->insert_id();


        if (count($data['product_id']) > 0) {
            $data_db = [];
            foreach ($data['product_id'] as $pid) {
                $data_db[] = [
                    'trader_id' => $trader_id,
                    'product_id' => $pid
                ];
            }
            !empty($data_db) ? $this->db->insert_batch(self::TBL_TRADER_PROD, $data_db) : '';
        }

        return TRUE;
    }

    public function log_db($data) {
        return $this->db->insert('user_logs', $data);
    }

    public function updateTrader($id, $data) {

        if (empty($data) || !is_numeric($id)) {
            return FALSE;
        }

        $data_db = ['first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'gender_id' => $data['gender_id'],
            'market_id' => $data['market_id'],
            'email' => $data['email'],
            'phone' => str_replace(['-', '(', ')'], '', $data['phone']),
            'phone2' => $data['phone2'],
            'shop_no' => $data['shop_no'],
            'metric_type' => $data['metric_type']];

        if (count($data['product_id']) > 0) {
            $data_pro = [];
            foreach ($data['product_id'] as $pid) {
                $data_pro[] = [
                    'trader_id' => $id,
                    'product_id' => $pid
                ];
            }
            // delete previous products
            $this->db->delete(self::TBL_TRADER_PROD, ['trader_id' => $id]);
            !empty($data_pro) ? $this->db->insert_batch(self::TBL_TRADER_PROD, $data_pro) : '';
        }

        $this->db->where('trader_id', $id)
                ->update(self::TBL_TRADERS, $data_db);

        return TRUE;
    }

}
