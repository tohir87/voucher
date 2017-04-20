<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * Description of Setup_model
 *
 * @author TOHIR
 * @property User_auth_lib $user_auth_lib Description
 * @property CI_DB_driver $db Description
 */
class Setup_model extends CI_Model {

    const TBL_GROUPS = 'groups';
    const TBL_CATEGORIES = 'categories';
    const TBL_SUB_CATEGORIES = 'sub_categories';
    const TBL_SOURCES = 'sources';
    const TBL_VARIETIES = 'varieties';
    const TBL_PRO_VARIETIES = 'product_varieties';
    const TBL_PRO_SOURCES = 'product_sources';
    const TBL_M_WHOLESALES = 'metric_wholesale';
    const TBL_M_RETAIL = 'metric_retail';
    const TBL_PROVIDERS = 'providers';
    const TBL_MARKETS = 'markets';
    const TBL_PRODUCTS = 'products';
    const TBL_REMARKS = 'remarks';
    const TBL_PRODUCT_METRIC_INFO = 'product_metric_info';
    
    private $metric_types;

    public function __construct() {
        parent::__construct();
        $this->load->database();
        
        $this->metric_types = [1 => 'Wholesale', 2 => 'Retail'];
    }

    public function saveCategories(array $data) {

        $data_db = [];
        if (!is_array($data) || empty($data)) {
            return FALSE;
        }

        for ($j = 0; $j < count($data['group_id']); ++$j) {
            $data_db[] = array(
                'group_id' => $data['group_id'][$j],
                'category_name' => $data['category_name'][$j],
                'category_desc' => $data['category_desc'][$j],
                'date_created' => date('Y-m-d h:i:s')
            );
        }

        return $this->db->insert_batch(self::TBL_CATEGORIES, $data_db);
    }

    public function saveMarket(array $data) {
        $data_db = [];
        if (!is_array($data) || empty($data)) {
            return FALSE;
        }

        for ($j = 0; $j < count($data['market_name']); ++$j) {
            $data_db[] = array(
                'market_name' => $data['market_name'][$j],
                'state_id' => $data['state_id'][$j],
                'location' => $data['location'][$j],
                'date_added' => date('Y-m-d h:i:s'),
                'added_by' => $this->user_auth_lib->get('user_id'),
                'status' => USER_STATUS_ACTIVE
            );
        }

        return $this->db->insert_batch(self::TBL_MARKETS, $data_db);
    }

    public function saveSources(array $data) {

        $data_db = [];
        if (!is_array($data) || empty($data)) {
            return FALSE;
        }

        for ($j = 0; $j < count($data['source']); ++$j) {
            $data_db[] = array(
                'source' => $data['source'][$j],
                'description' => $data['description'][$j],
                'date_created' => date('Y-m-d h:i:s')
            );
        }

        return $this->db->insert_batch(self::TBL_SOURCES, $data_db);
    }

    public function saveVarieties(array $data) {

        $data_db = [];
        if (!is_array($data) || empty($data)) {
            return FALSE;
        }

        for ($j = 0; $j < count($data['variety']); ++$j) {
            $data_db[] = array(
                'variety' => $data['variety'][$j],
                'description' => $data['description'][$j],
                'date_created' => date('Y-m-d h:i:s')
            );
        }

        return $this->db->insert_batch(self::TBL_VARIETIES, $data_db);
    }

    public function saveMetricWholeSales(array $data) {

        $data_db = [];
        if (!is_array($data) || empty($data)) {
            return FALSE;
        }

        for ($j = 0; $j < count($data['metric']); ++$j) {
            $data_db[] = array(
                'metric' => $data['metric'][$j],
                'description' => $data['description'][$j],
                'date_created' => date('Y-m-d h:i:s')
            );
        }

        return $this->db->insert_batch(self::TBL_M_WHOLESALES, $data_db);
    }

    public function saveMetricRetail(array $data) {

        $data_db = [];
        if (!is_array($data) || empty($data)) {
            return FALSE;
        }

        for ($j = 0; $j < count($data['metric']); ++$j) {
            $data_db[] = array(
                'metric' => $data['metric'][$j],
                'description' => $data['description'][$j],
                'date_created' => date('Y-m-d h:i:s')
            );
        }

        return $this->db->insert_batch(self::TBL_M_RETAIL, $data_db);
    }

    public function fetch_categories() {
        $fields = "c.*, g.group_name";
        $sql = "SELECT count(*) FROM sub_categories s WHERE s.category_id = c.category_id";
        $fields .= ", ($sql) AS sub_categories";
        return $this->db->select($fields)
                        ->from(self::TBL_CATEGORIES . ' as c')
                        ->join(self::TBL_GROUPS . ' as g', 'c.group_id=c.group_id')
                        ->get()->result();
    }

