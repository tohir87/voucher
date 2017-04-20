<?php

require_once 'Lib.php';

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * Description of Product_lib
 *
 * @author tohir
 */
class Product_lib extends Lib {

    private $seasons = [];

    public function __construct() {
        parent::__construct();

        $this->seasons = [
            IN_SEASON => 'In Season',
            NEARING_SEASON_END => 'Nearing Season End',
            NOT_IN_SEASON => 'Out In Season',
        ];
    }

    public function getSeasons() {
        return $this->seasons;
    }

}
