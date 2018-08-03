<?php

require_once "vendor/autoload.php";
// Sesion activa requerida
if(!session_id()) {
    session_start();
}

$fb = null;
try {
    $fb = new Facebook\Facebook([
        'app_id' => '1902563839808600',
        'app_secret' => '81d0249f8752a9b856736b312b230f2c',
        'default_graph_version' => 'v2.2',
    ]);
} catch (\Facebook\Exceptions\FacebookSDKException $e) {
    echo "ERROR: ".$e->getMessage();
    exit;
}


if( isset( $_SESSION['fb_access_token'] ) ){
    if( !empty( $_SESSION['fb_access_token'] ) )
        load();
    else
        init();
}
else
    init();


/**
 * Inicializando cuando no hay token
 */
function init(){
    global $fb;
    $helper = $fb->getRedirectLoginHelper();

    $permissions = ['email']; // Optional permissions
    $loginUrl = $helper->getLoginUrl('http://localhost/otros/facebook-oauth/fb-callback.php', $permissions);

    echo '<a href="' . htmlspecialchars($loginUrl) . '">Iniciar sesion con facebook</a>';
}

/**
 * Obteniendo datos
 */
function load(){
    global $fb;
    $token = $_SESSION['fb_access_token'];

    $response = null;
    try {
        // Returns a `Facebook\FacebookResponse` object
        $response = $fb->get('/me?fields=id,email,picture.width(200).height(200),first_name,last_name', $token);
    } catch(Facebook\Exceptions\FacebookResponseException $e) {
        echo 'Graph returned an error: ' . $e->getMessage();
        exit;
    } catch(Facebook\Exceptions\FacebookSDKException $e) {
        echo 'Facebook SDK returned an error: ' . $e->getMessage();
        exit;
    }

    try {
        //puede usarse como array asociativo o como objeto
        $user = $response->getGraphUser();
    } catch (\Facebook\Exceptions\FacebookSDKException $e) {
        echo 'Facebook SDK returned an error: ' . $e->getMessage();
        exit;
    }

    echo "<h1>Iniciado sesion</h1>";
    echo "<br>";
    echo "TOKEN: ".$token;
    echo "<br><br>";
    echo "<h3>Usuario</h3>";
    echo "ID: ".$user->getId();
    echo "<br>";
//    echo "Nombre: ".$user['name'];
//    echo "<br>";
    echo "Nombre: ".$user['first_name']." ".$user['last_name'];
    echo "<br>";
    echo '<img src="'.$user->getPicture()->getUrl().'"/>';
    echo "<br>";
    echo '<a href="logout.php">Cerrar sesion</a>';

}