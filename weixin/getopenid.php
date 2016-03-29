<?php

//require_once('protected/sdk/pingpp-php-master/init.php');
$urlWeixinConfig = dirname(__FILE__) . '/../protected/models/weixin/WeixinConfig.php';
require_once($urlWeixinConfig);

/* * ****** Settings ******* */
//$urlGetWxCode = 'http://md.mingyizhudao.com/weixin/getWxCode';
$urlGetWxCode = 'http://md.mingyizhudao.com/test/getWxCode';
//$urlGetWxCode = 'http://mingyizhudao.com/weixin/getWxCode';
//$wxConfig = new WeixinConfig();
//$wxAppId = $wxConfig->getAppId();

/* * ****** get parameters from request ******* */
// refno, returnurl.
$querystring = $_SERVER['QUERY_STRING'];
$urlGetWxCode .='?' . $querystring;

header('Location: ' . $urlGetWxCode);