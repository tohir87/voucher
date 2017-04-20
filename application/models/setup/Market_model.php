<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * Description of Market_model
 *
 * @author TOHIR
 * @property User_auth_lib $user_auth_lib Description
 * @property Setup_model $setup_model Description
 * @property CI_DB_query_builder $db Description
 * 
 */
class Market_model extends CI_Model {

    const TBL_MARKETS = 'markets';
    const TBL_MARKET_PRICES = 'market_prices';
    const TBL_MARKET_W_PRICES = 'market_wholesale_price';
    const TBL_MARKET_R_PRICES = 'market_retail_price';
    const TBL_MARKET_PRODUCTS = 'market_products';
    const TBL_MARKET_EXCEPTIONS = 'exemptions';

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function apply_variety_price($data) {
        $varietes = $this->setup_model->fetchProductVarieties($data['product_id']);
        $m = 0;


        if (empty($varietes)) {
            return FALSE;
        }
        foreach ($varietes as $variety) {
            $market_data = array(
                'product_id' => $data['product_id'],
                'market_id' => $data['market_id'][0],
                'market_date' => date('Y-m-d', strtotime($data['market_date'])),
                'source_id' => $data['source_id'][0],
                'variety_id' => $variety->variety_id,
                'remark' => $data['remark'][0],
                'added_by' => $this->user_auth_lib->get('user_id'),
                'date_added' => date('Y-m-d h:i:s')
            );
            // add market product
            $this->db->insert(self::TBL_MARKET_PRICES, $market_data);
            $market_price_id = $this->db->insert_id();

            // process metric wholesale

            $data_whosale = [];
            for ($j = 0; $j < count($data['metric_whole_sale_id'][$m]); ++$j) {

                if (trim($data['price_wholesale_high'][$m][$j]) !== '') {
                    $data_whosale[] = array(
                        'metric_wholesale_id' => $data['metric_whole_sale_id'][$m][$j],
                        'price_high' => $data['price_wholesale_high'][$m][$j],
                        'price_low' => $data['price_wholesale_low'][$m][$j],
                        'price_ave' => floatval(($data['price_wholesale_low'][$m][$j] + $data['price_wholesale_high'][$m][$j]) / 2),
                        'market_price_id' => $market_price_id,
                        'market_id' => $data['market_id'][$m],
                    );
                }
            }

            // process metric retail
            $data_retail = [];
            for ($k = 0; $k < count($data['metric_retail_id'][$m]); ++$k) {
                if (trim($data['price_retail_high'][$m][$k]) !== '') {

                    $data_retail[] = array(
                        'metric_retail_id' => $data['metric_retail_id'][$m][$k],
                        'price_high' => $data['price_retail_high'][$m][$k],
                        'price_low' => $data['price_retail_low'][$m][$k],
                        'price_ave' => floatval(($data['price_retail_high'][$m][$k] + $data['price_retail_low'][$m][$k]) / 2),
                        'market_price_id' => $market_price_id,
                        'market_id' => $data['market_id'][$m],
                    );
                }
            }
            !empty($data_whosale) ? $this->db->insert_batch('market_wholesale_price', $data_whosale) : '';
            !empty($data_retail) ? $this->db->insert_batch('market_retail_price', $data_retail) : '';
        }


        return true;
    }

    public function addMarketPrices($data) {
        if (empty($data)) {
            return FALSE;
        }

        if (isset($data['apply'])) {
            // apply price for all varieties
            $this->apply_variety_price($data);
            return TRUE;
        }


        $this->db->trans_start();
        for ($m = 0; $m < count($data['market_id']); ++$m) {

            $this->db->insert(self::TBL_MARKET_PRICES, array(
                'product_id' => $data['product_id'],
                'market_id' => $data['market_id'][$m],
                'market_date' => date('Y-m-d', strtotime($data['market_date'])),
                'source_id' => $data['source_id'][$m],
                'variety_id' => $data['variety_id'][$m],
                'remark' => array_key_exists('remark', $data) ? json_encode($data['remark'][$m]) : '',
                'added_by' => $this->user_auth_lib->get('user_id'),
                'date_added' => date('Y-m-d h:i:s'),
                'activity' => $data['activity']
                    )
            );

            $market_price_id = $this->db->insert_id();

            // process metric wholesale
            $data_whosale = [];
            for ($j = 0; $j < count($data['metric_whole_sale_id'][$m]); ++$j) {

                if (trim($data['price_wholesale_high'][$m][$j]) !== '') {
                    $data_whosale[] = array(
                        'metric_wholesale_id' => $data['metric_whole_sale_id'][$m][$j],
                        'price_high' => $data['price_wholesale_high'][$m][$j],
                        'price_low' => $data['price_wholesale_low'][$m][$j],
                        'price_ave' => floatval(($data['price_wholesale_low'][$m][$j] + $data['price_wholesale_high'][$m][$j]) / 2),
                        'market_price_id' => $market_price_id,
                        'market_id' => $data['market_id'][$m],
                    );
                }
            }

            // process metric retail
            $data_retail = [];
            for ($k = 0; $k < count($data['metric_retail_id'][$m]); ++$k) {
                if (trim($data['price_retail_high'][$m][$k]) !== '') {

                    $data_retail[] = array(
                        'metric_retail_id' => $data['metric_retail_id'][$m][$k],
                        'price_high' => $data['price_retail_high'][$m][$k],
                        'price_low' => $data['price_retail_low'][$m][$k],
                        'price_ave' => floatval(($data['price_retail_high'][$m][$k] + $data['price_retail_low'][$m][$k]) / 2),
                        'market_price_id' => $market_price_id,
                        'market_id' => $data['market_id'][$m],
                    );
                }
            }
            !empty($data_whosale) ? $this->db->insert_batch('market_wholesale_price', $data_whosale) : '';
            !empty($data_retail) ? $this->db->insert_batch('market_retail_price', $data_retail) : '';
        }

        $this->db->trans_complete();

        return TRUE;
    }

