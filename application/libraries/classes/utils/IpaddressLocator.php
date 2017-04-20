<?php

namespace utils;

//error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
error_reporting(0);

class IpaddressLocator {
	
	public static function fetchIpaddressCityCountry($ipAddr) {
		try {
			return file_get_contents("http://ip-api.com/json/".$ipAddr, 0, stream_context_create(array(
				'http' => array(
					'timeout' => 10
				)
			))) ? : '';
		}catch(Exception $ex) {
			$ex->getMessage();
		}
	}
}
