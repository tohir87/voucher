<?php

namespace api;

/**
 * Description of Categories
 *
 * @author tohir
 */
class Categories extends \db\Entity {

    public function jsonSerialize() {
        return [
            'category_id' => $this->category_id,
            'category_name' => $this->category_name
        ];
    }

}
