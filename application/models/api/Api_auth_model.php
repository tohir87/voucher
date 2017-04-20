<?php

/**
 * Description of api_auth_model
 *
 * @author JosephT
 * @property CI_DB_active_record $db 
 * @property Db_expression $db_expression 
 * @property User_model $user_model 
 */
class Api_Auth_Model extends CI_Model {

    //put your code here
    const TABLE_AUTH_TOKEN = 'api_auth_token';
    //30 Days.
    const AUTH_TOKEN_TTL = 2592000;

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->library('db_expression');
    }

    /**
     * 
     * @param string $appKey
     * @param int $idUser
     * @param string $token
     * @return api\AuthToken
     */
    public function checkAuth($appKey, $idUser = null, $token = null) {

        if ($idUser !== null) {
            $this->db->where('id_user', (int) $idUser);
        }

        if ($token !== null) {
            $this->db->where('token', $token);
        }

        $r = $this->db
                ->get_where(self::TABLE_AUTH_TOKEN, array(
                    'app_key' => $appKey,
                    'expiry_date >= ' => $this->db_expression->make('now()')
                ))
                ->result(api\AuthToken::class)
        ;

        return current($r);
    }

    /**
     * Create auth for user in application ID
     * @param string $appKey
     * @param int $idUser
     * 
     * @return api\AuthToken
     */
    public function createAuth($appKey, $idUser, $id_company = null) {
        if(!$id_company){
            $id_company = $this->user_auth ? $this->user_auth->get('id_company') : null;
        }
        
        $data = array(
            'app_key' => $appKey,
            'id_user' => $idUser,
            'id_company' => $id_company,
            'token' => $idUser . '-' . random_string('alnum', 48),
            'expiry_date' => date('Y-m-d H:i:s', time() + self::AUTH_TOKEN_TTL),
            'id_user_account_selected' => $idUser,
        );

        if ($this->db->insert(self::TABLE_AUTH_TOKEN, $data) && ($id = (int) $this->db->insert_id())) {
            return $this->getAuthToken($id);
        }

        return null;
    }

    /**
     * 
     * @param int $id
     * @return api\AuthToken
     */
    public function getAuthToken($id) {
        return $this->db->get_where(self::TABLE_AUTH_TOKEN, ['id' => $id], 1)
                        ->result(api\AuthToken::class)[0];
    }

    /**
     * 
     * @param api\AuthToken $authToken
     * @param int $id_user
     * @return api\AuthToken|null
     */
    public function switchAccount(api\AuthToken $authToken, $id_user) {
        if ($authToken->id_user_account_selected == $id_user) {
            return $authToken;
        }

        $this->load->model('user/user_model', 'user_model');

        $accounts = $this->user_model->get_all_companies($authToken->get('email'), $authToken->get('id_company'));
        foreach ($accounts as $anAccount) {
            if ($anAccount->id_user == $id_user) {
                $data = ['id_company' => $anAccount->id_company, 'id_user_account_selected' => $id_user];
                if ($this->db->update(self::TABLE_AUTH_TOKEN, $data, ['id' => $authToken->id], 1)) {
                    return $this->getAuthToken($authToken->id);
                }
                return null;
            }
        }

        return null;
    }

}
