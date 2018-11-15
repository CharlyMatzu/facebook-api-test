<?php

include_once "config.php";



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
    $loginUrl = $helper->getLoginUrl(HOST . '/fb-callback.php', $permissions);

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
        $response = $fb->get(
            '/2143932362292834/comments',
            $token
        );
        
    } catch(Facebook\Exceptions\FacebookResponseException $e) {
        echo 'Graph returned an error: ' . $e->getMessage();
        exit;
    } catch(Facebook\Exceptions\FacebookSDKException $e) {
        echo 'Facebook SDK returned an error: ' . $e->getMessage();
        exit;
    }

    
    try {
        //puede usarse como array asociativo o como objeto
        $graphNode = $response->getGraphUser();
    } catch (\Facebook\Exceptions\FacebookSDKException $e) {
        echo 'Facebook SDK returned an error: ' . $e->getMessage();
        exit;
    }

    


}