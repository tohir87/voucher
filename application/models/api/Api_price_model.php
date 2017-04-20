<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * Description of Api_price_model
 *
 * @author tohir
 * @property Setup_model $setup_model Description
 */
class Api_price_model extends CI_Model {

    const TBL_MARKETS = 'markets';
    const TBL_MARKET_PRICES = 'market_prices';
    const TBL_MARKET_W_PRICES = 'market_wholesale_price';
    const TBL_MARKET_R_PRICES = 'market_retail_price';
    const TBL_MARKET_PRODUCTS = 'market_products';

    public function fetchProductPrices($product_id) {
        $markets_products = $this->getMarketProducts($product_id);


        $result = [];

        if (empty($markets_products)) {
            return $result;
        }

        $default = [
            'product_id' => $product_id,
            'product_name' => $markets_products[0]->product_name,
            'product_image' => $markets_products[0]->image_url,
            'description' => $markets_products[0]->product_desc,
            'market_date' => $markets_products[0]->m_date,
            'market_date_str' => date('d M Y', strtotime($markets_products[0]->m_date)),
        ];

        // get varieties
        $product_varieties = $this->setup_model->getProductVarieties($product_id);
        $default['variety_count'] = !empty($product_varieties) ? count($product_varieties) : 0;

        if (!empty($product_varieties)) {
            foreach ($product_varieties as $variety) {
                $markets = [];
                foreach ($markets_products as $market) {
                    $market_price_id = $this->_getLastestMarketPrice($product_id, $variety->variety_id, $market->market_id, $markets_products[0]->m_date);
                    $markets[] = array(
                        'market_name' => $market->market_name, 'retail_price' => $this->_fetchRetailPrice($market_price_id)
                    );
                }
                $result['varieties'][] = ['variety_name' => $variety->variety, 'markets' => $markets];
            }
        } else {
            $markets = [];
            foreach ($markets_products as $market) {
                $market_price_id = $this->_getLastestMarketPrice($product_id, 0, $market->market_id, $markets_products[0]->m_date);
                $markets[] = array(
                    'market_name' => $market->market_name, 'retail_price' => $this->_fetchRetailPrice($market_price_id)
                );
            }
            // $result['varieties'][] = ['variety_name' => $markets_products[0]->product_name, 'markets' => $markets];
            $result['markets'] = $markets;
        }


        return array_merge($default, $result);
    }

    private function _getLastestMarketPrice($product_id, $variety_id = 0, $market_id = null, $date = null) {
        if (!is_null($market_id)) {
            $this->db->where('market_id', $market_id);
        }
        if (!is_null($date)) {
            $this->db->where('market_date', $date);
        }
        $w = $this->db->select()->from(Market_model::TBL_MARKET_PRICES)->where('product_id', $product_id)->where('variety_id', $variety_id)->order_by('market_price_id', 'desc')->limit(1)->get()->result();
        
        return $w[0]->market_price_id;
    }

    public function fetchProductPriceByMarket($product_id, $variety_id = NULL) {
        $markets_products = $this->getMarketProducts($product_id, $variety_id);


        $result = [];

        if (empty($markets_products)) {
            return $result;
        }

        $default = [
            'product_id' => $product_id,
            'product_name' => $markets_products[0]->product_name,
            'product_image' => $markets_products[0]->image_url,
            'description' => $markets_products[0]->product_desc,
            'market_date' => $markets_products[0]->m_date,
            'market_date_str' => date('d M Y', strtotime($markets_products[0]->m_date)),
        ];

        // get wholesale metrics
//        $w_metrics = $this->setup_model->fetchProductWsMetrics($product_id);
//
//        if (!empty($w_metrics)) {
//            foreach ($w_metrics as $metric) {
//                $res = [];
//
//                foreach ($markets_products as $market) {
//                    $w_prices = $this->_fetchWholePrice($market->mid, $metric->metric_wholesale_id);
//                    $res[] = ['market_name' => $market->market_name, 'price' => $w_prices ? $w_prices[0]->price_high : '-'];
//                }
//
//                $result['wholesale_metrics'][] = array_merge(['metric' => $metric->metric, 'markets' => $res]);
//            }
//        }
        // get retail metrics
        $r_metrics = $this->setup_model->fetchProductRtMetrics($product_id);

        if (!empty($r_metrics)) {
            foreach ($r_metrics as $metric) {
                $res = [];

                foreach ($markets_products as $market) {
                    $market_price_id = $this->_getLastestMarketPrice($product_id, 0, $market->market_id, $markets_products[0]->m_date);
                    $r_prices = $this->_fetchRetailPrice($market_price_id, $metric->metric_retail_id, $market->market_id);
                    $res[] = ['market_name' => $market->market_name, 'price' => $r_prices ? $r_prices[0]->price_high : '-'];
                    $r_prices = [];
                }

                $result['retail_metrics'][] = array_merge(['metric' => $metric->metric, 'markets' => $res]);
            }
        }

        return array_merge($default, $result);
    }

