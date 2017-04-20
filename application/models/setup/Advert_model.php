<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * Description of Advert_model
 *
 * @author tohir
 * @property CI_DB_query_builder $db Description
 */
class Advert_model extends CI_Model {

    const TBL_ADVERTS = 'adverts';

    private $config;

    public function __construct() {
        parent::__construct();
        $this->load->database();

        $this->config = array(
            'upload_path' => FILE_PATH_ADS_IMG,
            'allowed_types' => "jpg|jpeg|gif|png",
            'overwrite' => TRUE,
            'max_size' => "102400", // Can be set to particular file size , here it is 2 MB(2048 Kb)
            'max_height' => "3000",
            'max_width' => "3000",
        );
    }

    public function fetch_all_adverts($rowClass = stdClass::class) {
        return $this->db->get_where(self::TBL_ADVERTS, ['status' => ACTIVE])->result($rowClass);
    }

    public function save_ads($data, $logo) {
        if (empty($data)) {
            notify('error', 'Invalid parameter passed');
            return FALSE;
        }

        if (!empty($logo) && $logo['name'] !== '') {

            $ext = end((explode(".", $logo['name'])));

            $logo_name = md5(microtime()) . '.' . $ext;
            $this->config['file_name'] = $logo_name;

            $this->load->library('upload', $this->config);
            if (!$this->upload->do_upload()) {

                $error = array('error' => $this->upload->display_errors());
                notify('error', 'Invalid file uploaded');
                return FALSE;
            }
            
            $data['ad_image'] = $logo_name;
            $data['ad_image_url'] = site_url('/files/ads_image/' . $logo_name);
        }

        
        $data['date_added'] = date('Y-m-d H:i:s');
        $data['start_date'] = date('Y-m-d', strtotime($data['start_date']));
        $data['end_date'] = date('Y-m-d', strtotime($data['end_date']));
        $data['ad_link'] = $data['ad_link'];
        $data['added_by'] = $this->user_auth_lib->get('user_id');

        $this->db->insert(self::TBL_ADVERTS, $data);

        return TRUE;
    }

    public function update_ads($id, $data, $logo) {
        if (empty($data)) {
            notify('error', 'Invalid parameter passed');
            return FALSE;
        }

        if (!empty($logo) && $logo['name'] !== '') {

            $ext = end((explode(".", $logo['name'])));



            $logo_name = md5(microtime()) . '.' . $ext;
            $this->config['file_name'] = $logo_name;

            $this->load->library('upload', $this->config);
            if (!$this->upload->do_upload()) {

                $error = array('error' => $this->upload->display_errors());
                notify('error', 'Invalid file uploaded');
                return FALSE;
            }
            $data['ad_image'] = $logo_name;
            $data['ad_image_url'] = site_url('/files/ads_image/' . $logo_name);
        }


        $data['date_updated'] = date('Y-m-d H:i:s');
        $data['start_date'] = date('Y-m-d', strtotime($data['start_date']));
        $data['end_date'] = date('Y-m-d', strtotime($data['end_date']));
        $data['ad_link'] = $data['ad_link'];

        $this->db->update(self::TBL_ADVERTS, $data, ['advert_id' => $id]);


        return $this->db->affected_rows() > 0;
    }

    public function fetch_ad() {
//        $sql = "SELECT * FROM adverts AS r1 
//                JOIN (SELECT (RAND() * (SELECT MAX(advert_id) 
//                FROM adverts )) AS id) AS r2 WHERE r1.advert_id >= r2.id 
//                ORDER BY r1.advert_id ASC 
//                LIMIT 0 ";
//        return $this->db->query($sql)->row();
        return $this->db->select('*')
                        ->from(self::TBL_ADVERTS)
                        ->where('end_date >=', date('Y-m-d'))
                        ->where('status', ACTIVE)
                        ->limit(1)
                        ->get()->row();
    }

}
