<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$environment = defined('ENVIRONMENT') ? ENVIRONMENT : 'development';


$config['smtp_crypto'] = 'tls';
$config['smtp_port'] = 2525;
$config['mailtype'] = 'html';
$config['protocol'] = 'smtp';
$config['charset'] = 'utf-8';
$config['bcc_batch_mode'] = true;
$config['newline'] = "\r\n";

if ($environment === 'production') {
    $config['smtp_host'] = 'smtp.mailgun.org';
    $config['smtp_user'] = 'postmaster@sandbox27d6c78dc91b4c36ace48815d61ad5be.mailgun.org';
    $config['smtp_pass'] = '7a3ade8e0daa9eb3f4786eadbd68658a';
} elseif ($environment === 'testing') {
    $config['smtp_host'] = 'smtp.mailgun.org';
    $config['smtp_user'] = 'postmaster@sandbox27d6c78dc91b4c36ace48815d61ad5be.mailgun.org';
    $config['smtp_pass'] = '7a3ade8e0daa9eb3f4786eadbd68658a';
} else {
    $config['smtp_host'] = 'mailtrap.io';
    $config['smtp_user'] = '27784b00f2e7e28ac';
    $config['smtp_pass'] = 'd3b33d3d362c6c';
}
