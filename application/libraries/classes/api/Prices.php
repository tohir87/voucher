<?php


namespace api;

/**
 * Description of Prices
 *
 * @author tohir
 */
class Prices extends \db\Entity {
    public function jsonSerialize() {
        return array(
            'market_price_id' => $this->market_price_id,
            'market_date' => date('d M Y', strtotime($this->market_date)),
            'product_name' => $this->product_name,
            'wholesale_price' => array(
                'high' => $this->wholesale['price_high'],
                'low' => $this->wholesale['price_low'],
                'average' => $this->wholesale['price_ave'],
            ),
            'retail' => array(
                'high' => $this->retail['price_high'],
                'low' => $this->retail['price_low'],
                'average' => $this->retail['price_ave'],
            )
                
        );
    }
}
