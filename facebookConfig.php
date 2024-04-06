<?php
 if(!session_id()) {
    session_start();
}

  require_once ('Facebook/autoload.php');
$FBObject = new \Facebook\Facebook([
  'app_id'         => '406730481434544',
  'app_secret'     => '9f79d41bac2d84d0ef8ee5119dadb23c',
  'default_graph_version'  => 'v2.10'
]);
 
$handler=$FBObject-> getRedirectLoginHelper();
/*if (isset($_GET['state'])) {
    $handler->getPersistentDataHandler()->set('state', $_GET['state']);
}*/

  