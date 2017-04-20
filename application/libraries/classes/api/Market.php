<?php

namespace api;
/**
 * Description of Market
 *
 * @author tohir
 */
class Market extends \db\Entity {
    public function jsonSerialize() {
        $data = array(
            'market_id' => $this->market_id,
            'market_name' => $this->market_name,
            'market_location' => $this->location,
            'market_state' => $this->StateName
        );
        
        return $data;
    }
}
