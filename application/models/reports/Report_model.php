<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * Description of Report_model
 *
 * @author tohir
 * @property CI_Loader $load Description
 * @property Basic_model $basic_model Description
 */
class Report_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function buildProductExcelReport($params, $data) {
        
        $intro_data = array();
        $intro_data[] = array('Market', (int) $params['market_id'] > 0 ? $this->basic_model->getMarketById($params['market_id']) : 'All Markets');
        $intro_data[] = array('Product', (int) $params['product_id'] > 0 ? $this->basic_model->getProductById($params['product_id']) : 'All products');
        
        $intro_data[] = array('Period', $params['start_date'] . ' to ' . $params['end_date']);

        $bday_data = [];
        $report_header = array('Product', 'Market', 'Source', 'Metric', 'Price High', 'Price Low', 'Market Date');
        if (!empty($data)) {
            foreach ($data as $d) {
                $bday_data[] = array($d->product_name,
                    $d->market_name,
                    $d->source, $d->wholesale, $d->retail, $d->market_date);
            }
        }

        $download = 'Product_Report';
        $this->load->library('csv_lib');
        $this->csv_lib->product_report($intro_data,$report_header, $bday_data, $download);
        
    }

}
