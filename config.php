<?php

define('APP_ID',            '1902563839808600');
define('APP_SECRET',        '81d0249f8752a9b856736b312b230f2c');
define('APP_VER',           'v3.1');
define('HOST',              'http://localhost/fbtest/');
// define('HOST',          'https://95b7796f.ngrok.io');
// define('REDIRECT_HOST', 'http://localhost/fbtest/fb-callback.php');


require_once "vendor/autoload.php";

// Sesion activa requerida
if(!session_id()) {
    session_start();
}

try {
    $fb = new Facebook\Facebook([
        'app_id'                => APP_ID,
        'app_secret'            => APP_SECRET,
        'default_graph_version' => APP_VER,
    ]);
} catch (\Facebook\Exceptions\FacebookSDKException $e) {
    echo "ERROR: ".$e->getMessage();
    exit;
}