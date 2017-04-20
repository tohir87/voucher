<?php

/**
 * Description of companiless_auth
 *
 * @author JosephT
 * @property User_model $user_model
 * @property Api_Auth_Model $api_auth_model Description
 * @property CI_DB_active_record  $db
 * @property Phone_Verifier  $phone_verifier
 */
class Companiless_Auth_Model extends CI_Model {

    //put your code here

    public function __construct() {
        parent::__construct();
        $this->load->model('user/user_model');
        $this->load->model('api/api_auth_model');
        $this->load->library(['phone_verifier']);
    }

    public function emailLogin($email, $password, $appKey, $userClass = api\UserAccount::class) {
        $pass = user_auth::encrypt($password);
        $this->db
                ->select('u.id_user, u.id_company, u.email, c.id_company')
                ->from('users u')
                ->where('email', $email)
                ->where('password', $pass)
        ;

        $this->_addCommonParts();

        $rows = $this->db
                ->get()
                ->result()
        ;

        return $this->_assembleInfo($rows, $appKey, $userClass);
    }

    private function _phoneUserData($phone, $countryCode, $password) {
        $pass = user_auth::encrypt($password);
        $phoneEscaped = $this->db->escape($phone);
        $this->db
                ->select('u.id_user, u.id_company, u.email, c.id_company, ep.id_country_code, ep.phone_number, ep.verified, ep.id_employee_phone')
                ->from('users u')
                ->join('employee_phone ep', 'ep.id_user = u.id_user')
                ->where('u.password', $pass)
                ->where('ep.id_country_code', $countryCode)
                ->where("SUBSTR(ep.phone_number FROM - 10) = SUBSTR({$phoneEscaped} FROM - 10)", null, false)
        // SUBSTR(phone_number FROM - 10) = SUBSTR('08054660657' FROM - 10) 
        ;

        $this->_addCommonParts();

        return $this->db
                        ->get()
                        ->result()
        ;
    }

    private function _retrievePhoneIds($rows) {
        $ids = [];
        foreach ($rows as $row) {
            $ids[] = $row->id_employee_phone;
        }

        return array_unique($ids);
    }

    public function phoneLogin($phone, $countryCode, $password, $appKey, &$requireVerify = false) {
        $rows = $this->_phoneUserData($phone, $countryCode, $password);
        //do we need to verify this phone?

        if (!empty($rows) && ($requireVerify = !$rows[0]->verified)) {
            $id_phones = $this->_retrievePhoneIds($rows);
            $error = '';
            if (!$this->phone_verifier->sendVerifyRequest($phone, $countryCode, $id_phones, $error)) {
                log_message('error', 'Verify message could not be sent to owner due to error: ' . $error);
                $requireVerify = false;
            }
            return [];
        }


        return $this->_assembleInfo($rows, $appKey, api\UserAccount::class);
    }

    public function phoneVerifyAndLogin($phone, $countryCode, $password, $code, $appKey, &$error = '') {
        $rows = $this->_phoneUserData($phone, $countryCode, $password);
        //do we need to verify this phone?

        if (!empty($rows)) {
            $id_phones = $this->_retrievePhoneIds($rows);
            if (!$this->phone_verifier->checkVerifyRequest($id_phones, $code, $error)) {
                log_message('error', 'Verification failed : ' . $error);
                return [];
            }
        }

        return $this->_assembleInfo($rows, $appKey, api\UserAccount::class);
    }

    private function _addCommonParts() {
        $this->db
                ->select("IF(c.id_own_company > 0, c.id_own_company, c.id_company) AS company_group, IF(c.id_own_company, c2.id_string, c.id_string) AS company_id_string", false)
                ->join('companies c', 'c.id_company = u.id_company')
                ->join('companies c2', 'c.id_own_company = c2.id_company', 'left')
                ->where_in('u.status', [USER_STATUS_ACTIVE, USER_STATUS_PROBATION_ACCESS])
                ->order_by('company_id_string, c.id_own_company')
        ;
    }

    private function _assembleInfo($accounts, $appKey, $userClass = api\UserAccount::class) {
        //loops through for valid accounts, accounts with access
        //then returns {user: UserAccount, company_url: "url", token: "Token"}
        $accountList = [];

        /* @var $tokens \api\AuthToken[] */
        $tokens = [];

        foreach ($accounts as $userAcct) {
            $accountInfo = $this->user_model
                            ->fetch_account_info($userAcct->id_company, ['u.id_user' => $userAcct->id_user], 1, 0, $userClass, true)[0];

            if ($accountInfo && !$accountInfo->account_blocked) {
                if (!array_key_exists($userAcct->company_id_string, $tokens)) {
                    $tokens[$userAcct->company_id_string] = $this->api_auth_model->createAuth($appKey, $userAcct->id_user, $userAcct->id_company);
                }

                $accountList[] = [
                    'token' => $tokens[$userAcct->company_id_string]->token,
                    'token_expiry' => $tokens[$userAcct->company_id_string]->expiryDateISO(),
                    'company_url' => $this->getCompanyBaseUrl($userAcct->company_id_string),
                    'user' => $accountInfo,
                ];
            }
        }

        return $accountList;
    }

    private function getCompanyBaseUrl($idString) {
        if (TB_ON_SITE_MODE && file_exists('BASEURL')) {
            return trim(file_get_contents('BASEURL'));
        } else {
            return str_replace('portal.', $idString . '.', APP_PORTAL_URL);
        }
    }

}