    public function fetchProductPriceByMarketWeb($product_id) {
        $markets_products = $this->getMarketProducts($product_id);

        $result = [];

        if (empty($markets_products)) {
            return $result;
        }

        $default = [
            'product_id' => $product_id,
            'product_name' => $markets_products[0]->product_name,
            'product_image' => $markets_products[0]->image_url,
            'description' => $markets_products[0]->product_desc,
            'market_date' => $markets_products[0]->m_date,
            'market_date_str' => date('d M Y', strtotime($markets_products[0]->m_date)),
        ];

        // get wholesale metrics
        $w_metrics = $this->setup_model->fetchProductWsMetrics($product_id);

        if (!empty($w_metrics)) {
            foreach ($w_metrics as $metric) {
                $res = [];

                foreach ($markets_products as $market) {
                    $w_prices = $this->_fetchWholePrice($market->mid, $metric->metric_wholesale_id);
                    $res[$market->market_name] = $w_prices ? $w_prices[0]->price_high : '-';
                }

                $result['wholesale_metrics'][] = array_merge(['metric' => $metric->metric], $res);
            }
        }

        // get retail metrics
        $r_metrics = $this->setup_model->fetchProductRtMetrics($product_id);

        if (!empty($r_metrics)) {
            foreach ($r_metrics as $metric) {
                $res = [];

                foreach ($markets_products as $market) {
                    $r_prices = $this->_fetchRetailPrice($market->mid, $metric->metric_retail_id, $market->market_id);
                    $res[$market->market_name] = $r_prices ? $r_prices[0]->price_high : '-';
                }

                $result['retail_metrics'][] = array_merge(['metric' => $metric->metric], $res);
            }
        }

        return array_merge($default, $result);
    }

    public function getMarketProducts($product_id) {

        return $this->db
                        ->select("mp.* , p.product_name, p.product_desc, m.market_name, pi.image_url, "
                                . "(select mps.market_price_id from market_prices mps where mps.product_id = mp.product_id and mps.market_id=mp.market_id and mps.is_exemption = 0 order by mps.market_price_id desc limit 1 ) as mid, "
                                . "(select mps.market_date from market_prices mps where mps.product_id = mp.product_id and mps.is_exemption = 0 order by mps.market_price_id desc limit 1 ) as m_date")
                        ->from('market_products as mp')
                        ->join('products p', 'p.product_id = mp.product_id')
                        ->join('markets m', 'm.market_id = mp.market_id')
//                        ->join('market_retail_price mrp', 'mrp.market_price_id = mps.mid')
                        ->join('product_images pi', 'p.product_id=pi.product_id', 'left')
                        ->where('mp.product_id', $product_id)
                        ->get()->result();
    }

    private function _fetchWholePrice($market_price_id, $metric_wholesale_id = null) {
        if (!is_null($metric_wholesale_id)) {
            $this->db->where('mwp.metric_wholesale_id', $metric_wholesale_id);
        }
        return $this->db
                        ->select('mwp.price_high, mwp.price_low, mwp.price_ave, mw.metric')
                        ->from(self::TBL_MARKET_W_PRICES . ' as mwp')
                        ->join(Setup_model::TBL_M_WHOLESALES . ' as mw', 'mwp.metric_wholesale_id=mw.metric_wholesale_id')
                        ->where('mwp.market_price_id', $market_price_id)
                        ->get()->result();
    }

    private function _fetchRetailPrice($market_price_id, $metric_retail_id = null, $market_id = null) {
        if (!is_null($metric_retail_id)) {
            $this->db->where('mrp.metric_retail_id', $metric_retail_id);
        }
        if (!is_null($market_id)) {
            $this->db->where('mrp.market_id', $market_id);
        }
        return $this->db
                        ->select('mrp.price_high, mrp.price_low, mrp.price_ave,mr.metric')
                        ->from(self::TBL_MARKET_R_PRICES . ' as mrp')
                        ->join(Setup_model::TBL_M_RETAIL . ' as mr', 'mrp.metric_retail_id=mr.metric_retail_id')
                        ->where('mrp.market_price_id', $market_price_id)
                        ->get()->result();
    }

    private function _getSubCategoriesSerialized($category_id) {
        $result = [];
        $subs = $this->db->get_where('sub_categories', ['category_id' => $category_id])->result();
        if (!empty($subs)) {
            foreach ($subs as $aSub) {
                array_push($result, $aSub->sub_category_id);
            }
        }

        return $result;
    }

    public function getProductsByCategory($category_id, $rowClass = stdClass::class) {
        $subCateIDs = $this->_getSubCategoriesSerialized($category_id);
        if (!empty($subCateIDs)) {
            $this->db->where_in('p.sub_category_id', $subCateIDs);
            $products = $this->db
                            ->select('mp.*, p.product_name, p.season_id, p.product_desc, m.market_name, pi.image_url, (SELECT count(1) FROM market_products mp WHERE p.product_id = mp.product_id) as kount')
                            ->from(Setup_model::TBL_PRODUCTS . ' as p')
                            ->join(self::TBL_MARKET_PRODUCTS . ' as mp', 'mp.product_id=p.product_id')
                            ->join('product_images as pi', 'p.product_id=pi.product_id', 'left')
                            ->join(Setup_model::TBL_MARKETS . ' as m', 'mp.market_id=m.market_id')
                            ->join('product_varieties as pv', 'p.product_id = pv.product_id', 'left')
//                            ->join('varieties as v', 'pv.variety_id = v.variety_id', 'left')
                            ->group_by('p.product_id')
//                            ->group_by('pv.variety_id')
                            ->order_by('p.product_name')
                            ->get()->result($rowClass);
        } else {
            $products = [];
        }
        return $products;
    }

    public function searchProducts($product_name, $rowClass = stdClass::class) {
        return $this->db
                        ->select('mp.*, p.product_name, p.season_id, p.product_desc, m.market_name, pi.image_url, (SELECT count(1) FROM market_products mp WHERE p.product_id = mp.product_id) as kount')
                        ->from(Setup_model::TBL_PRODUCTS . ' as p')
                        ->join(self::TBL_MARKET_PRODUCTS . ' as mp', 'mp.product_id=p.product_id')
                        ->join('product_images as pi', 'p.product_id=pi.product_id', 'left')
                        ->join(Setup_model::TBL_MARKETS . ' as m', 'mp.market_id=m.market_id')
                        ->like('p.product_name', trim($product_name))
                        ->group_by('p.product_id')
                        ->get()->result($rowClass);
    }

}
