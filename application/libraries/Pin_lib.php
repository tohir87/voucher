<?php

require_once 'Lib.php';

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Pin_lib
 *
 * @author tohir
 */
class Pin_lib extends Lib {

    public function __construct() {
        parent::__construct();
    }

    public function processPin($data, $file) {
        if (empty($data) || empty($file)) {
            return FALSE;
        }

        $this->db->trans_start();

        // create batch
        $this->db->insert('batches', [
            'provider_id' => $data['provider_id'],
            'batch_date' => date('Y-m-d'),
            'batch_time' => date('H:i:s'),
        ]);

        $batch_id = $this->db->insert_id();

        $data_db = [];

        if ($file = fopen($file['tmp_name'], "r")) {
            while (!feof($file)) {
                $pin = $serial = '';
                $line = fgets($file);
                if (strlen(trim($line)) > 0) {
                    list($pin, $serial) = explode(',', $line);
                    $data_db[] = ['pin_code' => trim($pin), 'pin_serial' => trim($serial), 'batch_id' => $batch_id];
                }

                # do same stuff with the $line
            }
            fclose($file);
        }

        if (!empty($data_db)) {
            $this->db->insert_batch('pins', $data_db);
        }

        $this->db->trans_complete();

        return $this->db->trans_status() ? TRUE : FALSE;
    }

}