    public function toggleStatus($id, $table, $column) {

        $set = array(
            'status' => \db\Expr::make('!status'),
            'date_updated' => \db\Expr::make('now()'),
        );

        $this->db->update($table, $set, array(
            $column => $id,
        ));

        return $this->db->affected_rows() > 0;
    }

    public function fetch_sub_categories($category_id) {
        return $this->db
                        ->select('s.*')
                        ->from(self::TBL_SUB_CATEGORIES . ' as s')
                        ->where('s.category_id', $category_id)
                        ->get()->result();
    }

    public function addSubCategory($data) {
        $data['date_added'] = date('Y-m-d h:i:s');
        return $this->db->insert(self::TBL_SUB_CATEGORIES, $data);
    }

    public function fetch_wholesale_metrics() {
        $fields = "c.*";
        $sql = "SELECT count(*) FROM metric_wholesale_category m WHERE m.metric_wholesale_id = c.metric_wholesale_id";
        $fields .= ", ($sql) AS sub_categories";
        return $this->db->select($fields)
                        ->from(self::TBL_M_WHOLESALES . ' as c')
                        ->get()->result();
    }

    public function fetch_retail_metrics() {
        $fields = "c.*";
        $sql = "SELECT count(*) FROM metric_retail_category m WHERE m.metric_retail_id = c.metric_retail_id";
        $fields .= ", ($sql) AS sub_categories";
        return $this->db->select($fields)
                        ->from(self::TBL_M_RETAIL . ' as c')
                        ->get()->result();
    }

    public function metric_wholesale_category($table, $data) {
        $data_db = [];
        if (!is_array($data) || empty($data)) {
            return FALSE;
        }

        $m_column = $table === 'metric_wholesale_category' ? 'metric_wholesale_id' : 'metric_retail_id';

        for ($j = 0; $j < count($data['category_id']); ++$j) {
            $data_db[] = array(
                'category_id' => $data['category_id'][$j],
                $m_column => $data['whosale_metric_id'],
            );
        }

        return $this->db->insert_batch($table, $data_db);
    }

    public function fetch_metric_ws_categories($table, $id) {
        $m_column = $table === 'metric_wholesale_category' ? 'mw.metric_wholesale_id' : 'mw.metric_retail_id';
        return $this->db->select('mw.*, c.category_name')
                        ->from($table . ' as mw')
                        ->join(self::TBL_CATEGORIES . ' as c', 'c.category_id=mw.category_id')
                        ->where($m_column, $id)
                        ->get()->result();
    }

    public function fetchMarkets() {
        return $this->db->select('m.*, s.StateName, , (select count(1) from market_products where market_id = m.market_id) as p_count')
                        ->from('markets as m')
                        ->join('states s', 'm.state_id=s.StateID', 'left')
                        ->get()->result();
    }

    public function fetchProducts($product_id = null) {
        if ($product_id) {
            $this->db->where('p.product_id', $product_id);
        }
        $products = $this->db->select('p.*, sub.sub_category, pi.image_name, pi.image_url')
                        ->from('products as p')
                        ->join(self::TBL_SUB_CATEGORIES . ' as sub', 'p.sub_category_id=sub.sub_category_id', 'left')
                        ->join('product_images pi', 'p.product_id=pi.product_id', 'left')
                        ->get()->result();
        $result = [];
        if (!empty($products)) {
            foreach ($products as $prod) {
                $result[] = (object) array_merge((array) $prod, ['varieties' => $this->getProductVarieties($prod->product_id)], ['sources' => $this->getProductSources($prod->product_id)], ['product_name_f' => preg_replace('/[^A-Z0-9]+/i', '-', $prod->product_name)], ['wholesale_metrics' => $this->getProductWMetrics($prod->product_id)], ['retail_metrics' => $this->getProductRMetrics($prod->product_id)], ['metrics_info' => $this->getProductMetricInfo($prod->product_id)]
                );
            }
        }

        return $result;
    }

    public function getProductWMetrics($product_id) {
        return $this->db
                        ->select('pwm.*, mw.metric')
                        ->from('product_wholesale_metrics as pwm')
                        ->join(self::TBL_M_WHOLESALES . ' as mw', 'mw.metric_wholesale_id=pwm.metric_wholesale_id')
                        ->where('pwm.product_id', $product_id)
                        ->get()->result();
    }

    public function getProductRMetrics($product_id) {
        return $this->db
                        ->select('prm.*, mr.metric')
                        ->from('product_retail_metrics as prm')
                        ->join(self::TBL_M_RETAIL . ' as mr', 'mr.metric_retail_id=prm.metric_retail_id')
                        ->where('prm.product_id', $product_id)
                        ->get()->result();
    }

