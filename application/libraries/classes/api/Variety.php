<?php

namespace api;

/**
 * Description of Variety
 *
 * @author tohir
 */
class Variety extends \db\Entity {
    public function jsonSerialize() {
        return array(
            'variety_id' => $this->variety_id,
            'variety_name' => $this->variety,
            'description' => $this->description
        );
    }
}
