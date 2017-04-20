<?php

namespace api;

/**
 * Description of Products
 *
 * @author tohir
 */
class Products extends \db\Entity {
    public function jsonSerialize() {
        return array(
            'product_id' => $this->product_id,
            'product_name' => $this->product_name,
//            'variety_id' => $this->variety_id,
//            'variety' => $this->variety,
            'season' => $this->season_id,
            'image' => $this->image_url,
            'available' => $this->kount,
            'description' => str_replace("&nbsp;", ' ', strip_tags($this->product_desc)),
        );
    }
}
