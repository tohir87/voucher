<?php

/**
 * Description of Bugsnag
 *
 * @author tohir
 */
class Bugsnag {

    private $client;

    public function __construct() {
        $bugsnag = Bugsnag\Client::make(BUGSNAG_API_KEY);
        Bugsnag\Handler::register($bugsnag);
        
    }

}
