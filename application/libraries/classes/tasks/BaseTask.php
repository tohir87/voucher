<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace tasks;

use db\Entity;
use utils\Enums;

/**
 * Description of BaseTask
 *
 * @author JosephT
 */
class BaseTask extends Entity {

    public static $jsonFieldFilterMap = [];

    public function getFrom() {
        return array(
            'id' => intval($this->id_user_from),
            'first_name' => $this->first_name,
            'middle_name' => $this->middle_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
        );
    }

    public static function findStatus($status) {
        return array_search($status, Enums::getTaskStatuses());
    }

    public static function getStatus($status_str) {
        return array_key_exists($status_str, Enums::getTaskStatuses()) ? Enums::getTaskStatuses() : null;
    }

    protected function _formatDate($val, $format = 'Y-m-d') {
        return $val ? date($format, strtotime($val)) : null;
    }

    public function getTaskUrl() {
        $matches = [];
        if (preg_match('/href=[\'"](.+)[\'"]/', $this->subject, $matches)) {
            return $matches[1];
        }
        return null;
    }

    public function getAttachment() {
        if ($this->attachment_file) {
            $this->load->library('storage');
            return array(
                'title' => $this->attachment_title,
                'url' => $this->storage->temporary_url($this->attachment_file),
            );
        }
        return null;
    }

    public function getAssignedTo() {
        if ($this->to_email) {
            return [
                'first_name' => $this->to_first_name,
                'last_name' => $this->to_last_name,
                'middle_name' => $this->to_middle_name,
                'email' => $this->to_email,
            ];
        }
        return null;
    }

}