    public function fetchProductPrices($product_id = NULL, $market_id = NULL, $variety_id = null, $start_date = '', $end_date = '', $limit = false) {
        if ($market_id && $market_id > 0) {
            $this->db->where('mp.market_id', $market_id);
        }
        if ($product_id && $product_id > 0) {
            $this->db->where('mp.product_id', $product_id);
        }
        if ($variety_id && $variety_id > 0) {
            $this->db->where('mp.variety_id', $variety_id);
        }
        if ($start_date !== '') {
            $this->db->where('mp.market_date >=', date('Y-m-d', strtotime($start_date)));
        }
        if ($end_date !== '') {
            $this->db->where('mp.market_date <=', date('Y-m-d', strtotime($end_date)));
        }

        if ($limit) {
            if (!$market_id) {
                $this->db->limit(20);
            }
        }
        $prices = $this->db
                        ->select('mp.*, p.product_name, s.source, m.market_name, v.variety')
                        ->from(self::TBL_MARKET_PRICES . ' as mp')
                        ->join(Setup_model::TBL_PRODUCTS . ' as p', 'p.product_id = mp.product_id')
                        ->join(Setup_model::TBL_SOURCES . ' as s', 'mp.source_id = s.source_id')
                        ->join(Setup_model::TBL_VARIETIES . ' as v', 'mp.variety_id = v.variety_id', 'left')
                        ->join(self::TBL_MARKETS . ' as m', 'mp.market_id = m.market_id')
                        ->order_by('mp.market_date', 'desc')
                        ->get()->result();

        if (empty($prices)) {
            return FALSE;
        }

        $result = [];
        foreach ($prices as $price) {
            $result[] = (object) array_merge((array) $price, ['wholesale' => $this->_fetchWholePrice($price->market_price_id)], ['retail' => $this->_fetchRetailPrice($price->market_price_id)]);
        }

        return $result;
    }

    private function _fetchWholePrice($market_price_id) {
        return $this->db
                        ->select('mwp.*,mw.metric')
                        ->from(self::TBL_MARKET_W_PRICES . ' as mwp')
                        ->join(Setup_model::TBL_M_WHOLESALES . ' as mw', 'mwp.metric_wholesale_id=mw.metric_wholesale_id')
                        ->where('mwp.market_price_id', $market_price_id)
                        ->get()->result();
    }

    private function _fetchRetailPrice($market_price_id) {
        return $this->db
                        ->select('mrp.*,mr.metric')
                        ->from(self::TBL_MARKET_R_PRICES . ' as mrp')
                        ->join(Setup_model::TBL_M_RETAIL . ' as mr', 'mrp.metric_retail_id=mr.metric_retail_id')
                        ->where('mrp.market_price_id', $market_price_id)
                        ->get()->result();
    }

    public function addRecentPrice($product_id, $data) {
        //$market_date, $market_id, 
        $market_id = $data['market_id'];
        $market_date = $data['market_date'];
        $market_from = $data['market_from'];
        // get recent markets
        $prices = $this->getRecentPrices($product_id, $market_id, $market_from);

        if (empty($prices)) {
            return FALSE;
        }

        $data_wholesale = $data_retail = [];
        foreach ($prices as $price) {
            $this->db->insert(self::TBL_MARKET_PRICES, array_merge((array) $price, ['market_date' => date('Y-m-d', strtotime($market_date)), 'date_added' => date('Y-m-d h:i:s'), 'added_by' => $this->user_auth_lib->get('user_id'), 'market_price_id' => null]));
            $market_price_id = $this->db->insert_id();

            // process market wholesale price
            $wholesale_prices = $this->getMarketWholesalePrice($price->market_price_id);
            if (!empty($wholesale_prices)) {
                foreach ($wholesale_prices as $w_price) {
                    $data_wholesale[] = array_merge((array) $w_price, ['market_price_id' => $market_price_id, 'id' => null]);
                }
            }

            //process market retail price
            $retail_prices = $this->getMarketRetailPrice($price->market_price_id);
            if (!empty($retail_prices)) {
                foreach ($retail_prices as $r_price) {
                    $data_retail[] = array_merge((array) $r_price, ['market_price_id' => $market_price_id, 'id' => null]);
                }
            }
        }
        !empty($data_wholesale) ? $this->db->insert_batch(self::TBL_MARKET_W_PRICES, $data_wholesale) : '';
        !empty($data_retail) ? $this->db->insert_batch(self::TBL_MARKET_R_PRICES, $data_retail) : '';

        return TRUE;
    }