    public function getProductVarieties($product_id) {
        return $this->db
                        ->select('pv.*, v.variety')
                        ->from(self::TBL_PRO_VARIETIES . ' as pv')
                        ->join(self::TBL_VARIETIES . ' as v', 'v.variety_id=pv.variety_id')
                        ->where('pv.product_id', $product_id)
                        ->get()->result();
    }

    public function getProductSources($product_id) {
        return $this->db
                        ->select('ps.*, s.source')
                        ->from(self::TBL_PRO_SOURCES . ' as ps')
                        ->join(self::TBL_SOURCES . ' as s', 's.source_id=ps.source_id')
                        ->where('ps.product_id', $product_id)
                        ->get()->result();
    }

    public function saveProduct($data, $logo) {
        if (empty($data)) {
            return FALSE;
        }

        $this->db->insert('products', array(
            'sub_category_id' => $data['sub_category_id'],
            'product_name' => $data['product_name'],
            'product_desc' => $data['product_desc'],
            'season_id' => $data['season_id'],
            'date_created' => date('Y-m-d h:i:s')
        ));

        $product_id = $this->db->insert_id();
        $data_img = [];

        if (!empty($logo) && $logo['name'] !== '') {

            $ext = end((explode(".", $logo['name'])));

            $config = array(
                'upload_path' => FILE_PATH_PRODUCT_LOGO,
                'allowed_types' => "jpg|jpeg|gif|png",
                'overwrite' => TRUE,
                'max_size' => "102400", // Can be set to particular file size , here it is 2 MB(2048 Kb)
                'max_height' => "3000",
                'max_width' => "3000",
            );

            $logo_name = md5(microtime()) . '.' . $ext;
            $config['file_name'] = $logo_name;

            $this->load->library('upload', $config);
            if (!$this->upload->do_upload()) {

                $error = array('error' => $this->upload->display_errors());

                notify('error', 'Invalid file uploaded');
                return FALSE;
            }

            $data_img['image_name'] = $logo_name;
            $data_img['product_id'] = $product_id;
            $data_img['image_url'] = site_url('/files/product_image/' . $logo_name);

            $this->db->insert('product_images', $data_img);
        }

        return TRUE;
    }

    public function add_product_source($param) {

        if (!is_array($param) || empty($param)) {
            return FALSE;
        }

        for ($j = 0; $j < count($param['source_id']); ++$j) {
            $data_db[] = array(
                'source_id' => $param['source_id'][$j],
                'product_id' => $param['product_id'],
            );
        }

        return $this->db->insert_batch(self::TBL_PRO_SOURCES, $data_db);
    }

    public function add_product_metrics($param) {

        if (!is_array($param) || empty($param)) {
            return FALSE;
        }

        $is_added = FALSE;

        if (!empty($param['metric_wholesale_id']) && count($param['metric_wholesale_id'] > 0)) {

            for ($j = 0; $j < count($param['metric_wholesale_id']); ++$j) {
                $data_db_w[] = array(
                    'metric_wholesale_id' => $param['metric_wholesale_id'][$j],
                    'product_id' => $param['product_id'],
                    'added_by' => $this->user_auth_lib->get('user_id'),
                    'date_added' => date('Y-m-d h:i:s')
                );
            }

            $this->db->insert_batch('product_wholesale_metrics', $data_db_w);
            $is_added = TRUE;
        }

        // retail
        if (!empty($param['metric_retail_id']) && count($param['metric_retail_id'] > 0)) {

            for ($k = 0; $k < count($param['metric_retail_id']); ++$k) {
                $data_db_r[] = array(
                    'metric_retail_id' => $param['metric_retail_id'][$k],
                    'product_id' => $param['product_id'],
                    'added_by' => $this->user_auth_lib->get('user_id'),
                    'date_added' => date('Y-m-d h:i:s')
                );
            }

            $this->db->insert_batch('product_retail_metrics', $data_db_r);
            $is_added = TRUE;
        }


        return (!$is_added) ? FALSE : TRUE;
    }

    public function add_product_variety($param) {

        if (!is_array($param) || empty($param)) {
            return FALSE;
        }

        for ($j = 0; $j < count($param['variety_id']); ++$j) {
            $data_db[] = array(
                'variety_id' => $param['variety_id'][$j],
                'product_id' => $param['product_id'],
            );
        }

        return $this->db->insert_batch(self::TBL_PRO_VARIETIES, $data_db);
    }

