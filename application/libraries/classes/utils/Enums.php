<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace utils;

/**
 * Description of Enums
 *
 * @author Tohir
 */
class Enums {

    public static function getAdsLocation() {
        return [
            ADS_LOC_DASHBOARD => 'App Dashboard',
            ADS_LOC_PRODUCT_LIST => 'Product List',
            ADS_LOC_PRODUCT_VIEW => 'Product View',
        ];
    }

}