    public function getMarketRetailPrice($id) {
        return $this->db->get_where(self::TBL_MARKET_R_PRICES, ['market_price_id' => $id])->result();
    }

    public function getMarketWholesalePrice($id) {
        return $this->db->get_where(self::TBL_MARKET_W_PRICES, ['market_price_id' => $id])->result();
    }

    public function getRecentPrices($product_id, $market_id, $market_date = NULL) {
//        $marketPrice = $this->_getRecentMarketDate($product_id, $market_id);
//        if (!$marketPrice) {
//            return FALSE;
//        }

        return $this->db
                        ->select('*')
                        ->from(self::TBL_MARKET_PRICES)
                        ->where('product_id', $product_id)
                        ->where('market_date', date('Y-m-d', strtotime($market_date)))
                        ->where('market_id', $market_id)
                        ->get()->result();
    }

    private function _getRecentMarketDate($product_id, $market_id = null) {
        if ($market_id) {
            $this->db->where('market_id', $market_id);
        }
        return $this->db
                        ->select('market_date')
                        ->from(self::TBL_MARKET_PRICES)
                        ->where('product_id', $product_id)
                        ->order_by('market_price_id', 'desc')
                        ->get()->row();
    }

    public function haveRecentPrice($product_id) {
        if (!empty($this->_getRecentMarketDate($product_id))) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function fetchPendingProducts($market_id, $start_date = null, $end_date = null) {
        if ($start_date) {
            $this->db->where('mp.market_date >=', date('Y-m-d', strtotime($start_date)));
        }
        if ($end_date) {
            $this->db->where('mp.market_date <=', date('Y-m-d', strtotime($end_date)));
        }
        return $this->db
                        ->select('mp.market_price_id, mp.product_id, mp.market_id, mp.market_date, m.market_name, p.product_name')
                        ->from(self::TBL_MARKET_PRICES . ' as mp')
                        ->join(self::TBL_MARKETS . ' as m', 'mp.market_id=m.market_id')
                        ->join(Setup_model::TBL_PRODUCTS . ' as p', 'mp.product_id=p.product_id')
                        ->where('mp.status', INACTIVE)
                        ->where('mp.market_id', $market_id)
//                ->group_by('mp.product_id')
                        ->get()->result();
    }

    public function fetchMarketWholesalePrices($market_price_id) {
        return $this->db
                        ->select('mwp.*, mw.metric')
                        ->from(self::TBL_MARKET_W_PRICES . ' as mwp')
                        ->join(Setup_model::TBL_M_WHOLESALES . ' as mw', 'mwp.metric_wholesale_id=mw.metric_wholesale_id')
                        ->where('mwp.market_price_id', $market_price_id)
                        ->get()->result();
    }

    public function fetchMarketRetailPrices($market_price_id) {
        return $this->db
                        ->select('mrp.*, mr.metric')
                        ->from(self::TBL_MARKET_R_PRICES . ' as mrp')
                        ->join(Setup_model::TBL_M_RETAIL . ' as mr', 'mrp.metric_retail_id=mr.metric_retail_id')
                        ->where('mrp.market_price_id', $market_price_id)
                        ->get()->result();
    }

    public function addWholesalePrices($market_price_id, $market_id, $data) {
        $data_whosale = [];
        for ($j = 0; $j < count($data['metric_whole_sale_id']); ++$j) {

            if (trim($data['price_wholesale_high'][$j]) !== '') {
                $data_whosale[] = array(
                    'metric_wholesale_id' => $data['metric_whole_sale_id'][$j],
                    'price_high' => $data['price_wholesale_high'][$j],
                    'price_low' => $data['price_wholesale_low'][$j],
                    'price_ave' => floatval(($data['price_wholesale_low'][$j] + $data['price_wholesale_high'][$j]) / 2),
                    'market_price_id' => $market_price_id,
                    'market_id' => $market_id,
                );
            }
        }

        if (empty($data_whosale)) {
            return FALSE;
        }

        return $this->db->insert_batch(self::TBL_MARKET_W_PRICES, $data_whosale);
    }

    public function addRetailPrices($market_price_id, $market_id, $data) {
        $data_retail = [];
        for ($j = 0; $j < count($data['metric_retail_id']); ++$j) {

            if (trim($data['price_retail_high'][$j]) !== '') {
                $data_retail[] = array(
                    'metric_retail_id' => $data['metric_retail_id'][$j],
                    'price_high' => $data['price_retail_high'][$j],
                    'price_low' => $data['price_retail_low'][$j],
                    'price_ave' => floatval(($data['price_retail_low'][$j] + $data['price_retail_high'][$j]) / 2),
                    'market_price_id' => $market_price_id,
                    'market_id' => $market_id,
                );
            }
        }

        if (empty($data_retail)) {
            return FALSE;
        }

        return $this->db->insert_batch(self::TBL_MARKET_R_PRICES, $data_retail);
    }

    public function fetchPriceLogs() {
        return $this->db
                        ->select('mp.added_by, mp.market_id, m.market_name, u.first_name, u.last_name, count(*) as entry')
                        ->from(self::TBL_MARKET_PRICES . ' as mp')
                        ->join('users as u', 'mp.added_by=u.user_id')
                        ->join(Setup_model::TBL_MARKETS . ' as m', 'mp.market_id=m.market_id')
                        ->group_by('mp.added_by, mp.market_id')
                        ->get()->result();
    }

    public function fetchPriceLogDetails($market_id, $id) {
        return $this->db
                        ->select('mp.market_date, mp.date_added, p.product_name, m.market_name, s.source, v.variety, u.first_name, u.last_name')
                        ->from(self::TBL_MARKET_PRICES . ' as mp')
                        ->join(Setup_model::TBL_PRODUCTS . ' as p', 'mp.product_id=p.product_id')
                        ->join(Setup_model::TBL_MARKETS . ' as m', 'mp.market_id=m.market_id')
                        ->join(Setup_model::TBL_SOURCES . ' as s', 'mp.source_id=s.source_id')
                        ->join(Setup_model::TBL_VARIETIES . ' as v', 'mp.variety_id=v.variety_id', 'left')
                        ->join('users as u', 'mp.added_by=u.user_id')
                        ->where('mp.market_id', $market_id)
                        ->where('mp.added_by', $id)
                        ->get()->result();
    }

    public function fetchProductVarieties($product_id) {
        return $this->db
                        ->select('pv.*, v.variety')
                        ->from('product_varieties as pv')
                        ->join(Setup_model::TBL_VARIETIES . ' as v', 'v.variety_id=pv.variety_id')
                        ->where('pv.product_id', $product_id)
                        ->get()->result();
    }

    public function fetchProductWSMetrics($product_id) {
        return $this->db
                        ->select('pwm.*, mw.metric')
                        ->from('product_wholesale_metrics as pwm')
                        ->join(Setup_model::TBL_M_WHOLESALES . ' as mw', 'mw.metric_wholesale_id=pwm.metric_wholesale_id')
                        ->where('pwm.product_id', $product_id)
                        ->get()->result();
    }

    public function fetchProductRetailMetrics($product_id) {
        return $this->db
                        ->select('prm.*, mr.metric')
                        ->from('product_retail_metrics as prm')
                        ->join(Setup_model::TBL_M_RETAIL . ' as mr', 'mr.metric_retail_id=prm.metric_retail_id')
                        ->where('prm.product_id', $product_id)
                        ->get()->result();
    }

    public function assignUserToMarket($user_id, $data) {
        if (empty($data)) {
            return FALSE;
        }



        if (empty($data['market_id'])) {
            return FALSE;
        }

        $data_db = [];
        foreach ($data['market_id'] as $market_id) {
            $data_db[] = array(
                'user_id' => $user_id,
                'market_id' => $market_id,
                'added_by' => $this->user_auth_lib->get('user_id'),
                'date_added' => date('Y-m-d h:i:s')
            );
        }

        return $this->db->insert_batch('market_access', $data_db);
    }

    public function fetchUserMarkets($user_id) {
        return $this->db
                        ->select('m.market_name, m.market_id')
                        ->from('market_access ma')
                        ->join('markets m', 'ma.market_id=m.market_id')
                        ->where('ma.user_id', $user_id)
                        ->get()->result();
    }

    public function fetchCommPrices($product_id = NULL, $market_id = NULL, $variety_id = null, $ws_metric_id, $start_date = '', $end_date = '') {

        $this->_query_condition($market_id, $product_id, $variety_id);

        if ($ws_metric_id && $ws_metric_id > 0) {
            $this->db->where('mwp.metric_wholesale_id', $ws_metric_id);
        }
        if ($start_date !== '') {
            $this->db->where('mp.market_date >=', date('Y-m-d', strtotime($start_date)));
        }
        if ($end_date !== '') {
            $this->db->where('mp.market_date <=', date('Y-m-d', strtotime($end_date)));
        }

        $categories = [];
        $high_prices = $low_prices = [];
        $pie_data = [];

        $results = $this->db
                        ->select("mp.market_price_id, mp.market_date, avg(mwp.`price_high`) p_high, avg(mwp.`price_low`) p_low, mp.remark, mp.activity ")
                        ->from(self::TBL_MARKET_W_PRICES . ' as mwp')
                        ->join(self::TBL_MARKET_PRICES . ' as mp', 'mp.market_price_id=mwp.market_price_id')
                        ->group_by('mp.market_date')
                        ->get()->result();

        $this->_buildchart_category($categories, $results);
        $this->_buildchart_values($high_prices, $low_prices, $results);
        $this->db->join(self::TBL_MARKET_W_PRICES . ' as mwp', 'mwp.market_price_id=mp.market_price_id');
        $this->_buildpie_values($market_id, $product_id, $variety_id, $start_date, $end_date, $pie_data);

        return array(
            'categories' => $categories,
            'series' => array(['name' => 'Wholesale High', 'data' => $high_prices], ['name' => 'Wholesale Low', 'data' => $low_prices]),
            'pie_data' => $pie_data,
            'allMarkets' => $this->fetchAllMarketAnalytics($categories, $ws_metric_id, $product_id, $variety_id)
        );
    }

    public function fetchAllMarketAnalytics($date_range, $ws_metric_id, $product_id, $variety_id) {
        $markets = $this->fetchAllMarkets();

        if (empty($markets)) {
            return FALSE;
        }

        $main = [];

        foreach ($markets as $aMarket) {
            $prices = [];
            if (!empty($date_range)) {
                foreach ($date_range as $aDate) {
                    $this->_query_condition($aMarket->market_id, $product_id, $variety_id);
                    if ($ws_metric_id && $ws_metric_id > 0) {
                        $this->db->where('mwp.metric_wholesale_id', $ws_metric_id);
                    }
                    $result = $this->db
                                    ->select("mp.market_price_id, mp.market_date, avg(mwp.`price_ave`) p_ave ")
                                    ->from(self::TBL_MARKET_W_PRICES . ' as mwp')
                                    ->join(self::TBL_MARKET_PRICES . ' as mp', 'mp.market_price_id=mwp.market_price_id')
                                    ->group_by('mp.market_date')
                                    ->where('mp.market_date', date('Y-m-d', strtotime($aDate)))
                                    ->get()->row();

                    array_push($prices, $result ? floatval($result->p_ave) : 0);
                }
            }


            $main[] = ['name' => $aMarket->market_name, 'data' => $prices];
        }

        return $main;
    }

    public function fetchAllMarketAnalyticsRetail($date_range, $r_metric_id, $product_id, $variety_id) {

        $markets = $this->fetchAllMarkets();

        if (empty($markets)) {
            return FALSE;
        }

        $main = [];

        foreach ($markets as $aMarket) {
            $prices = [];
            if (!empty($date_range)) {
                foreach ($date_range as $aDate) {
                    $this->_query_condition($aMarket->market_id, $product_id, $variety_id);
                    if ($r_metric_id && $r_metric_id > 0) {
                        $this->db->where('mrp.metric_retail_id', $r_metric_id);
                    }

                    $result = $this->db
                                    ->select("mp.market_price_id, mp.market_date, avg(mrp.`price_ave`) p_ave")
                                    ->from(self::TBL_MARKET_R_PRICES . ' as mrp')
                                    ->join(self::TBL_MARKET_PRICES . ' as mp', 'mp.market_price_id=mrp.market_price_id')
                                    ->group_by('mp.market_date')
                                    ->where('mp.market_date', date('Y-m-d', strtotime($aDate)))
                                    ->get()->row();

                    array_push($prices, $result ? floatval($result->p_ave) : 0);
                }
            }


            $main[] = ['name' => $aMarket->market_name, 'data' => $prices];
        }

        return $main;
    }

    public function fetchCommRetailPrices($product_id = NULL, $market_id = NULL, $variety_id = null, $r_metric_id, $start_date = '', $end_date = '') {

        $this->_query_condition($market_id, $product_id, $variety_id);

        if ($r_metric_id && $r_metric_id > 0) {
            $this->db->where('mrp.metric_retail_id', $r_metric_id);
        }
        if ($start_date !== '') {
            $this->db->where('mp.market_date >=', date('Y-m-d', strtotime($start_date)));
        }
        if ($end_date !== '') {
            $this->db->where('mp.market_date <=', date('Y-m-d', strtotime($end_date)));
        }

        $categories = [];
        $high_prices = $low_prices = [];
        $pie_data = [];

        $results = $this->db
                        ->select("mp.market_price_id, mp.market_date, avg(mrp.`price_high`) p_high, avg(mrp.`price_low`) p_low, mp.remark, mp.activity ")
                        ->from(self::TBL_MARKET_R_PRICES . ' as mrp')
                        ->join(self::TBL_MARKET_PRICES . ' as mp', 'mp.market_price_id=mrp.market_price_id')
                        ->group_by('mp.market_date')
                        ->get()->result();

        $this->_buildchart_category($categories, $results);
        $this->_buildchart_values($high_prices, $low_prices, $results);
        $this->db->join(self::TBL_MARKET_R_PRICES . ' as mrp', 'mrp.market_price_id=mp.market_price_id');
        $this->_buildpie_values($market_id, $product_id, $variety_id, $start_date, $end_date, $pie_data);

        return array(
            'categories' => $categories,
            'pie_data' => $pie_data,
            'series' => array(['name' => 'High', 'data' => $high_prices], ['name' => 'Low', 'data' => $low_prices]),
            'allMarkets' => $this->fetchAllMarketAnalyticsRetail($categories, $r_metric_id, $product_id, $variety_id)
        );
    }

    private function _buildchart_category(&$categories, $results) {
        if (empty($results)) {
            return;
        }

        foreach ($results as $result) {
            array_push($categories, date('d M Y', strtotime($result->market_date)));
        }
    }

    private function _buildchart_values(&$high_prices, &$low_prices, $results) {
        if (empty($results)) {
            return;
        }

        foreach ($results as $result) {
            $remark = (strlen($result->remark) > 0 && substr($result->remark, 0, 1) === '[' ) ? $this->_deriveReason($result->remark) : $result->remark;
            array_push($high_prices, ['y' => floatval($result->p_high), 'note' => ['text' => $remark], 'activity' => ['text' => $result->activity]]);
            array_push($low_prices, ['y' => floatval($result->p_low), 'note' => ['text' => $remark], 'activity' => ['text' => $result->activity]]);
        }
    }

    public function fetchReasons() {
        $reasons = $this->db->get('remarks')->result();

        $remark = [];
        foreach ($reasons as $reason) {
            $remark[$reason->remark_id] = $reason->remark;
        }

        return $remark;
    }

    private function _deriveReason($json) {
        $reasons = $this->fetchReasons();
        $ids = json_decode($json, TRUE);

        $result = '';
        if (!empty($ids)) {
            foreach ($ids as $id) {
                $result .= $reasons[$id] . ' ,';
            }
        }

        return rtrim($result, ' ,');
    }

    private function _query_condition($market_id = null, $product_id = null, $variety_id = null) {
        if ($market_id && $market_id > 0) {
            $this->db->where('mp.market_id', $market_id);
        }
        if ($product_id && $product_id > 0) {
            $this->db->where('mp.product_id', $product_id);
        }
        if ($variety_id && $variety_id > 0) {
            $this->db->where('mp.variety_id', $variety_id);
        }
    }

    private function _buildpie_values($market_id, $product_id, $variety_id, $start_date, $end_date, &$pie_data) {
        $this->_query_condition($market_id, $product_id, $variety_id);
        if ($start_date !== '') {
            $this->db->where('mp.market_date >=', date('Y-m-d', strtotime($start_date)));
        }
        if ($end_date !== '') {
            $this->db->where('mp.market_date <=', date('Y-m-d', strtotime($end_date)));
        }

        $sources = $this->db
                        ->select('mp.source_id, count(1) as kount, s.source')
                        ->from(self::TBL_MARKET_PRICES . ' as mp')
                        ->join(Setup_model::TBL_SOURCES . ' as s', 's.source_id=mp.source_id')
                        ->where('mp.is_exemption', 0)
                        ->group_by('mp.source_id')
                        ->get()->result();

        if (!empty($sources)) {
            foreach ($sources as $s) {
                array_push($pie_data, ['name' => $s->source, 'y' => (int) $s->kount]);
            }
        }
    }

    public function fetchMarketPriceInfo($market_price_id) {
        return $this->db
                        ->select('mp.*, m.market_name, p.product_name')
                        ->from(self::TBL_MARKET_PRICES . ' as mp')
                        ->join(self::TBL_MARKETS . ' as m', 'm.market_id=mp.market_id')
                        ->join(Setup_model::TBL_PRODUCTS . ' as p', 'p.product_id=mp.product_id')
                        ->where('mp.market_price_id', $market_price_id)
                        ->get()->row();
    }

    public function fetchAllMarkets($rowClass = stdClass::class) {
        return $this->db
                        ->select('m.*, s.StateName')
                        ->from('markets m')
                        ->join('states s', 'm.state_id=s.StateID')
                        ->where('m.status', ACTIVE)
                        ->get()->result($rowClass);
    }

    public function fetchMarketProducts($market_id = null, $rowClass = stdClass::class) {
        if ($market_id) {
            $this->db->where('mp.market_id', $market_id);
        }
        $this->db->distinct();
        return $this->db
                        ->select(' p.*, pi.image_url, (SELECT count(1) FROM market_products mp WHERE p.product_id = mp.product_id) as kount')
                        ->from(Setup_model::TBL_PRODUCTS . ' as p')
                        ->join(self::TBL_MARKET_PRODUCTS . ' as mp', 'mp.product_id=p.product_id')
                        ->join('product_images as pi', 'p.product_id=pi.product_id', 'left')
//                        ->join(Setup_model::TBL_MARKETS . ' as m', 'mp.market_id=m.market_id')
                        ->get()->result($rowClass);
    }

    public function fetchMarketProductsApi($market_id = null, $rowClass = stdClass::class) {
        if ($market_id) {
            $this->db->where('mp.market_id', $market_id);
        }
        $this->db->distinct();
        return $this->db
                        ->select(' p.*, pi.image_url, (SELECT count(1) FROM market_products mp WHERE p.product_id = mp.product_id) as kount')
                        ->from(Setup_model::TBL_PRODUCTS . ' as p')
                        ->join(self::TBL_MARKET_PRODUCTS . ' as mp', 'mp.product_id=p.product_id')
                        ->join('product_images as pi', 'p.product_id=pi.product_id', 'left')
//                        ->join('product_varieties as pv', 'p.product_id = pv.product_id', 'left')
//                        ->join('varieties as v', 'pv.variety_id = v.variety_id', 'left')
                        ->order_by('p.product_name')
                        ->get()->result($rowClass);
    }

    public function buildSourceProducts($source_id) {

        $pie_data = [];

        $results = $this->db
                        ->select('mp.product_id, count(mp.product_id) as kount, p.product_name')
                        ->from(self::TBL_MARKET_PRICES . ' as mp')
                        ->join(Setup_model::TBL_PRODUCTS . ' as p', 'p.product_id=mp.product_id')
                        ->where('mp.source_id', $source_id)
                        ->group_by('mp.product_id')
                        ->get()->result();

        if (!empty($results)) {
            foreach ($results as $res) {
                array_push($pie_data, ['name' => $res->product_name, 'y' => (int) $res->kount]);
            }
        }

        return ['pie_data' => $pie_data];
    }

    public function buildSourceProductsPerMarkets($source_id) {

        $pie_data = [];
        $cumm_data = [];

        // fetch all markets
        $markets = $this->db->get_where(self::TBL_MARKETS, ['status' => ACTIVE])->result();

        if (empty($markets)) {
            return [];
        }

        foreach ($markets as $market) {
            $pie_data = [];
            $results = $this->db
                            ->select('mp.product_id, count(mp.product_id) as kount, p.product_name')
                            ->from(self::TBL_MARKET_PRICES . ' as mp')
                            ->join(Setup_model::TBL_PRODUCTS . ' as p', 'p.product_id=mp.product_id')
                            ->where('mp.source_id', $source_id)
                            ->where('mp.market_id', $market->market_id)
                            ->group_by('mp.product_id')
                            ->get()->result();

            if (!empty($results)) {
                foreach ($results as $res) {
                    array_push($pie_data, ['name' => $res->product_name, 'y' => (int) $res->kount]);
                }
                
                $cumm_data[strtolower($market->market_name)] = $pie_data;
            }
        }



        return ['cumm_data' => $cumm_data];
    }

    public function updateRemark($id, $data) {

        $p_info = $this->fetchMarketPriceInfo($id);

        if (isset($data['date_from']) && trim($data['date_to']) !== "") {
            $start_date = date('Y-m-d', strtotime($data['date_from']));
            $end_date = date('Y-m-d', strtotime($data['date_to']));

            if (empty($p_info)) {
                return FALSE;
            }


            if (strtotime($end_date) > strtotime($start_date)) {
                $days = (strtotime($end_date) - strtotime($start_date)) / (60 * 60 * 24);
                for ($i = 1; $i <= $days + 1; $i++) {

                    $this->db->update(self::TBL_MARKET_PRICES, ['remark' => empty($data['remark']) ? '' : json_encode($data['remark']), 'activity' => $data['activity']], ['product_id' => $p_info->product_id, 'market_id' => $p_info->market_id, 'market_date' => $start_date, 'source_id' => $p_info->source_id]);

                    $start_date = date('Y-m-d', strtotime($start_date) + 86400);
                }
            } elseif (strtotime($end_date) == strtotime($start_date)) {
                $this->db->update(self::TBL_MARKET_PRICES, ['remark' => empty($data['remark']) ? '' : json_encode($data['remark']), 'activity' => $data['activity']], ['product_id' => $p_info->product_id, 'market_id' => $p_info->market_id, 'market_date' => $start_date, 'source_id' => $p_info->source_id]);
            }

            return TRUE;
        }

        $this->db->update(self::TBL_MARKET_PRICES, ['remark' => empty($data['remark']) ? '' : json_encode($data['remark']), 'activity' => $data['activity']], ['market_price_id' => $id]);

        return $this->db->affected_rows() > 0;
    }

    public function fetchProductDetails($product_id) {
        if ($product_id && $product_id > 0) {
            $this->db->where('mp.product_id', $product_id);
        }
        $prices = $this->db
                        ->select('mp.*, p.product_name, s.source, m.market_name, v.variety')
                        ->from(self::TBL_MARKET_PRICES . ' as mp')
                        ->join(Setup_model::TBL_PRODUCTS . ' as p', 'p.product_id = mp.product_id')
                        ->join(Setup_model::TBL_SOURCES . ' as s', 'mp.source_id = s.source_id')
                        ->join(Setup_model::TBL_VARIETIES . ' as v', 'mp.variety_id = v.variety_id', 'left')
                        ->join(self::TBL_MARKETS . ' as m', 'mp.market_id = m.market_id')
                        ->order_by('mp.market_date', 'desc')
                        ->limit(1)
                        ->get()->result();

        $result = [];
        foreach ($prices as $price) {
            $result[] = (object) array_merge((array) $price, ['wholesale' => $this->_fetchWholePrice($price->market_price_id)], ['retail' => $this->_fetchRetailPrice($price->market_price_id)]);
        }

        return $result;
    }

    public function processException($data) {
        if (empty($data)) {
            return FALSE;
        }

        if (!isset($data['date_from']) || $data['date_from'] == '') {
            return false;
        }

        if (!isset($data['date_to']) || $data['date_to'] == '') {
            return false;
        }

        // prepare exeption data
        $start_date = date('Y-m-d', strtotime($data['date_from']));
        $end_date = date('Y-m-d', strtotime($data['date_to']));

        if (strtotime($end_date) > strtotime($start_date)) {
            $days = (strtotime($end_date) - strtotime($start_date)) / (60 * 60 * 24);
            for ($i = 1; $i <= $days + 1; $i++) {
                $dd = array(
                    'exemption_date' => $start_date,
                    'market_id' => $data['market_id'],
                    'activity' => $data['activity'],
                    'date_added' => date('Y-m-d h:i:s'),
                    'added_by' => $this->user_auth_lib->get('user_id'),
                );

                $this->db->insert(self::TBL_MARKET_EXCEPTIONS, $dd);
                $this->_saveProductExemption($this->db->insert_id(), $start_date, $data['market_id'], $data['activity']);
                $start_date = date('Y-m-d', strtotime($start_date) + 86400);
            }
        } elseif (strtotime($end_date) == strtotime($start_date)) {
            $dd = array(
                'exemption_date' => $start_date,
                'market_id' => $data['market_id'],
                'activity' => $data['activity'],
                'date_added' => date('Y-m-d h:i:s'),
                'added_by' => $this->user_auth_lib->get('user_id'),
            );
            $this->db->insert(self::TBL_MARKET_EXCEPTIONS, $dd);
            $this->_saveProductExemption($this->db->insert_id(), $start_date, $data['market_id'], $data['activity']);
        } else {
            return FALSE;
        }

        return true;
    }

    private function _saveProductExemption($exemption_id, $market_date, $market_id, $activity) {
        // get all products in the market
        $products = $this->fetchMarketProducts($market_id);
        if (empty($products)) {
            return FALSE;
        }

        foreach ($products as $product) {

            $product_sources = $this->setup_model->getProductSources($product->product_id);

            $data_db = array(
                'market_id' => $market_id,
                'product_id' => $product->product_id,
                'added_by' => $this->user_auth_lib->get('user_id'),
                'date_added' => date('Y-m-d h:i:s'),
                'market_date' => $market_date,
                'activity' => $activity,
                'is_exemption' => $exemption_id,
            );

            if (empty($product_sources)) {
                continue;
            }

            foreach ($product_sources as $p_source) {
                $data_db['source_id'] = $p_source->source_id;
                $this->db->insert(self::TBL_MARKET_PRICES, $data_db);
                $market_price_id = $this->db->insert_id();

                $this->_insertMetricWS_price($market_price_id, $market_id, $product->product_id);
                $this->_insertMetricRT_price($market_price_id, $market_id, $product->product_id);
            }
        }

        return;
    }

    private function _insertMetricWS_price($market_price_id, $market_id, $product_id) {
        // get product WS Metrics
        $metrics = $this->setup_model->getProductWMetrics($product_id);
        $data_db = [];
        if (!empty($metrics)) {
            foreach ($metrics as $metric) {
                $data_db[] = ['market_price_id' => $market_price_id, 'metric_wholesale_id' => $metric->metric_wholesale_id, 'price_high' => 0, 'price_low' => 0, 'price_ave' => 0, 'market_id' => $market_id];
            }

            $this->db->insert_batch(self::TBL_MARKET_W_PRICES, $data_db);
        }

        return;
    }

    private function _insertMetricRT_price($market_price_id, $market_id, $product_id) {
        // get product WS Metrics
        $metrics = $this->setup_model->getProductRMetrics($product_id);
        $data_db = [];
        if (!empty($metrics)) {
            foreach ($metrics as $metric) {
                $data_db[] = ['market_price_id' => $market_price_id, 'metric_retail_id' => $metric->metric_retail_id, 'price_high' => 0, 'price_low' => 0, 'price_ave' => 0, 'market_id' => $market_id];
            }

            $this->db->insert_batch(self::TBL_MARKET_R_PRICES, $data_db);
        }

        return;
    }

    public function fetchAllExemptions() {
        return $this->db
                        ->select('ex.*, m.market_name, u.first_name, u.last_name, p.product_name')
                        ->from(self::TBL_MARKET_EXCEPTIONS . ' as ex')
                        ->join(self::TBL_MARKETS . ' as m', 'm.market_id=ex.market_id')
                        ->join('products as p', 'p.product_id=ex.product_id', 'left')
                        ->join('users u', 'ex.added_by=u.user_id')
                        ->get()->result();
    }

}
