<?php
require_once 'Setup_model.php';
/**
 * Description of Product_model
 *
 * @author tohir
 */
class Product_model extends Setup_model {
    
    public function saveMetricInfo($data) {
        if (empty($data)){
            return FALSE;
        }
        
        return $this->db->insert(self::TBL_PRODUCT_METRIC_INFO, ['product_id' => $data['product_id'],'metric_type' => $data['metric_type'], 'info' => $data['metric_info'], 'added_by' => $this->user_auth_lib->get('user_id'), 'date_added' => date('Y-m-d h:i:s')]);
    }
}
