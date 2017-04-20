<?php

namespace api;

/**
 * Description of Adverts
 *
 * @author tohir
 */
class Adverts extends \db\Entity {

    public function jsonSerialize() {
        return [
            'ad_name' => $this->ad_name,
            'client_name' => $this->client_name,
            'image' => $this->ad_image_url,
            'ad_link' => $this->ad_link,
            'ad_location' => \utils\Enums::getAdsLocation()[$this->location_id],
            'start_date' => date('d-M-Y', strtotime($this->start_date)),
            'end_date' => date('d-M-Y', strtotime($this->end_date))
        ];
    }

}