    public function fetchProductSources($product_id, $rowClass = stdClass::class) {
        return $this->db->select('ps.*, s.source, s.description')
                        ->from(self::TBL_PRO_SOURCES . ' as ps')
                        ->join(self::TBL_SOURCES . ' as s', 's.source_id=ps.source_id')
                        ->where('ps.product_id', $product_id)
                        ->get()->result($rowClass);
    }

    public function fetchProductVarieties($product_id, $rowClass = stdClass::class) {
        return $this->db->select('pv.*, v.variety, v.description')
                        ->from(self::TBL_PRO_VARIETIES . ' as pv')
                        ->join(self::TBL_VARIETIES . ' as v', 'v.variety_id=pv.variety_id')
                        ->where('pv.product_id', $product_id)
                        ->get()->result($rowClass);
    }

    public function getProductCategoryId($product_id) {
        return $this->db->select('s.category_id')
                        ->from(self::TBL_PRODUCTS . ' as p')
                        ->join(self::TBL_SUB_CATEGORIES . ' as s', 'p.sub_category_id=s.sub_category_id')
                        ->where('p.product_id', $product_id)
                        ->get()->row()->category_id;
    }

    public function fetchProductWsMetrics($product_id) {
//        $productCategoryId = $this->getProductCategoryId($product_id);

        return $this->db->select('pwm.*, mw.metric')
                        ->from('product_wholesale_metrics as pwm')
                        ->join('metric_wholesale as mw', 'mw.metric_wholesale_id=pwm.metric_wholesale_id')
                        ->where('pwm.product_id', $product_id)
                        ->get()->result();
    }

    public function fetchProductRtMetrics($product_id) {
//        $productCategoryId = $this->getProductCategoryId($product_id);

        return $this->db->select('prm.*, mr.metric')
                        ->from('product_retail_metrics as prm')
                        ->join('metric_retail as mr', 'mr.metric_retail_id=prm.metric_retail_id')
                        ->where('prm.product_id', $product_id)
                        ->get()->result();
    }

    public function update_product_image($product_id, $logo) {

        if (!empty($logo) && $logo['name'] !== '') {

            $ext = end((explode(".", $logo['name'])));

            $config = array(
                'upload_path' => FILE_PATH_PRODUCT_LOGO,
                'allowed_types' => "jpg|jpeg|gif|png",
                'overwrite' => TRUE,
                'max_size' => "102400", // Can be set to particular file size , here it is 2 MB(2048 Kb)
                'max_height' => "3000",
                'max_width' => "3000",
            );

            $logo_name = md5(microtime()) . '.' . $ext;
            $config['file_name'] = $logo_name;

            $this->load->library('upload', $config);
            if (!$this->upload->do_upload()) {

                $error = array('error' => $this->upload->display_errors());

                notify('error', 'Invalid file uploaded');
                return FALSE;
            }

            $data_img['image_name'] = $logo_name;
            $data_img['product_id'] = $product_id;
            $data_img['image_url'] = site_url('/files/product_image/' . $logo_name);

            if (!$this->db->get_where('product_images', ['product_id' => $product_id])->row()) {
                return $this->db->insert('product_images', $data_img);
            } else {
                $this->db->where('product_id', $product_id)
                        ->update('product_images', $data_img);
                return $this->db->affected_rows() > 0;
            }
        }
    }

    public function addMarketProducts($market_id, $product_ids) {
        if (empty($product_ids['product_id'])) {
            return FALSE;
        }

        $data_db = [];
        foreach ($product_ids['product_id'] as $p_id) {
            $data_db[] = [
                'product_id' => $p_id,
                'market_id' => $market_id,
                'added_by' => $this->user_auth_lib->get('user_id'),
                'date_added' => date('Y-m-d h:i:s')
            ];
        }

        if (!empty($data_db)) {
            $this->db->insert_batch('market_products', $data_db);
            return TRUE;
        }

        return FALSE;
    }

    public function addRemark($data) {
        $data['date_added'] = date('Y-m-d h:i:s');
        $data['added_by'] = $this->user_auth_lib->get('user_id');

        return $this->db->insert('remarks', $data);
    }

    public function getProductDetails($product_id = NULL) {
        if ($product_id) {
            $this->db->where('p.product_id', $product_id);
        }

        return $this->db->select('p.*, s.category_id')
                        ->from(self::TBL_PRODUCTS . ' as p')
                        ->join(self::TBL_SUB_CATEGORIES . ' as s', 's.sub_category_id=p.sub_category_id')
                        ->get()->result();
    }
    
    public function getProductMetricInfo($product_id) {
        return $this->db->get_where(self::TBL_PRODUCT_METRIC_INFO, ['product_id' => $product_id])->result();
    }
    
    public function getMetric_types() {
        return $this->metric_types;
    }

}
