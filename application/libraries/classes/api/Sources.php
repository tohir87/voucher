<?php

namespace api;

/**
 * Description of Sources
 *
 * @author tohir
 */
class Sources extends \db\Entity {

    public function jsonSerialize() {
        return array(
            'source_id' => $this->source_id,
            'source_name' => $this->source,
            'description' => $this->description,
        );
    }

}
