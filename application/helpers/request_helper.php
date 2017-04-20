<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

if (!function_exists('request_is_post')) {

    function request_is_post() {
        return $_SERVER['REQUEST_METHOD'] === 'POST';
    }

}

if (!function_exists('request_is_get')) {

    function request_is_get() {
        return $_SERVER['REQUEST_METHOD'] === 'GET';
    }

}

if (!function_exists('request_post_data')) {

    function request_post_data() {
        return get_instance()->input->post();
    }

}

if (!function_exists('request_bad_request')) {

    function request_bad() {
        return header('HTTP/1.1 400 Bad Request');
    }

}

if (!function_exists('request_forbidden')) {

    function request_forbidden() {
        return header('HTTP/1.1 403 Forbidden');
    }

}
